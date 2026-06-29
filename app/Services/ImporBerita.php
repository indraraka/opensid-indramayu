<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

namespace App\Services;

use App\Models\Artikel;
use App\Models\ImporBerita as ImporBeritaModel;
use App\Models\SettingAplikasi;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Throwable;

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Service impor berita dari situs WordPress / RSS eksternal.
 *
 * Dipakai oleh dua jalur (satu sumber kebenaran):
 *  - Artisan command `opensid:impor-berita` (cron harian)
 *  - Controller admin `Impor_berita` (tombol "Impor Sekarang" & "Impor" per item)
 *
 * Mendukung bypass Cloudflare (setting `berita_import_proxy`):
 *  - none         : permintaan langsung (Guzzle).
 *  - template     : render API (ScraperAPI/ScrapingBee/ZenRows/Scrape.do) via URL
 *                   template berisi placeholder {url}.
 *  - flaresolverr : server FlareSolverr (POST /v1) yang menyolusikan tantangan JS.
 *
 * Aman dipanggil dari CLI maupun web: semua pengaturan dibaca langsung dari
 * tabel `setting_aplikasi` (bukan dari `ci()->setting` yang hanya terisi pada
 * request web), dan config_id desa diselesaikan oleh global scope ConfigId.
 */
class ImporBerita
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'         => 90,
            'connect_timeout' => 15,
            'http_errors'     => false,
        ]);
    }

    /**
     * Ambil daftar berita terbaru dari situs sumber, dinormalisasi.
     *
     * @return array<int, array{sumber_id:string, judul:string, link:string, tgl:string, ringkasan:string, gambar_url:?string, isi:string}>
     */
    public function ambilDaftar(?int $jumlah = null): array
    {
        $base = $this->baseUrl();

        if ($base === '') {
            return [];
        }

        $jumlah ??= (int) $this->pengaturan('berita_import_jumlah_ambil', 10);
        $jumlah = max(1, min(50, $jumlah));
        $metode = $this->pengaturan('berita_import_metode', 'auto');

        if ($metode === 'rss') {
            return $this->ambilRss($base, $jumlah);
        }

        if ($metode === 'wp-rest') {
            return $this->ambilRest($base, $jumlah);
        }

        // auto: REST dulu (konten penuh + gambar), fallback ke RSS bila gagal/kosong
        $hasil = $this->ambilRest($base, $jumlah);

        return $hasil !== [] ? $hasil : $this->ambilRss($base, $jumlah);
    }

    /**
     * Impor satu berita (dari array hasil ambilDaftar) menjadi Artikel.
     *
     * @return array{status:string, judul:string, id_artikel:?int, pesan:string}
     */
    public function imporSatu(array $post): array
    {
        $base   = $this->baseUrl();
        $judul  = $this->bersihkanJudul($post['judul'] ?? '');
        $sumber = mb_substr((string) ($post['sumber_id'] ?? ($post['link'] ?? '')), 0, 191);

        if ($judul === '' || $sumber === '') {
            return ['status' => 'gagal', 'judul' => $judul, 'id_artikel' => null, 'pesan' => 'Judul atau identitas sumber kosong'];
        }

        if ($this->sudahDiimpor($base, $sumber)) {
            return ['status' => 'lewat', 'judul' => $judul, 'id_artikel' => null, 'pesan' => 'Sudah pernah diimpor'];
        }

        try {
            $gambar = ! empty($post['gambar_url']) ? $this->unduhGambar((string) $post['gambar_url']) : null;

            $artikel = Artikel::create([
                'judul'          => $judul,
                'isi'            => $this->susunIsi($post),
                'slug'           => unique_slug('artikel', $judul),
                'tgl_upload'     => $this->tanggalUpload($post['tgl'] ?? ''),
                'gambar'         => $gambar,
                'id_kategori'    => $this->kategoriTujuan(),
                'tipe'           => 'dinamis',
                'enabled'        => $this->statusTerbit(),
                'headline'       => 0,
                'slider'         => 0,
                'tampilan'       => 1,
                'boleh_komentar' => 1,
                'hit'            => 0,
                'id_user'        => $this->penulis(),
            ]);

            $this->catat($base, $sumber, $post, $artikel->id, ImporBeritaModel::STATUS_SUKSES, 'Berhasil diimpor');

            return ['status' => 'sukses', 'judul' => $judul, 'id_artikel' => $artikel->id, 'pesan' => 'Berhasil diimpor'];
        } catch (Throwable $e) {
            log_message('error', 'Impor berita gagal: ' . $e->getMessage());
            $this->catat($base, $sumber, $post, null, ImporBeritaModel::STATUS_GAGAL, $e->getMessage());

            return ['status' => 'gagal', 'judul' => $judul, 'id_artikel' => null, 'pesan' => $e->getMessage()];
        }
    }

    /**
     * Jalankan impor otomatis (cron / tombol "Impor Sekarang").
     *
     * Menghormati pengaturan aktif (kecuali $paksa), batas per hari, dan dedup.
     *
     * @return array{sukses:int, lewat:int, gagal:int, pesan:string}
     */
    public function jalankanOtomatis(bool $paksa = false): array
    {
        $ringkasan = ['sukses' => 0, 'lewat' => 0, 'gagal' => 0, 'pesan' => ''];

        if (! $paksa && (int) $this->pengaturan('berita_import_aktif', 0) !== 1) {
            $ringkasan['pesan'] = 'Impor otomatis tidak aktif.';

            return $ringkasan;
        }

        if ($this->baseUrl() === '') {
            $ringkasan['pesan'] = 'URL situs sumber belum diatur.';

            return $ringkasan;
        }

        $limit   = max(1, (int) $this->pengaturan('berita_import_limit', 1));
        $hariIni = ImporBeritaModel::sukses()->whereDate('created_at', date('Y-m-d'))->count();
        $sisa    = $limit - $hariIni;

        if ($sisa <= 0) {
            $ringkasan['pesan'] = "Batas impor harian ({$limit}) sudah tercapai.";

            return $ringkasan;
        }

        $daftar = $this->ambilDaftar();

        if ($daftar === []) {
            $ringkasan['pesan'] = 'Tidak ada berita yang dapat diambil dari situs sumber.';

            return $ringkasan;
        }

        foreach ($daftar as $post) {
            if ($ringkasan['sukses'] >= $sisa) {
                break;
            }

            $hasil  = $this->imporSatu($post);
            $status = $hasil['status'] === 'sukses' ? 'sukses' : ($hasil['status'] === 'lewat' ? 'lewat' : 'gagal');
            $ringkasan[$status]++;
        }

        $ringkasan['pesan'] = "Impor selesai: {$ringkasan['sukses']} berhasil, {$ringkasan['lewat']} dilewati, {$ringkasan['gagal']} gagal.";

        return $ringkasan;
    }

    /**
     * Tandai daftar berita dengan info apakah sudah diimpor (untuk pratinjau admin).
     */
    public function tandaiSudahDiimpor(array $daftar): array
    {
        $base = $this->baseUrl();

        $sudah = ImporBeritaModel::where('sumber_url', $base)
            ->pluck('status', 'sumber_id')
            ->toArray();

        return array_map(static function (array $post) use ($sudah): array {
            $id              = (string) ($post['sumber_id'] ?? '');
            $post['diimpor'] = isset($sudah[$id]) && $sudah[$id] === ImporBeritaModel::STATUS_SUKSES;

            return $post;
        }, $daftar);
    }

    // =====================================================================
    // Pengambilan data
    // =====================================================================

    protected function ambilRest(string $base, int $jumlah): array
    {
        try {
            // Bila URL sumber sudah berupa endpoint penuh (mis. diskominfo .../api/posts
            // atau .../wp-json/wp/v2/posts), pakai apa adanya; jika hanya domain WP, tambahkan path REST.
            if (preg_match('~(/wp-json/|/api/|/posts)~i', $base)) {
                $url = $base . (str_contains($base, '?') ? '&' : '?') . 'per_page=' . $jumlah . '&_embed=1';
            } else {
                $url = $base . '/wp-json/wp/v2/posts?per_page=' . $jumlah . '&_embed=1';
            }

            $data = $this->ekstrakJson($this->ambilBody($url, 'application/json'));

            if ($data === []) {
                return [];
            }

            $hasil = [];

            foreach ($data as $p) {
                if (! is_array($p) || ! isset($p['title'])) {
                    continue;
                }

                $hasil[] = [
                    'sumber_id'  => mb_substr((string) ($p['id'] ?? ''), 0, 191),
                    'judul'      => (string) ($p['title']['rendered'] ?? ''),
                    'link'       => (string) ($p['link'] ?? ''),
                    'tgl'        => (string) ($p['date'] ?? ''),
                    'ringkasan'  => trim(strip_tags((string) ($p['excerpt']['rendered'] ?? ''))),
                    'gambar_url' => $this->gambarRest($p),
                    'isi'        => (string) ($p['content']['rendered'] ?? ''),
                ];
            }

            return $hasil;
        } catch (Throwable $e) {
            log_message('error', 'Impor berita REST gagal: ' . $e->getMessage());

            return [];
        }
    }

    protected function ambilRss(string $base, int $jumlah): array
    {
        foreach (['/feed/', '/?feed=rss2', '/rss'] as $path) {
            $items = $this->parseRss($base . $path, $jumlah);

            if ($items !== []) {
                return $items;
            }
        }

        return [];
    }

    protected function parseRss(string $url, int $jumlah): array
    {
        try {
            $body = $this->ambilBody($url, 'application/rss+xml, application/xml, text/xml');

            if ($body === null || $body === '') {
                return [];
            }

            $body = $this->ekstrakXml($body);

            if (! str_contains($body, '<item')) {
                return [];
            }

            $xml = @simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);

            if ($xml === false || ! isset($xml->channel->item)) {
                return [];
            }

            $hasil = [];

            foreach ($xml->channel->item as $item) {
                if (count($hasil) >= $jumlah) {
                    break;
                }

                $content = $item->children('http://purl.org/rss/1.0/modules/content/');
                $isi     = isset($content->encoded) ? (string) $content->encoded : (string) $item->description;
                $link    = (string) $item->link;
                $guid    = (string) $item->guid;

                $hasil[] = [
                    'sumber_id'  => mb_substr($guid !== '' ? $guid : $link, 0, 191),
                    'judul'      => (string) $item->title,
                    'link'       => $link,
                    'tgl'        => (string) $item->pubDate,
                    'ringkasan'  => trim(strip_tags((string) $item->description)),
                    'gambar_url' => $this->gambarRss($item, $isi),
                    'isi'        => $isi,
                ];
            }

            return $hasil;
        } catch (Throwable $e) {
            log_message('error', 'Impor berita RSS gagal: ' . $e->getMessage());

            return [];
        }
    }

    protected function gambarRest(array $p): ?string
    {
        $media = $p['_embedded']['wp:featuredmedia'][0]['source_url']
            ?? ($p['yoast_head_json']['og_image'][0]['url'] ?? null);

        return $media ? (string) $media : null;
    }

    protected function gambarRss($item, string $isi): ?string
    {
        // <enclosure url="..." type="image/...">
        if (isset($item->enclosure['url']) && str_contains((string) ($item->enclosure['type'] ?? ''), 'image')) {
            return (string) $item->enclosure['url'];
        }

        // <media:content url="..." medium="image">
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content) && isset($media->content->attributes()->url)) {
            return (string) $media->content->attributes()->url;
        }

        // <img src="..."> pertama di dalam isi
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $isi, $m)) {
            return $m[1];
        }

        return null;
    }

    // =====================================================================
    // Lapisan fetch (mendukung bypass Cloudflare)
    // =====================================================================

    /**
     * Ambil body sebuah URL, lewat proxy/bypass bila dikonfigurasi.
     */
    protected function ambilBody(string $url, string $accept): ?string
    {
        $proxy = $this->pengaturan('berita_import_proxy', 'none');

        try {
            if ($proxy === 'flaresolverr') {
                return $this->viaFlareSolverr($url);
            }

            if ($proxy === 'template') {
                return $this->viaTemplate($url, $accept);
            }

            $res = $this->client->get($url, ['headers' => $this->headers() + ['Accept' => $accept]]);

            return $res->getStatusCode() === 200 ? (string) $res->getBody() : null;
        } catch (Throwable $e) {
            log_message('error', 'Impor berita ambilBody: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Render API berbasis URL template, mis:
     *   https://api.scraperapi.com/?api_key=XXX&url={url}
     *   https://app.scrapingbee.com/api/v1/?api_key=XXX&render_js=true&url={url}
     */
    protected function viaTemplate(string $url, string $accept): ?string
    {
        $tpl = trim((string) $this->pengaturan('berita_import_proxy_url', ''));

        if ($tpl === '' || ! str_contains($tpl, '{url}')) {
            return null;
        }

        $res = $this->client->get(str_replace('{url}', rawurlencode($url), $tpl), [
            'headers' => ['Accept' => $accept],
        ]);

        return $res->getStatusCode() === 200 ? (string) $res->getBody() : null;
    }

    /**
     * FlareSolverr (https://github.com/FlareSolverr/FlareSolverr): POST /v1.
     */
    protected function viaFlareSolverr(string $url): ?string
    {
        $endpoint = rtrim(trim((string) $this->pengaturan('berita_import_proxy_url', '')), '/');

        if ($endpoint === '') {
            return null;
        }

        if (! str_ends_with($endpoint, '/v1')) {
            $endpoint .= '/v1';
        }

        $res = $this->client->post($endpoint, [
            'json'    => ['cmd' => 'request.get', 'url' => $url, 'maxTimeout' => 60000],
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        if ($res->getStatusCode() !== 200) {
            return null;
        }

        $data = json_decode((string) $res->getBody(), true);

        return isset($data['solution']['response']) && is_string($data['solution']['response'])
            ? $data['solution']['response']
            : null;
    }

    /**
     * Decode JSON dari body — termasuk bila terbungkus HTML <pre> (FlareSolverr).
     */
    protected function ekstrakJson(?string $body): array
    {
        if ($body === null || $body === '') {
            return [];
        }

        $data = json_decode($body, true);

        if (is_array($data)) {
            return $data;
        }

        // FlareSolverr membungkus JSON dalam <pre>...</pre> dan ter-HTML-encode
        if (preg_match('/<pre[^>]*>(.*?)<\/pre>/is', $body, $m)) {
            $data = json_decode(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'), true);

            if (is_array($data)) {
                return $data;
            }
        }

        return [];
    }

    /**
     * Ambil potongan XML/RSS dari body (bila terbungkus HTML oleh proxy).
     */
    protected function ekstrakXml(string $body): string
    {
        $body = trim($body);

        if (str_starts_with($body, '<?xml') || str_starts_with($body, '<rss') || str_starts_with($body, '<feed')) {
            return $body;
        }

        if (preg_match('/<rss\b.*<\/rss>/is', $body, $m)) {
            return $m[0];
        }

        if (preg_match('/<feed\b.*<\/feed>/is', $body, $m)) {
            return $m[0];
        }

        return $body;
    }

    // =====================================================================
    // Penyimpanan artikel
    // =====================================================================

    /**
     * Unduh gambar utama lalu buat versi kecil_ & sedang_ (meniru UploadArtikel).
     */
    protected function unduhGambar(string $url): ?string
    {
        if (! is_dir(LOKASI_FOTO_ARTIKEL)) {
            return null;
        }

        try {
            $bytes = $this->unduhBiner($url);

            if ($bytes === null) {
                return null;
            }

            $ext = $this->ekstensiDariBytes($bytes) ?: $this->ekstensiGambar($url, '');

            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
                return null;
            }

            $nama = time() . '_' . substr(md5($url), 0, 10) . '.' . $ext;
            $tmp  = LOKASI_FOTO_ARTIKEL . 'tmp_' . $nama;
            file_put_contents($tmp, $bytes);

            // @ untuk meredam warning exif_read_data internal ResizeGambar pada file non-JPEG
            @ResizeGambar($tmp, LOKASI_FOTO_ARTIKEL . 'kecil_' . $nama, ['width' => 440, 'height' => 440]);
            @ResizeGambar($tmp, LOKASI_FOTO_ARTIKEL . 'sedang_' . $nama, ['width' => 880, 'height' => 880]);

            if (file_exists($tmp)) {
                unlink($tmp);
            }

            // Pastikan minimal satu turunan berhasil dibuat
            if (! file_exists(LOKASI_FOTO_ARTIKEL . 'sedang_' . $nama)) {
                return null;
            }

            return $nama;
        } catch (Throwable $e) {
            log_message('error', 'Impor berita - gagal unduh gambar: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Unduh biner (gambar): coba langsung, lalu via render API template bila gagal.
     */
    protected function unduhBiner(string $url): ?string
    {
        try {
            $res = $this->client->get($url, ['headers' => $this->headers()]);

            if ($res->getStatusCode() === 200 && ($b = (string) $res->getBody()) !== '') {
                return $b;
            }
        } catch (Throwable $e) {
            log_message('error', 'Impor berita - unduh biner langsung: ' . $e->getMessage());
        }

        if ($this->pengaturan('berita_import_proxy', 'none') === 'template') {
            $tpl = trim((string) $this->pengaturan('berita_import_proxy_url', ''));

            if (str_contains($tpl, '{url}')) {
                try {
                    $res = $this->client->get(str_replace('{url}', rawurlencode($url), $tpl));

                    if ($res->getStatusCode() === 200 && ($b = (string) $res->getBody()) !== '') {
                        return $b;
                    }
                } catch (Throwable $e) {
                    log_message('error', 'Impor berita - unduh biner via proxy: ' . $e->getMessage());
                }
            }
        }

        return null;
    }

    protected function susunIsi(array $post): string
    {
        $isi = (string) ($post['isi'] ?? '');

        if ($isi === '') {
            $isi = (string) ($post['ringkasan'] ?? '');
        }

        if ((int) $this->pengaturan('berita_import_atribusi', 1) === 1 && ! empty($post['link'])) {
            $host = parse_url((string) $post['link'], PHP_URL_HOST) ?: $post['link'];
            $isi .= '<p><em>Sumber: <a href="' . htmlspecialchars((string) $post['link'], ENT_QUOTES) . '" target="_blank" rel="noopener">' . htmlspecialchars((string) $host, ENT_QUOTES) . '</a></em></p>';
        }

        return $isi;
    }

    protected function catat(string $base, string $sumber, array $post, ?int $idArtikel, string $status, string $keterangan): void
    {
        ImporBeritaModel::create([
            'sumber_url'  => $base,
            'sumber_id'   => $sumber,
            'sumber_link' => mb_substr((string) ($post['link'] ?? ''), 0, 300),
            'judul'       => mb_substr($this->bersihkanJudul($post['judul'] ?? ''), 0, 200),
            'id_artikel'  => $idArtikel,
            'status'      => $status,
            'keterangan'  => mb_substr($keterangan, 0, 1000),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    // =====================================================================
    // Pengaturan & util
    // =====================================================================

    protected function pengaturan(string $key, $default = null)
    {
        $val = SettingAplikasi::where('key', $key)->value('value');

        return ($val === null || $val === '') ? $default : $val;
    }

    protected function baseUrl(): string
    {
        return rtrim(trim((string) $this->pengaturan('berita_import_url', '')), '/');
    }

    protected function headers(): array
    {
        return [
            'User-Agent'      => (string) $this->pengaturan('berita_import_user_agent', 'Mozilla/5.0 (compatible; OpenSID/2504)'),
            'Accept-Language' => 'id,en;q=0.8',
        ];
    }

    protected function sudahDiimpor(string $base, string $sumber): bool
    {
        return ImporBeritaModel::where('sumber_url', $base)
            ->where('sumber_id', $sumber)
            ->where('status', ImporBeritaModel::STATUS_SUKSES)
            ->exists();
    }

    protected function bersihkanJudul(string $raw): string
    {
        $judul  = trim(strip_tags(html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $bersih = judul($judul);

        return ($bersih === null || $bersih === '') ? $judul : $bersih;
    }

    protected function tanggalUpload(string $tgl): string
    {
        if ($tgl === '') {
            return date('Y-m-d H:i:s');
        }

        try {
            return Carbon::parse($tgl)->format('Y-m-d H:i:s');
        } catch (Throwable) {
            return date('Y-m-d H:i:s');
        }
    }

    protected function kategoriTujuan(): ?int
    {
        $kat = (int) $this->pengaturan('berita_import_kategori', 0);

        return $kat > 0 ? $kat : null;
    }

    protected function statusTerbit(): int
    {
        return (int) $this->pengaturan('berita_import_status', 1) === 1 ? 1 : 0;
    }

    protected function penulis(): int
    {
        $id = (int) $this->pengaturan('berita_import_id_user', 0);

        if ($id > 0) {
            return $id;
        }

        $super = function_exists('super_admin') ? (int) super_admin() : 0;

        return $super > 0 ? $super : 1;
    }

    protected function ekstensiDariBytes(string $bytes): ?string
    {
        $info = @getimagesizefromstring($bytes);

        if ($info === false) {
            return null;
        }

        return match ($info[2] ?? 0) {
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_GIF  => 'gif',
            default        => null,
        };
    }

    protected function ekstensiGambar(string $url, string $contentType): string
    {
        $ext = strtolower(pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
            return $ext === 'jpeg' ? 'jpg' : $ext;
        }

        return match (true) {
            str_contains($contentType, 'png')             => 'png',
            str_contains($contentType, 'gif')             => 'gif',
            str_contains($contentType, 'jpeg'), str_contains($contentType, 'jpg') => 'jpg',
            default                                        => '',
        };
    }
}
