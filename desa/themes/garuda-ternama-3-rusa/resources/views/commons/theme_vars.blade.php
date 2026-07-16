{{-- Garuda Blade — palet varian Garuda Ternama 3 Rusa --}}
@php
    $grd_primary     = theme_config('gradient_left', '#2156D6');
    $grd_primary_end = theme_config('gradient_right', '#15368C');
    $grd_accent      = theme_config('bgtop', '#4D8AF7');
    $grd_secondary   = theme_config('warna_secondary', '#2C63E0');
    $grd_link        = theme_config('textlink', '#1B40A8');
    $grd_link_hover  = theme_config('texthover', '#122B70');
    $grd_scroll      = theme_config('withscroll', '#C3D5FB');
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
        --grd-r-md: 12px; --grd-r-lg: 16px; --grd-r-xl: 24px;
        --grd-font-display: 'Plus Jakarta Sans', sans-serif;
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