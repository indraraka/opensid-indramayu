{{-- Garuda Blade — Motif Garuda Ternama 9 Indramayu Raya --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Indramayu Raya');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Rusa, mangga, dan samudra — tiga jati diri desa dalam satu cita pembangunan.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--raya">
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Lambang gabungan rusa, mangga, dan ombak khas Indramayu">
    <defs>
      <linearGradient id="gtp9-bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--grd-primary)"/><stop offset="1" stop-color="var(--grd-primary-end)"/></linearGradient>
      <linearGradient id="gtp9-gold" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#FCE8A8"/><stop offset=".5" stop-color="#EAB308"/><stop offset="1" stop-color="#A16207"/>
      </linearGradient>
    </defs>
    <rect width="1440" height="320" fill="url(#gtp9-bg)"/>
    <g stroke="#EAB308" stroke-width="1.2" opacity=".12" fill="none">
      <path d="M60 40 h120 v40 M60 280 h120 v-40 M1380 40 h-120 v40 M1380 280 h-120 v-40"/>
    </g>
    <g transform="translate(720 168)">
      <!-- shield -->
      <path d="M0 -118 C 60 -100 96 -98 110 -100 C 110 -20 96 70 0 118 C -96 70 -110 -20 -110 -100 C -96 -98 -60 -100 0 -118 Z" fill="#0B3B38" stroke="url(#gtp9-gold)" stroke-width="6"/>
      <!-- waves base (teal) -->
      <path d="M-104 40 C -60 20 -40 56 0 40 C 40 24 64 56 104 40 C 100 78 60 104 0 110 C -60 104 -100 78 -104 40 Z" fill="#0E7490"/>
      <path d="M-92 58 C -56 44 -36 70 0 58 C 38 46 60 70 92 58" fill="none" stroke="#67E8F9" stroke-width="3" opacity=".7"/>
      <!-- deer (gold) upper -->
      <g fill="url(#gtp9-gold)" transform="translate(0 -50) scale(.74)">
        <path d="M0 70 C -22 70 -32 46 -30 22 C -28 0 -14 -12 0 -12 C 14 -12 28 0 30 22 C 32 46 22 70 0 70 Z"/>
        <path d="M-24 0 q -18 -2 -24 12 q 16 6 26 -4 Z"/><path d="M24 0 q 18 -2 24 12 q -16 6 -26 -4 Z"/>
        <g fill="none" stroke="url(#gtp9-gold)" stroke-width="5" stroke-linecap="round">
          <path d="M-13 -8 C -18 -38 -36 -46 -34 -76"/><path d="M-16 -28 C -34 -36 -42 -50 -46 -60"/>
          <path d="M13 -8 C 18 -38 36 -46 34 -76"/><path d="M16 -28 C 34 -36 42 -50 46 -60"/>
        </g>
        <g fill="#0B3B38"><circle cx="-11" cy="24" r="4"/><circle cx="11" cy="24" r="4"/></g>
      </g>
      <!-- mango center -->
      <g transform="translate(0 18)"><ellipse cx="0" cy="0" rx="30" ry="24" fill="#F97316"/><path d="M-1 -24 q 4 -8 12 -10" fill="none" stroke="#3F2A12" stroke-width="4" stroke-linecap="round"/><path d="M14 -28 q 18 -6 26 6 q -16 8 -28 0 Z" fill="#0E7490"/><ellipse cx="-9" cy="-7" rx="8" ry="5" fill="#FFF" opacity=".3"/></g>
      <!-- star crest -->
      <path d="M0 -150 l 7 18 l 19 1 l -15 12 l 6 19 l -17 -11 l -17 11 l 6 -19 l -15 -12 l 19 -1 Z" fill="url(#gtp9-gold)"/>
    </g>
    <!-- ribbon -->
    <g transform="translate(720 300)">
      <path d="M-150 -10 L150 -10 L132 14 L-132 14 Z" fill="url(#gtp9-gold)"/>
      <path d="M-150 -10 L-178 6 L-150 14 Z" fill="#A16207"/><path d="M150 -10 L178 6 L150 14 Z" fill="#A16207"/>
    </g>
  </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-shield-alt"></i> {{ $grd_eyebrow }}</span>
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
