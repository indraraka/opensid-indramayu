{{-- Garuda Blade — Motif Garuda Ternama 4 Pantai Senja --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Pesona Senja Pantai');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Menyinari setiap langkah pembangunan desa, dari pesisir untuk warga.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--pantai-senja">
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi mercusuar dan matahari terbenam di pantai">
    <defs>
      <linearGradient id="gtp4-sky" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--grd-primary)"/><stop offset="1" stop-color="var(--grd-primary-end)"/></linearGradient>
      <linearGradient id="gtp4-sea" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#0EA5E9"/><stop offset="1" stop-color="#0C4A6E"/>
      </linearGradient>
    </defs>
    <rect width="1440" height="320" fill="url(#gtp4-sky)"/>
    <circle cx="720" cy="208" r="96" fill="#FDE68A" opacity=".95"/>
    <circle cx="720" cy="208" r="128" fill="#FDE68A" opacity=".25"/>
    <g stroke="#FDE68A" stroke-width="5" opacity=".5" stroke-linecap="round">
      <path d="M1090 150 L1230 96"/><path d="M1090 158 L1260 150"/><path d="M1090 166 L1230 214"/>
    </g>
    <g transform="translate(1040 70)">
      <path d="M22 10 L58 10 L52 170 L28 170 Z" fill="#F8FAFC"/>
      <path d="M24 40 L56 40 L54 64 L26 64 Z" fill="#2563EB"/><path d="M27 92 L53 92 L51 116 L29 116 Z" fill="#2563EB"/>
      <rect x="30" y="-14" width="20" height="26" rx="3" fill="#FDE68A"/><path d="M26 -16 L54 -16 L48 -2 L32 -2 Z" fill="#1E40AF"/>
      <rect x="16" y="168" width="48" height="14" rx="3" fill="#0C4A6E"/>
    </g>
    <path d="M0 248 C 240 224 480 280 720 252 C 960 224 1200 282 1440 252 L1440 320 L0 320 Z" fill="url(#gtp4-sea)"/>
    <path d="M0 286 C 260 270 520 308 760 290 C 1040 270 1240 308 1440 290 L1440 320 L0 320 Z" fill="#0A3A5C"/>
  </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-sun"></i> {{ $grd_eyebrow }}</span>
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
