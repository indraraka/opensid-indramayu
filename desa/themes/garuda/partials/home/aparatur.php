<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    $perangkat = $aparatur_desa['daftar_perangkat'] ?? [];
?>
<?php if (theme_config('aparatur_beranda', '1') == '1' && ! empty($perangkat)) : ?>
<?php $placeholder = base_url('desa/themes/garuda/assets/images/foto-tidak-tersedia.png'); ?>
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
    <div class="grd-section-bar">
        <div>
            <span class="grd-section-eyebrow">Struktur Organisasi</span>
            <h2 class="grd-section-title">Pemerintah <?= ucwords($this->setting->sebutan_desa) ?></h2>
        </div>
        <a href="<?= site_url('pemerintah') ?>" class="grd-section-link">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="grd-aparatur-grid">
        <?php foreach (array_slice($perangkat, 0, 10) as $i => $data) : ?>
        <div class="grd-official <?= $i === 0 ? 'grd-official--kepala' : '' ?>">
            <div class="grd-official__media">
                <img loading="lazy" src="<?= $data['foto'] ?: $placeholder ?>" alt="<?= htmlspecialchars($data['nama'], ENT_QUOTES) ?>" onerror="this.src='<?= $placeholder ?>'">
                <?php if ($i === 0) : ?><span class="grd-official__crown"><i class="fas fa-star"></i></span><?php endif ?>
            </div>
            <div class="grd-official__body">
                <h4><?= $data['nama'] ?></h4>
                <p><?= $data['jabatan'] ?></p>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</section>
<?php endif ?>
