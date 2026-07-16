{{-- Garuda — banner tautan cepat beranda.
     Catatan: OpenSID 2606 mem-404 halaman fitur yang menunya non-aktif
     (hak_akses_menu). Tautan di sini dipilih yang andal di 2606. --}}
@if (theme_config('banner', '1') == '1')
    @php
        $sebutan  = ucwords((string) setting('sebutan_desa'));
        $sections = [
            ['url' => site_url('data-statistik/jenis-kelamin'), 'icon' => 'fa-users',          'title' => 'Data Penduduk',   'sub' => 'Statistik Kependudukan'],
            ['url' => site_url('data-statistik/pekerjaan'),     'icon' => 'fa-briefcase',       'title' => 'Mata Pencaharian','sub' => 'Statistik Pekerjaan'],
            ['url' => site_url('data-statistik/agama'),         'icon' => 'fa-mosque',          'title' => 'Agama',           'sub' => 'Pemeluk Agama'],
            ['url' => site_url('pemerintah'),                   'icon' => 'fa-sitemap',         'title' => 'Pemerintah ' . $sebutan, 'sub' => 'Struktur Organisasi'],
            ['url' => site_url('peraturan-desa'),               'icon' => 'fa-gavel',           'title' => 'Produk Hukum',    'sub' => 'Peraturan di ' . $sebutan],
            ['url' => site_url('pembangunan'),                  'icon' => 'fa-hard-hat',        'title' => 'Pembangunan',     'sub' => 'Dokumentasi Kegiatan'],
            ['url' => site_url('galeri'),                       'icon' => 'fa-images',          'title' => 'Galeri',          'sub' => 'Album Foto ' . $sebutan],
            ['url' => site_url('arsip'),                        'icon' => 'fa-folder-open',     'title' => 'Arsip',           'sub' => 'Artikel & Dokumen'],
            ['url' => site_url('pengaduan'),                    'icon' => 'fa-bullhorn',        'title' => 'Lapor',           'sub' => 'Pengaduan Warga'],
        ];
    @endphp
    <section class="grd-container" style="margin-top:var(--section-y,3rem);">
        <div class="grd-quick">
            @foreach ($sections as $s)
                <a href="{{ $s['url'] }}" class="grd-quick__item" @if (!empty($s['blank'])) target="_blank" rel="noopener" @endif>
                    <span class="grd-quick__icon"><i class="fas {{ $s['icon'] }}"></i></span>
                    <span class="grd-quick__title">{{ $s['title'] }}</span>
                    <span class="grd-quick__sub">{{ $s['sub'] }}</span>
                </a>
            @endforeach
        </div>
    </section>
@endif
