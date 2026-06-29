<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
    // Warna dapat dikustomisasi dari Admin > Tema > Pengaturan (config.json)
    $grd_primary       = theme_config('gradient_left', '#4F46E5');
    $grd_primary_end   = theme_config('gradient_right', '#312E81');
    $grd_accent        = theme_config('bgtop', '#818CF8');
    $grd_secondary     = theme_config('warna_secondary', '#6366F1');
    $grd_link          = theme_config('textlink', '#3730A3');
    $grd_link_hover    = theme_config('texthover', '#252063');
    $grd_scroll        = theme_config('withscroll', '#C7D2FE');
    $slider_tinggi     = (int) theme_config('slider_tinggi', '560');
    if ($slider_tinggi < 200 || $slider_tinggi > 1000) {
        $slider_tinggi = 560;
    }
?>
<style id="garuda-theme-vars">
:root {
    /* ====== Brand (dapat dikustomisasi dari Pengaturan Tema) ====== */
    --grd-primary: <?= $grd_primary ?>;
    --grd-primary-end: <?= $grd_primary_end ?>;
    --grd-accent: <?= $grd_accent ?>;
    --grd-secondary: <?= $grd_secondary ?>;
    --grd-link: <?= $grd_link ?>;
    --grd-link-hover: <?= $grd_link_hover ?>;
    --grd-scroll: <?= $grd_scroll ?>;
    --grd-gradient: linear-gradient(100deg, var(--grd-primary) 0%, var(--grd-primary-end) 100%);
    --grd-slider-h: <?= $slider_tinggi ?>px;

    /* ====== Pemetaan ke variabel Tailwind tema (esensi compat) ====== */
    --primary-base-color: <?= $grd_primary ?>;
    --primary-darken-color: <?= $grd_primary_end ?>;
    --secondary-base-color: <?= $grd_accent ?>;
    --secondary-darken-color: <?= $grd_primary_end ?>;
    --accent-base-color: <?= $grd_primary ?>;
    --accent-darken-color: <?= $grd_primary ?>;
}
</style>
<script>
    // Terapkan mode gelap sebelum render (anti-FOUC)
    (function () {
        try {
            // Default terang untuk situs pemerintahan; mode gelap hanya bila pengguna memilih.
            var saved = localStorage.getItem('garuda-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        } catch (e) {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    })();
</script>
