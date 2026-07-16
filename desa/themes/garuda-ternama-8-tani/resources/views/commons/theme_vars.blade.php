{{-- Garuda Blade — palet & token identitas: Tani (Singaraja) — hijau sawah + emas padi.
     Diemit SETELAH custom.css di <head> sehingga token :root ini menang cascade
     (font/radius/section tiap tema benar-benar berlaku, bukan sekadar warna). --}}
@php
    $grd_primary     = theme_config('gradient_left', '#3E8E4A');
    $grd_primary_end = theme_config('gradient_right', '#2A6435');
    $grd_accent      = theme_config('bgtop', '#E3A81C');
    $grd_secondary   = theme_config('warna_secondary', '#5BA84F');
    $grd_link        = theme_config('textlink', '#2F6B38');
    $grd_link_hover  = theme_config('texthover', '#214E29');
    $grd_scroll      = theme_config('withscroll', '#BFE3B5');
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
        --grd-r-md: 10px; --grd-r-lg: 14px; --grd-r-xl: 18px;
        --section-y: clamp(2.5rem,1.5rem + 3vw,4.5rem);
        --grd-font-display: "Lucida Sans Unicode","Lucida Grande","Segoe UI",sans-serif;
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
