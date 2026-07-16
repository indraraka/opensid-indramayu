{{-- Garuda Blade — palet & token identitas: Kebun Mangga (Plumbon) — daun mangga + buah ranum.
     Diemit SETELAH custom.css di <head> sehingga token :root ini menang cascade
     (font/radius/section tiap tema benar-benar berlaku, bukan sekadar warna). --}}
@php
    $grd_primary     = theme_config('gradient_left', '#5E8C24');
    $grd_primary_end = theme_config('gradient_right', '#3F6118');
    $grd_accent      = theme_config('bgtop', '#F4A60B');
    $grd_secondary   = theme_config('warna_secondary', '#7CA82F');
    $grd_link        = theme_config('textlink', '#4A6E1C');
    $grd_link_hover  = theme_config('texthover', '#344F13');
    $grd_scroll      = theme_config('withscroll', '#D7E8AE');
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
        --grd-r-md: 14px; --grd-r-lg: 20px; --grd-r-xl: 26px;
        --section-y: clamp(2.4rem,1.5rem + 2.8vw,4.3rem);
        --grd-font-display: "Verdana","Geneva",sans-serif;
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
