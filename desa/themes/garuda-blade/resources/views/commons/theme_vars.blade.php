{{-- Garuda Blade — token palet. Dibaca dari Pengaturan Tema (theme_config) dengan
     fallback default per-varian; juga MEMETAKAN ke variabel warna tema esensi
     sehingga seluruh tema ikut berubah ke palet Garuda (tanpa hijau). --}}
@php
    $grd_primary     = theme_config('gradient_left', '#0E7490');
    $grd_primary_end = theme_config('gradient_right', '#155E75');
    $grd_accent      = theme_config('bgtop', '#06B6D4');
    $grd_secondary   = theme_config('warna_secondary', '#1E76C2');
    $grd_link        = theme_config('textlink', '#0C657C');
    $grd_link_hover  = theme_config('texthover', '#094A5C');
    $grd_scroll      = theme_config('withscroll', '#A5E8EF');
    $rgb             = static fn ($h) => implode(',', sscanf($h, '#%02x%02x%02x') ?: [0, 0, 0]);
@endphp
<style id="garuda-theme-vars">
    :root {
        /* ====== Brand Garuda (dapat dikustomisasi dari Pengaturan Tema) ====== */
        --grd-primary: {{ $grd_primary }};
        --grd-primary-end: {{ $grd_primary_end }};
        --grd-accent: {{ $grd_accent }};
        --grd-secondary: {{ $grd_secondary }};
        --grd-link: {{ $grd_link }};
        --grd-link-hover: {{ $grd_link_hover }};
        --grd-scroll: {{ $grd_scroll }};
        --grd-gradient: linear-gradient(100deg, var(--grd-primary) 0%, var(--grd-primary-end) 100%);
        --grd-r-md: 12px;
        --grd-r-lg: 16px;
        --grd-r-xl: 24px;
        --grd-font-display: 'Plus Jakarta Sans', sans-serif;

        /* ====== Override variabel warna tema esensi -> Garuda ====== */
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

    /* sentuhan Garuda: sudut lebih membulat & tautan ber-palet */
    .btn,
    .card,
    .rounded {
        border-radius: var(--grd-r-md);
    }

    a {
        color: var(--grd-link);
    }

    a:hover {
        color: var(--grd-link-hover);
    }
</style>
