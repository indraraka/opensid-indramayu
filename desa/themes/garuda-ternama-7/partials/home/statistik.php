<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (theme_config('statistik_beranda', '1') == '1' && ! empty($stat_widget)) : ?>
<?php
    $total   = null;
    $rincian = [];
    foreach ($stat_widget as $row) {
        if (($row['jumlah'] ?? null) === null) {
            continue;
        }
        if (strtoupper($row['nama']) === 'JUMLAH') {
            $total = $row['jumlah'];
        } else {
            $rincian[] = $row;
        }
    }
    $fmt = static fn ($n) => function_exists('ribuan') ? ribuan($n) : number_format((int) $n, 0, ',', '.');
    $ikon_rincian = ['fa-male', 'fa-female', 'fa-house', 'fa-users', 'fa-user'];
    $links = [
        ['url' => site_url('data-wilayah'),                       'icon' => 'fa-map-marker-alt',  'label' => 'Data Wilayah'],
        ['url' => site_url('data-statistik/pendidikan-dalam-kk'), 'icon' => 'fa-graduation-cap',  'label' => 'Data Pendidikan'],
        ['url' => site_url('data-statistik/pekerjaan'),           'icon' => 'fa-briefcase',       'label' => 'Data Pekerjaan'],
        ['url' => site_url('data-statistik/rentang-umur'),        'icon' => 'fa-users',           'label' => 'Data Usia'],
    ];
?>
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
    <div class="grd-statistik">
        <div class="grd-statistik__total">
            <i class="fas fa-users grd-statistik__total-icon"></i>
            <span class="grd-statistik__total-num"><?= $total !== null ? $fmt($total) : '-' ?></span>
            <span class="grd-statistik__total-label">Total Penduduk</span>
        </div>
        <div class="grd-statistik__main">
            <div class="grd-statistik__bar">
                <div>
                    <span class="grd-section-eyebrow">Data Kependudukan</span>
                    <h2 class="grd-section-title">Statistik <?= ucwords($this->setting->sebutan_desa) ?></h2>
                </div>
            </div>
            <div class="grd-statistik__tiles">
                <?php foreach (array_slice($rincian, 0, 4) as $i => $row) : ?>
                <div class="grd-stat">
                    <i class="fas <?= $ikon_rincian[$i] ?? 'fa-user' ?> grd-stat__icon"></i>
                    <span class="grd-stat__num"><?= $fmt($row['jumlah']) ?></span>
                    <span class="grd-stat__label"><?= ucwords(strtolower($row['nama'])) ?></span>
                </div>
                <?php endforeach ?>
            </div>
            <div class="grd-statistik__links">
                <?php foreach ($links as $l) : ?>
                <a href="<?= $l['url'] ?>" class="grd-statistik__link">
                    <span class="grd-statistik__link-icon"><i class="fas <?= $l['icon'] ?>"></i></span>
                    <span><?= $l['label'] ?></span>
                    <i class="fas fa-chevron-right grd-statistik__link-arrow"></i>
                </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<?php endif ?>
