<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (theme_config('galeri_strip', '1') == '1' && ! empty($w_gal)) : ?>
<section class="grd-container grd-galeri" style="margin-top:var(--section-y,3rem);">
    <div class="grd-galeri__head">
        <div>
            <span class="grd-section-eyebrow">Dokumentasi</span>
            <h2 class="grd-section-title">Galeri <?= ucwords($this->setting->sebutan_desa) ?></h2>
        </div>
        <a href="<?= site_url('galeri') ?>" class="grd-galeri__more">Semua Album <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="grd-galeri__strip">
        <?php foreach ($w_gal as $album) : ?>
            <?php if (is_file(LOKASI_GALERI . 'kecil_' . $album['gambar'])) : ?>
            <a href="<?= site_url('first/sub_gallery/' . $album['id']) ?>" class="grd-galeri__item" title="<?= htmlspecialchars($album['nama'], ENT_QUOTES) ?>">
                <img loading="lazy" src="<?= AmbilGaleri($album['gambar'], 'kecil') ?>" alt="<?= htmlspecialchars($album['nama'], ENT_QUOTES) ?>">
                <span class="grd-galeri__caption"><?= $album['nama'] ?></span>
            </a>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</section>
<?php endif ?>
