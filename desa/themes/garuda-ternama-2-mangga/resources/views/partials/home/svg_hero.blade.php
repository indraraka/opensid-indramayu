{{-- Garuda Blade — Motif Garuda Ternama 2 Mangga --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Negeri Mangga');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Subur, asri, dan produktif — desa penghasil mangga khas Indramayu.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--mangga">
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi buah mangga, dahan, dan daun">
      <defs>
        <linearGradient id="gtp2-bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--grd-primary)"/><stop offset="1" stop-color="var(--grd-primary-end)"/></linearGradient>
        <linearGradient id="gtp2-fruit" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stop-color="#FACC15"/><stop offset=".55" stop-color="#F97316"/><stop offset="1" stop-color="#C2410C"/>
        </linearGradient>
        <linearGradient id="gtp2-leaf" x1="0" y1="0" x2="1" y2="0">
          <stop offset="0" stop-color="#0E7490"/><stop offset="1" stop-color="#0B3B4A"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp2-bg)"/>
      <circle cx="200" cy="60" r="120" fill="#2563EB" opacity=".25"/>
      <circle cx="1320" cy="300" r="150" fill="#0E7490" opacity=".18"/>
      <g transform="translate(980 -10)">
        <path d="M60 0 C 130 70 150 170 90 300" fill="none" stroke="#3F2A12" stroke-width="10" stroke-linecap="round"/>
        <g transform="translate(150 60) rotate(20)"><path d="M0 0 C 60 -22 120 -8 150 28 C 110 44 50 40 0 0 Z" fill="url(#gtp2-leaf)"/><path d="M6 6 C 60 0 110 8 144 26" fill="none" stroke="#0F1E4D" stroke-width="2"/></g>
        <g transform="translate(60 150) rotate(-12)"><path d="M0 0 C 56 -20 112 -6 142 26 C 104 42 48 38 0 0 Z" fill="url(#gtp2-leaf)"/></g>
        <g transform="translate(150 150)"><ellipse cx="0" cy="0" rx="64" ry="50" fill="url(#gtp2-fruit)"/><path d="M-2 -50 q 6 -16 22 -18" fill="none" stroke="#3F2A12" stroke-width="6" stroke-linecap="round"/><ellipse cx="-20" cy="-14" rx="18" ry="11" fill="#FFF" opacity=".28"/></g>
        <g transform="translate(40 230)"><ellipse cx="0" cy="0" rx="54" ry="42" fill="url(#gtp2-fruit)"/><path d="M-1 -42 q 5 -13 18 -15" fill="none" stroke="#3F2A12" stroke-width="5" stroke-linecap="round"/><ellipse cx="-16" cy="-12" rx="15" ry="9" fill="#FFF" opacity=".26"/></g>
      </g>
      <g transform="translate(150 220)" opacity=".9"><ellipse cx="0" cy="0" rx="40" ry="31" fill="url(#gtp2-fruit)"/><path d="M-1 -31 q 4 -10 14 -12" fill="none" stroke="#3F2A12" stroke-width="4" stroke-linecap="round"/></g>
    </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-leaf"></i> {{ $grd_eyebrow }}</span>
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
