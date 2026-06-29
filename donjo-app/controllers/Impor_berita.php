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

use App\Models\ImporBerita as ImporBeritaLog;
use App\Models\Kategori;
use App\Models\SettingAplikasi;
use App\Models\User;
use App\Services\ImporBerita as ImporBeritaService;

defined('BASEPATH') || exit('No direct script access allowed');

class Impor_berita extends Admin_Controller
{
    // Reuse hak akses modul 'artikel': admin/operator artikel langsung bisa mengakses.
    public $modul_ini     = 'admin-web';
    public $sub_modul_ini = 'artikel';

    /**
     * Daftar key pengaturan yang dikelola oleh halaman ini.
     */
    private array $keys = [
        'berita_import_aktif',
        'berita_import_url',
        'berita_import_metode',
        'berita_import_kategori',
        'berita_import_id_user',
        'berita_import_limit',
        'berita_import_status',
        'berita_import_jumlah_ambil',
        'berita_import_atribusi',
        'berita_import_user_agent',
        'berita_import_proxy',
        'berita_import_proxy_url',
    ];

    public function __construct()
    {
        parent::__construct();
        isCan('b');
    }

    public function index(): void
    {
        $data = [
            'list_kategori' => Kategori::get(),
            'list_user'     => User::get(),
            'riwayat'       => ImporBeritaLog::orderBy('created_at', 'desc')->limit(50)->get(),
        ];

        view('admin.impor_berita.index', $data);
    }

    /**
     * Simpan pengaturan impor berita.
     */
    public function konfigurasi(): void
    {
        isCan('u');

        foreach ($this->keys as $key) {
            $value = $this->input->post($key);
            $value = is_string($value) ? trim(strip_tags($value)) : $value;
            SettingAplikasi::where('key', $key)->update(['value' => $value]);
        }

        (new SettingAplikasi())->flushQueryCache();

        redirect_with('success', 'Pengaturan impor berita berhasil disimpan', ci_route('impor_berita'));
    }

    /**
     * AJAX: ambil daftar berita terbaru dari situs sumber (untuk pratinjau).
     */
    public function daftar(): void
    {
        if (! $this->input->is_ajax_request()) {
            show_404();
        }

        $service = new ImporBeritaService();

        try {
            $daftar = $service->tandaiSudahDiimpor($service->ambilDaftar());
            json(['status' => 'ok', 'data' => $daftar]);
        } catch (Throwable $e) {
            log_message('error', 'Impor berita daftar: ' . $e->getMessage());
            json(['status' => 'gagal', 'data' => [], 'pesan' => 'Gagal mengambil data dari situs sumber.']);
        }
    }

    /**
     * AJAX: impor satu berita (kirim sumber_id) ATAU batch "Impor Sekarang".
     */
    public function impor(): void
    {
        if (! can('u')) {
            json(['status' => 'gagal', 'pesan' => 'Anda tidak memiliki akses untuk mengimpor berita.']);
        }

        $service  = new ImporBeritaService();
        $sumberId = $this->input->post('sumber_id');

        // Impor satu item berdasarkan sumber_id
        if (! empty($sumberId)) {
            $post = collect($service->ambilDaftar())->firstWhere('sumber_id', (string) $sumberId);

            if (! $post) {
                json(['status' => 'gagal', 'pesan' => 'Berita tidak ditemukan di situs sumber.']);
            }

            json($service->imporSatu($post));
        }

        // Batch "Impor Sekarang" (paksa walau impor otomatis nonaktif, tetap hormati batas harian)
        json($service->jalankanOtomatis(true));
    }
}
