{{-- Garuda Blade — hero motif (BASE). Varian menimpa file ini dengan motif khas
     (pesisir, mangga, rusa, batik complongan, tari topeng, dll). Warna mengikuti
     palet via var(--grd-*); teks dapat diatur dari Pengaturan Tema. --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Website Resmi');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Pelayanan publik yang terbuka, transparan, dan dekat dengan warga.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--base">
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Sampul Garuda">
            <defs>
                <linearGradient id="grdHeroBg" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="var(--grd-primary)" />
                    <stop offset="1" stop-color="var(--grd-primary-end)" />
                </linearGradient>
            </defs>
            <rect width="1440" height="320" fill="url(#grdHeroBg)" />
            <circle cx="1240" cy="80" r="64" fill="#ffffff" opacity=".06" />
            <circle cx="1310" cy="170" r="32" fill="#ffffff" opacity=".05" />
            <circle cx="120" cy="60" r="40" fill="var(--grd-accent)" opacity=".12" />
            <path d="M0 232 C 360 196 720 276 1080 236 C 1260 216 1440 246 1440 246 L1440 320 L0 320 Z" fill="var(--grd-accent)" opacity=".20" />
            <path d="M0 266 C 360 236 720 300 1080 268 C 1260 252 1440 280 1440 280 L1440 320 L0 320 Z" fill="#ffffff" opacity=".09" />
        </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-landmark"></i> {{ $grd_eyebrow }}</span>
            <h2 class="grd-hero-motif__title">{{ $grd_title }}</h2>
            <p class="grd-hero-motif__sub">{{ $grd_sub }}</p>
        </div>
    </div>
</section>
<style>
    .grd-hero-wrap {
        margin: 1.25rem 0 1rem;
    }

    .grd-hero-motif {
        position: relative;
        overflow: hidden;
        border-radius: var(--grd-r-xl, 24px);
        box-shadow: 0 4px 18px rgba(8, 24, 48, .14);
        min-height: 210px;
        display: flex;
        align-items: center;
    }

    .grd-hero-motif__art {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .grd-hero-motif__inner {
        position: relative;
        z-index: 2;
        padding: 2rem 1.9rem;
    }

    .grd-hero-motif__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(255, 255, 255, .18);
        backdrop-filter: blur(3px);
        color: #fff;
        font-weight: 700;
        font-size: .72rem;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: .3rem .85rem;
        border-radius: 9999px;
    }

    .grd-hero-motif__title {
        font-family: var(--grd-font-display, sans-serif);
        color: #fff;
        font-weight: 800;
        font-size: clamp(1.4rem, 1rem + 2vw, 2.4rem);
        margin: .65rem 0 .35rem;
        text-shadow: 0 2px 14px rgba(0, 0, 0, .35);
        line-height: 1.12;
    }

    .grd-hero-motif__sub {
        color: rgba(255, 255, 255, .95);
        max-width: 33rem;
        font-size: .97rem;
        text-shadow: 0 1px 8px rgba(0, 0, 0, .3);
        margin: 0;
    }

    @media (min-width: 768px) {
        .grd-hero-motif {
            min-height: 300px;
        }
    }
</style>
