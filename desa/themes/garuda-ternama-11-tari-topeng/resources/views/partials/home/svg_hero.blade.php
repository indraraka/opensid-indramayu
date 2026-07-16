{{-- Garuda Blade — Motif Garuda Ternama 11 Tari Topeng --}}
@php
    $grd_eyebrow = theme_config('hero_eyebrow', 'Tari Topeng');
    $grd_title   = theme_config('hero_title', '') ?: ('Selamat Datang di ' . ucwords((string) setting('sebutan_desa')) . ' ' . ucwords((string) identitas('nama_desa')));
    $grd_sub     = theme_config('hero_sub', 'Negeri seni — merawat Tari Topeng Dermayon yang adiluhung dari generasi ke generasi.');
@endphp
<section class="grd-hero-wrap">
    <div class="grd-hero-motif grd-hero-motif--topeng">
        {{-- Topeng digambar sebagai ARTEFAK UKIR, bukan karakter: mata gabahan berupa
             celah ukir (tanpa bola mata/pupil), mulut celah terkatup, tanpa merah.
             Sumping & sampur sengaja DITIADAKAN — saat diapit elemen simetris, topeng
             terbaca sebagai wajah bertelinga/berbahu dan jatuhnya lucu. Palet ungu+emas
             mengikuti theme_vars (varian ini sengaja tanpa merah). --}}
        <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Motif Tari Topeng Dermayon: topeng Panji berjamang emas di atas bidang batik isen">
      <defs>
        <linearGradient id="gtp11-bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--grd-primary)"/><stop offset="1" stop-color="var(--grd-primary-end)"/></linearGradient>
        <linearGradient id="gtp11-gold" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#F8E6AE"/><stop offset="1" stop-color="#DDA22F"/>
        </linearGradient>
        <linearGradient id="gtp11-kayu" x1="0.2" y1="0" x2="0.75" y2="1">
          <stop offset="0" stop-color="#FCF6E9"/><stop offset="1" stop-color="#E0C9A0"/>
        </linearGradient>
        <radialGradient id="gtp11-sinar" cx="0.5" cy="0.5" r="0.5">
          <stop offset="0" stop-color="#F8E6AE" stop-opacity=".20"/><stop offset="1" stop-color="#F8E6AE" stop-opacity="0"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp11-bg)"/>
      <!-- isen-isen batik samar, melintang penuh -->
      <g fill="#F8E6AE" opacity=".2">
        <?php for ($x = 40; $x < 1420; $x += 60): for ($y = 60; $y < 300; $y += 60): ?>
          <circle cx="<?= $x ?>" cy="<?= $y ?>" r="2.4"/>
        <?php endfor; endfor; ?>
      </g>
      <!-- TOPENG PANJI (wanda halus) -->
      <g transform="translate(1066 158)">
        <circle cx="0" cy="6" r="150" fill="url(#gtp11-sinar)"/>
        <!-- jamang (mahkota) -->
        <g transform="translate(0 -70)">
          <path d="M-62 16 C -52 -22 52 -22 62 16 L 52 22 C 30 6 -30 6 -52 22 Z" fill="url(#gtp11-gold)" stroke="#9A6410" stroke-width="2"/>
          <path d="M0 -2 C 10 -34 4 -54 0 -66 C -4 -54 -10 -34 0 -2 Z" fill="url(#gtp11-gold)" stroke="#9A6410" stroke-width="1.5"/>
          <circle cx="0" cy="-6" r="6" fill="#4A1D66"/>
          <path d="M-34 -2 C -34 -24 -46 -30 -52 -44 C -36 -40 -24 -28 -22 -4 Z" fill="url(#gtp11-gold)"/>
          <path d="M34 -2 C 34 -24 46 -30 52 -44 C 36 -40 24 -28 22 -4 Z" fill="url(#gtp11-gold)"/>
          <g fill="#FCF6E9" opacity=".85"><circle cx="-30" cy="12" r="3.2"/><circle cx="0" cy="14" r="3.2"/><circle cx="30" cy="12" r="3.2"/></g>
        </g>
        <!-- bidang topeng -->
        <ellipse cx="0" cy="6" rx="58" ry="76" fill="url(#gtp11-kayu)"/>
        <ellipse cx="0" cy="6" rx="58" ry="76" fill="none" stroke="url(#gtp11-gold)" stroke-width="2.5" opacity=".9"/>
        <path d="M-56 -6 C -56 48 -29 84 0 84 C 29 84 56 48 56 -6" fill="none" stroke="#C9AE80" stroke-width="1.6" opacity=".55"/>
        <!-- alis ukir -->
        <g fill="none" stroke="#4A3520" stroke-width="3" stroke-linecap="round" opacity=".8">
          <path d="M-44 -20 C -32 -31 -14 -29 -5 -21"/>
          <path d="M44 -20 C 32 -31 14 -29 5 -21"/>
        </g>
        <!-- mata gabahan: celah ukir, tanpa bola mata -->
        <g fill="#3B2440">
          <path d="M-44 -4 C -34 -15 -14 -15 -5 -6 C -16 -1 -34 0 -44 -4 Z"/>
          <path d="M44 -4 C 34 -15 14 -15 5 -6 C 16 -1 34 0 44 -4 Z"/>
        </g>
        <!-- hidung: bubungan ukir -->
        <path d="M-6 27 C -3 13 -2 1 0 -8 C 2 1 3 13 6 27 C 3 30 -3 30 -6 27 Z" fill="#F3E7CE" stroke="#C9AE80" stroke-width="1.2"/>
        <!-- mulut: celah ukir terkatup -->
        <path d="M-15 50 C -5 45.5 5 45.5 15 50 C 5 54.5 -5 54.5 -15 50 Z" fill="#5A3A28" opacity=".9"/>
        <path d="M-15 50 C -5 48 5 48 15 50" fill="none" stroke="#3B2440" stroke-width="1.2" opacity=".55"/>
        <!-- riasan pipi (curl batik) -->
        <g fill="none" stroke="#DDA22F" stroke-width="3" stroke-linecap="round" opacity=".85">
          <path d="M-44 28 q -10 13 -2 25"/>
          <path d="M44 28 q 10 13 2 25"/>
        </g>
      </g>
    </svg>
        <div class="grd-hero-motif__inner">
            <span class="grd-hero-motif__eyebrow"><i class="fas fa-theater-masks"></i> {{ $grd_eyebrow }}</span>
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
