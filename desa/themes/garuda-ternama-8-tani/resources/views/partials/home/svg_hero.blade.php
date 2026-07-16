{{-- Garuda Blade — Motif Garuda Ternama 8 Tani --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Tani Makmur');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Lumbung pangan dan kebun mangga — kemakmuran tumbuh dari tanah desa.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--tani">
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi sawah, padi, dan panen">
      <defs>
        <linearGradient id="gtp8-sky" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--grd-primary)"/><stop offset="1" stop-color="var(--grd-primary-end)"/></linearGradient>
        <linearGradient id="gtp8-grain" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#FDE68A"/><stop offset="1" stop-color="#D97706"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp8-sky)"/>
      <circle cx="1230" cy="92" r="56" fill="#FFFBEB" opacity=".85"/>
      <circle cx="1230" cy="92" r="80" fill="#FFFBEB" opacity=".22"/>
      <path d="M0 180 C 240 150 480 196 720 174 C 960 150 1200 196 1440 172 L1440 320 L0 320 Z" fill="#0E7490"/>
      <path d="M0 220 C 260 198 520 236 760 214 C 1020 196 1240 232 1440 212 L1440 320 L0 320 Z" fill="#0B5F70"/>
      <path d="M0 262 C 300 244 560 280 820 262 C 1080 246 1280 278 1440 260 L1440 320 L0 320 Z" fill="#0A4456"/>
      <!-- mango on left hill -->
      <g transform="translate(170 150)"><ellipse cx="0" cy="0" rx="40" ry="31" fill="#F97316"/><path d="M-1 -31 q 4 -10 14 -12" fill="none" stroke="#3F2A12" stroke-width="4" stroke-linecap="round"/><ellipse cx="-12" cy="-9" rx="11" ry="7" fill="#FFF" opacity=".3"/></g>
      <!-- rice stalks foreground -->
      <g stroke="url(#gtp8-grain)" stroke-width="4" stroke-linecap="round" fill="url(#gtp8-grain)">
        <g transform="translate(560 320)"><path d="M0 0 C -6 -70 6 -120 0 -170" fill="none"/><g transform="translate(0 -170)"><ellipse cx="-9" cy="6" rx="5" ry="11" transform="rotate(-20 -9 6)"/><ellipse cx="9" cy="6" rx="5" ry="11" transform="rotate(20 9 6)"/><ellipse cx="-7" cy="26" rx="5" ry="11" transform="rotate(-20 -7 26)"/><ellipse cx="7" cy="26" rx="5" ry="11" transform="rotate(20 7 26)"/><ellipse cx="0" cy="-8" rx="5" ry="12"/></g></g>
        <g transform="translate(610 320)"><path d="M0 0 C -4 -60 8 -110 4 -150" fill="none"/><g transform="translate(4 -150)"><ellipse cx="-8" cy="6" rx="4.5" ry="10" transform="rotate(-20 -8 6)"/><ellipse cx="8" cy="6" rx="4.5" ry="10" transform="rotate(20 8 6)"/><ellipse cx="0" cy="-8" rx="4.5" ry="11"/></g></g>
        <g transform="translate(512 320)"><path d="M0 0 C -8 -56 4 -104 -2 -146" fill="none"/><g transform="translate(-2 -146)"><ellipse cx="-8" cy="6" rx="4.5" ry="10" transform="rotate(-20 -8 6)"/><ellipse cx="8" cy="6" rx="4.5" ry="10" transform="rotate(20 8 6)"/><ellipse cx="0" cy="-8" rx="4.5" ry="11"/></g></g>
      </g>
    </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-tractor"></i> {{ $grd_eyebrow }}</span>
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
