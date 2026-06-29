<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (theme_config('banner', '1') == '1') : ?>
<?php
    $sebutan = ucwords($this->setting->sebutan_desa);
    $sections = [
        ['url' => site_url('data-wilayah'),                       'icon' => 'fa-chart-pie',       'title' => 'Data Wilayah',   'sub' => 'Populasi Per Wilayah'],
        ['url' => site_url('lapak'),                              'icon' => 'fa-store',           'title' => 'Lapak ' . $sebutan, 'sub' => 'Hasil Olahan Warga'],
        ['url' => site_url('data-statistik/golongan-darah'),      'icon' => 'fa-tint',         'title' => 'Golongan Darah', 'sub' => 'Data Statistik'],
        ['url' => site_url('kehadiran'),                          'icon' => 'fa-desktop',         'title' => 'Rekam Kehadiran','sub' => 'di Kantor ' . $sebutan, 'blank' => true],
        ['url' => site_url('pembangunan'),                        'icon' => 'fa-hard-hat',  'title' => 'Pembangunan',    'sub' => 'Dokumentasi Kegiatan'],
        ['url' => site_url('peraturan-desa'),                     'icon' => 'fa-gavel',           'title' => 'Produk Hukum',   'sub' => 'Peraturan di ' . $sebutan],
        ['url' => site_url('first/dpt'),                          'icon' => 'fa-check-square',    'title' => 'DPT',            'sub' => 'Calon Pemilih'],
        ['url' => site_url('pengaduan'),                          'icon' => 'fa-bullhorn',        'title' => 'Lapor',          'sub' => 'Pengaduan Warga'],
        ['url' => site_url('galeri'),                             'icon' => 'fa-images',          'title' => 'Galeri',         'sub' => 'Album Foto'],
        ['url' => site_url('status-sdgs'),                        'icon' => 'fa-globe-asia',      'title' => 'Status SDGs',    'sub' => 'Sustainable Dev. Goals'],
        ['url' => site_url('peta'),                               'icon' => 'fa-map-marker-alt',    'title' => 'Peta',           'sub' => 'Wilayah ' . $sebutan],
        ['url' => site_url('first/statistik/bantuan_penduduk'),   'icon' => 'fa-hand-holding-heart', 'title' => 'Bantuan',     'sub' => 'Penerima Manfaat'],
    ];
?>
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
    <div class="grd-quick">
        <?php foreach ($sections as $s) : ?>
            <a href="<?= $s['url'] ?>" class="grd-quick__item" <?= ! empty($s['blank']) ? 'target="_blank" rel="noopener"' : '' ?>>
                <span class="grd-quick__icon"><i class="fas <?= $s['icon'] ?>"></i></span>
                <span class="grd-quick__title"><?= $s['title'] ?></span>
                <span class="grd-quick__sub"><?= $s['sub'] ?></span>
            </a>
        <?php endforeach ?>
    </div>
</section>
<?php endif ?>
