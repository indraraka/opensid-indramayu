{{-- Garuda Blade — palet & token identitas: Bahari (Telukagung) — teal bahari + biru laut.
     Diemit SETELAH custom.css di <head> sehingga token :root ini menang cascade
     (font/radius/section tiap tema benar-benar berlaku, bukan sekadar warna). --}}
@php
    $grd_primary     = theme_config('gradient_left', '#0C7E92');
    $grd_primary_end = theme_config('gradient_right', '#075C6C');
    $grd_accent      = theme_config('bgtop', '#19BACB');
    $grd_secondary   = theme_config('warna_secondary', '#0E96AC');
    $grd_link        = theme_config('textlink', '#0A6071');
    $grd_link_hover  = theme_config('texthover', '#074453');
    $grd_scroll      = theme_config('withscroll', '#A6E6EF');
    $rgb             = static fn ($h) => implode(',', sscanf($h, '#%02x%02x%02x') ?: [0, 0, 0]);
    $grd_slider_h    = max(200, min(1000, (int) theme_config('slider_tinggi', '560')));
@endphp
<style id="garuda-theme-vars">
    :root {
        --grd-primary: {{ $grd_primary }};
        --grd-primary-end: {{ $grd_primary_end }};
        --grd-accent: {{ $grd_accent }};
        --grd-secondary: {{ $grd_secondary }};
        --grd-link: {{ $grd_link }};
        --grd-link-hover: {{ $grd_link_hover }};
        --grd-scroll: {{ $grd_scroll }};
        --grd-gradient: linear-gradient(100deg, var(--grd-primary) 0%, var(--grd-primary-end) 100%);
        --grd-slider-h: {{ $grd_slider_h }}px;
        --grd-r-md: 6px; --grd-r-lg: 10px; --grd-r-xl: 14px;
        --section-y: clamp(2.5rem,1.5rem + 3vw,4.4rem);
        --grd-font-display: "Tahoma","Segoe UI",sans-serif;
        /* ====== Override variabel warna tema esensi -> palet tema ====== */
        --primary-base-color: {{ $grd_primary }};
        --primary-darken-color: {{ $grd_primary_end }};
        --secondary-base-color: {{ $grd_accent }};
        --secondary-darken-color: {{ $grd_primary_end }};
        --accent-base-color: {{ $grd_accent }};
        --accent-darken-color: {{ $grd_primary }};
        --bs-primary: {{ $grd_primary }};
        --bs-primary-rgb: {{ $rgb($grd_primary) }};
        --bs-secondary: {{ $grd_accent }};
        --bs-secondary-rgb: {{ $rgb($grd_accent) }};
    }
    .btn, .card, .rounded { border-radius: var(--grd-r-md); }
    a { color: var(--grd-link); }
    a:hover { color: var(--grd-link-hover); }
</style>
