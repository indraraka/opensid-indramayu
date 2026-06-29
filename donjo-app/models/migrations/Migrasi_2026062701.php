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

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Migrasi fitur Impor Berita (dari situs WordPress / RSS eksternal).
 *
 * Membuat tabel `impor_berita` (dedup + histori impor) dan menanam baris
 * pengaturan `berita_import_*` pada `setting_aplikasi` untuk setiap config_id.
 */
class Migrasi_2026062701 extends MY_model
{
    public function up()
    {
        $this->buat_tabel_impor_berita();

        // Tanam setting untuk tiap desa (config_id)
        $config_id = DB::table('config')->pluck('id')->toArray();

        foreach ($config_id as $id) {
            foreach ($this->daftar_setting() as $setting) {
                $this->tambah_setting($setting, $id);
            }
        }

        return true;
    }

    protected function buat_tabel_impor_berita(): void
    {
        if (Schema::hasTable('impor_berita')) {
            return;
        }

        Schema::create('impor_berita', static function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('config_id')->nullable();
            $table->string('sumber_url', 191)->comment('URL situs sumber, mis. https://indramayukab.go.id');
            $table->string('sumber_id', 191)->comment('ID/GUID post pada situs sumber');
            $table->string('sumber_link', 300)->nullable()->comment('Permalink artikel sumber');
            $table->string('judul', 200)->nullable();
            $table->integer('id_artikel')->nullable()->comment('FK artikel yang dibuat');
            $table->string('status', 20)->default('sukses')->comment('sukses | gagal');
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->unique(['config_id', 'sumber_url', 'sumber_id'], 'impor_berita_sumber_unique');
        });
    }

    /**
     * Daftar pengaturan default untuk fitur impor berita.
     *
     * Kategori 'impor_berita' sengaja dipilih agar tidak ikut tampil di
     * halaman Pengaturan Aplikasi (yang hanya merender kategori tertentu);
     * pengaturan ini dirender di halaman Impor Berita tersendiri.
     */
    protected function daftar_setting(): array
    {
        $ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36';

        return [
            [
                'judul'      => 'Aktifkan Impor Berita Otomatis',
                'key'        => 'berita_import_aktif',
                'value'      => '0',
                'keterangan' => 'Jika aktif, cron harian akan mengimpor berita dari situs sumber.',
                'jenis'      => 'boolean',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'URL Situs Sumber Berita',
                'key'        => 'berita_import_url',
                'value'      => '',
                'keterangan' => 'Alamat situs WordPress sumber, mis. https://indramayukab.go.id',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Metode Pengambilan',
                'key'        => 'berita_import_metode',
                'value'      => 'auto',
                'keterangan' => 'auto = coba REST API lalu fallback RSS; wp-rest = REST API saja; rss = RSS feed saja.',
                'jenis'      => 'option',
                'option'     => json_encode(['auto' => 'Otomatis (REST + RSS)', 'wp-rest' => 'WP REST API', 'rss' => 'RSS Feed'], JSON_THROW_ON_ERROR),
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Kategori Tujuan',
                'key'        => 'berita_import_kategori',
                'value'      => '',
                'keterangan' => 'ID kategori artikel tujuan untuk berita hasil impor. Kosongkan untuk tanpa kategori.',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Penulis (User)',
                'key'        => 'berita_import_id_user',
                'value'      => '',
                'keterangan' => 'ID pengguna yang dicatat sebagai penulis berita impor. Kosongkan untuk memakai admin utama.',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Batas Impor per Hari',
                'key'        => 'berita_import_limit',
                'value'      => '1',
                'keterangan' => 'Jumlah maksimum berita yang diimpor otomatis per hari (mis. 1 berita per hari).',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => 'class="bilangan required" min="1" max="50" type="number"',
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Status Terbit Berita Impor',
                'key'        => 'berita_import_status',
                'value'      => '1',
                'keterangan' => 'Ya = langsung tayang; Tidak = disimpan nonaktif untuk ditinjau dulu.',
                'jenis'      => 'boolean',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Jumlah Berita Diambil saat Pratinjau',
                'key'        => 'berita_import_jumlah_ambil',
                'value'      => '10',
                'keterangan' => 'Berapa berita terbaru yang ditarik dari situs sumber untuk ditampilkan di daftar.',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => 'class="bilangan required" min="1" max="50" type="number"',
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Tambahkan Atribusi Sumber',
                'key'        => 'berita_import_atribusi',
                'value'      => '1',
                'keterangan' => 'Jika aktif, tautan sumber ditambahkan di akhir isi berita hasil impor.',
                'jenis'      => 'boolean',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'User-Agent Permintaan',
                'key'        => 'berita_import_user_agent',
                'value'      => $ua,
                'keterangan' => 'Header User-Agent saat mengambil data, agar tidak diblokir WAF situs sumber.',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'Bypass Cloudflare',
                'key'        => 'berita_import_proxy',
                'value'      => 'none',
                'keterangan' => 'Untuk situs di belakang Cloudflare (mis. indramayukab.go.id). none = langsung; template = render API; flaresolverr = server FlareSolverr.',
                'jenis'      => 'option',
                'option'     => json_encode(['none' => 'Tidak (langsung)', 'template' => 'Render API (URL template {url})', 'flaresolverr' => 'FlareSolverr'], JSON_THROW_ON_ERROR),
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
            [
                'judul'      => 'URL Proxy / Endpoint Bypass',
                'key'        => 'berita_import_proxy_url',
                'value'      => '',
                'keterangan' => 'Template berisi {url} (mis. https://api.scraperapi.com/?api_key=XXX&url={url}) ATAU endpoint FlareSolverr (mis. http://127.0.0.1:8191).',
                'jenis'      => 'text',
                'option'     => null,
                'attribute'  => null,
                'kategori'   => 'impor_berita',
            ],
        ];
    }
}
