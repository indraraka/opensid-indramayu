<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (theme_config('layanan_mandiri_box', '1') == '1' && setting('layanan_mandiri') == 1) : ?>
<?php
    $sudah_login = isset($_SESSION['mandiri']) && $_SESSION['mandiri'] == 1;
    $kantor      = function_exists('gambar_desa') ? gambar_desa($desa['kantor_desa'], true) : '';
?>
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
    <div class="grd-layanan">
        <div class="grd-layanan__intro">
            <span class="grd-section-eyebrow" style="color:rgba(255,255,255,.8)">Mandiri</span>
            <h2 class="grd-layanan__title">Layanan Mandiri</h2>
            <p>Akses layanan administrasi <?= ucwords($this->setting->sebutan_desa) ?> secara online, kapan saja.</p>
        </div>
        <div class="grd-layanan__card">
            <img class="grd-layanan__logo" src="<?= gambar_desa($desa['logo']) ?>" alt="Logo">
            <?php if ($sudah_login) : ?>
                <p class="grd-layanan__note">Anda sedang online di Layanan Mandiri.</p>
            <?php endif ?>
            <a href="<?= site_url('layanan-mandiri/masuk') ?>" target="_blank" rel="noopener" class="btn btn-primary grd-layanan__btn">
                <i class="fas fa-sign-in-alt mr-1"></i> <?= $sudah_login ? 'Masuk Halaman' : 'Login Layanan Mandiri' ?>
            </a>
        </div>
        <div class="grd-layanan__info">
            <?php if ($kantor) : ?><img loading="lazy" src="<?= $kantor ?>" alt="Kantor" class="grd-layanan__info-img"><?php endif ?>
            <div class="grd-layanan__info-cta">
                <i class="fas fa-key"></i>
                <p>Hubungi <?= ucwords(setting('sebutan_pemerintah_desa') ?: 'Pemerintah Desa') ?> untuk mendapatkan PIN</p>
            </div>
        </div>
    </div>
</section>
<?php endif ?>
