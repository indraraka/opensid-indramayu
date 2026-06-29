<?php

/**
 * register_themes.php — daftarkan tema Garuda (garuda + garuda-ternama-1..9) ke
 * tabel `theme` milik sebuah instalasi OpenSID, lalu (opsional) aktifkan satu tema.
 *
 * Membaca kredensial DB dari `desa/config/database.php` milik instalasi itu sendiri,
 * sehingga tidak perlu menyalin kredensial ke mana pun. Idempoten: baris milik kita
 * (slug desa-garuda*) dihapus lalu di-insert ulang.
 *
 * Penggunaan:
 *   php register_themes.php <path_public_html> [activate=desa-garuda|none]
 *
 * Mencetak PREV_ACTIVE=<slug> agar pemanggil dapat menyimpan tema sebelumnya
 * untuk keperluan rollback.
 */
$root     = rtrim($argv[1] ?? '', '/');
$activate = 'desa-garuda';
if (isset($argv[2]) && str_starts_with($argv[2], 'activate=')) {
    $activate = substr($argv[2], strlen('activate='));
}
if ($root === '' || ! is_dir($root)) {
    fwrite(STDERR, "ERR: path tidak valid: {$root}\n");
    exit(2);
}

$dbfile = $root . '/desa/config/database.php';
if (! is_file($dbfile)) {
    fwrite(STDERR, "ERR: database.php tidak ditemukan di {$dbfile}\n");
    exit(2);
}
mysqli_report(MYSQLI_REPORT_OFF); // tangani galat koneksi manual, jangan melempar

$db = [];
require $dbfile;
$d = $db['default'] ?? null;
if (! $d) {
    fwrite(STDERR, "ERR: konfigurasi \$db['default'] tidak ada\n");
    exit(2);
}

// Password mungkin TERENKRIPSI (Laravel encrypter) bila panjang > 80 — persis
// seperti donjo-app/config/database.php. Dekripsi memakai app_key milik desa
// dan kelas Encrypter dari vendor instalasi itu sendiri (kompatibel 100%).
$pass = (string) $d['password'];
if (strlen($pass) > 80) {
    $autoload = $root . '/vendor/autoload.php';
    $keyfile  = $root . '/desa/app_key';
    if (! is_file($autoload) || ! is_file($keyfile)) {
        fwrite(STDERR, "ERR: tidak bisa dekripsi password (autoload/app_key tidak ada)\n");
        exit(3);
    }
    require_once $autoload;
    $rawkey = trim(file_get_contents($keyfile));
    if (str_starts_with($rawkey, 'base64:')) {
        $rawkey = base64_decode(substr($rawkey, 7));
    }
    try {
        $enc  = new Illuminate\Encryption\Encrypter($rawkey, 'AES-256-CBC');
        $pass = $enc->decrypt($pass);
    } catch (Throwable $e) {
        fwrite(STDERR, 'DECRYPT-ERR: ' . $e->getMessage() . "\n");
        exit(3);
    }
}

$m = @new mysqli($d['hostname'], $d['username'], $pass, $d['database'], (int) ($d['port'] ?? 3306));
if ($m->connect_errno) {
    fwrite(STDERR, 'DBERR: ' . $m->connect_error . "\n");
    exit(1);
}
$m->set_charset('utf8mb4');

$slugify = static function (string $s): string {
    $s = strtolower(trim($s));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);

    return trim($s, '-');
};

// config_id mengikuti baris tema sistem yang ada (multi-desa aware)
$config_id = 1;
if ($res = $m->query('SELECT config_id FROM theme WHERE sistem=1 LIMIT 1')) {
    if ($row = $res->fetch_assoc()) {
        $config_id = (int) $row['config_id'];
    }
}

// kumpulkan tema garuda dari direktori desa/themes
$themesDir = $root . '/desa/themes';
$dirs      = [];
foreach (glob($themesDir . '/garuda*', GLOB_ONLYDIR) as $p) {
    if (is_file($p . '/composer.json')) {
        $dirs[] = $p;
    }
}
sort($dirs);
if (! $dirs) {
    fwrite(STDERR, "ERR: tidak ada folder tema garuda di {$themesDir}\n");
    exit(1);
}

$now  = date('Y-m-d H:i:s');
$rows = [];
foreach ($dirs as $p) {
    $dir = basename($p);                       // mis. garuda-ternama-1
    $c   = json_decode(file_get_contents($p . '/composer.json'), true) ?: [];
    $namePart = isset($c['name']) ? (explode('/', $c['name'])[1] ?? $dir) : $dir; // garuda-ternama-1-pesisir
    $spaces   = str_replace('-', ' ', $namePart);
    $rows[] = [
        'config_id'  => $config_id,
        'nama'       => ucwords($spaces),
        'slug'       => $slugify('desa ' . $namePart),
        'versi'      => substr((string) ($c['version'] ?? '1.0.0'), 0, 10),
        'sistem'     => 0,
        'path'       => 'desa/themes/' . $dir,
        'status'     => 0,
        'keterangan' => (string) ($c['description'] ?? ''),
    ];
}

// tema aktif sebelumnya (untuk rollback)
$prev = '';
if ($res = $m->query('SELECT slug FROM theme WHERE status=1 LIMIT 1')) {
    if ($row = $res->fetch_assoc()) {
        $prev = $row['slug'];
    }
}
echo 'PREV_ACTIVE=' . $prev . "\n";

$m->begin_transaction();
try {
    $slugs = array_map(static fn ($r) => "'" . $m->real_escape_string($r['slug']) . "'", $rows);
    $m->query('DELETE FROM theme WHERE slug IN (' . implode(',', $slugs) . ')');

    $stmt = $m->prepare('INSERT INTO theme (config_id,nama,slug,versi,sistem,path,status,keterangan,opsi,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,NULL,?,?)');
    foreach ($rows as $r) {
        $stmt->bind_param(
            'isssisisss',
            $r['config_id'], $r['nama'], $r['slug'], $r['versi'], $r['sistem'],
            $r['path'], $r['status'], $r['keterangan'], $now, $now
        );
        $stmt->execute();
    }
    $stmt->close();

    if ($activate !== 'none') {
        $esc = $m->real_escape_string($activate);
        $cnt = (int) $m->query("SELECT COUNT(*) c FROM theme WHERE slug='{$esc}'")->fetch_assoc()['c'];
        if ($cnt !== 1) {
            throw new RuntimeException("tema '{$activate}' tidak ditemukan untuk diaktifkan (cnt={$cnt})");
        }
        $m->query('UPDATE theme SET status=0');
        $m->query("UPDATE theme SET status=1 WHERE slug='{$esc}'");
    }

    $m->commit();
} catch (Throwable $e) {
    $m->rollback();
    fwrite(STDERR, 'ROLLBACK: ' . $e->getMessage() . "\n");
    exit(1);
}

echo 'REGISTERED=' . count($rows) . ' ACTIVATED=' . $activate . "\n";
$r = $m->query('SELECT nama,slug,status FROM theme WHERE slug LIKE \'desa-garuda%\' ORDER BY id');
while ($x = $r->fetch_assoc()) {
    echo '  ' . ($x['status'] ? '[ON] ' : '[  ] ') . $x['nama'] . ' (' . $x['slug'] . ")\n";
}
$m->close();
