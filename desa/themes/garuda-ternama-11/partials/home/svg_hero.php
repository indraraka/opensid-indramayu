<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 11 — Motif TARI TOPENG khas Pekandangan/Indramayu (Topeng Dermayon:
        topeng berjamang emas, mata almond, sampur menari) */ ?>
<section class="grd-container" style="margin-top:1.5rem;">
  <div class="grd-hero-motif grd-hero-motif--topeng">
    <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi Tari Topeng khas Indramayu: topeng berjamang emas dan sampur menari">
      <defs>
        <linearGradient id="gtp11-bg" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stop-color="#2747C6"/><stop offset="1" stop-color="#16276E"/>
        </linearGradient>
        <linearGradient id="gtp11-gold" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#F8E6AE"/><stop offset="1" stop-color="#DDA22F"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp11-bg)"/>
      <!-- isen titik batik samar -->
      <g fill="#9DB2F2" opacity=".5">
        <?php for ($x = 40; $x < 760; $x += 60): for ($y = 60; $y < 300; $y += 60): ?>
          <circle cx="<?= $x ?>" cy="<?= $y ?>" r="2.4"/>
        <?php endfor; endfor; ?>
      </g>
      <!-- sulur dekoratif kiri -->
      <g fill="none" stroke="url(#gtp11-gold)" stroke-width="4" stroke-linecap="round" opacity=".5">
        <path d="M60 250 C 160 250 180 150 120 90 C 96 130 150 150 150 150"/>
        <path d="M120 90 q -28 -8 -34 -38"/>
      </g>
      <!-- TOPENG -->
      <g transform="translate(1066 158)">
        <!-- sampur (selendang) menari -->
        <g fill="none" stroke="url(#gtp11-gold)" stroke-width="7" stroke-linecap="round" opacity=".6">
          <path d="M-150 130 C -118 64 -168 6 -120 -64"/>
          <path d="M150 130 C 118 64 168 6 120 -64"/>
        </g>
        <!-- jamang (mahkota) -->
        <g transform="translate(0 -70)">
          <path d="M-62 16 C -52 -22 52 -22 62 16 L 52 22 C 30 6 -30 6 -52 22 Z" fill="url(#gtp11-gold)" stroke="#9A6410" stroke-width="2"/>
          <path d="M0 -2 C 10 -34 4 -54 0 -66 C -4 -54 -10 -34 0 -2 Z" fill="url(#gtp11-gold)" stroke="#9A6410" stroke-width="1.5"/>
          <circle cx="0" cy="-6" r="7" fill="#C21F3E"/>
          <path d="M-34 -2 C -34 -24 -46 -30 -52 -44 C -36 -40 -24 -28 -22 -4 Z" fill="url(#gtp11-gold)"/>
          <path d="M34 -2 C 34 -24 46 -30 52 -44 C 36 -40 24 -28 22 -4 Z" fill="url(#gtp11-gold)"/>
          <g fill="#9BE3EC"><circle cx="-30" cy="12" r="3.4"/><circle cx="0" cy="14" r="3.4"/><circle cx="30" cy="12" r="3.4"/></g>
        </g>
        <!-- wajah topeng -->
        <ellipse cx="0" cy="6" rx="60" ry="78" fill="#F3E6CF"/>
        <path d="M-58 -4 C -58 50 -30 86 0 86 C 30 86 58 50 58 -4" fill="none" stroke="#D7BF92" stroke-width="2" opacity=".7"/>
        <!-- sumping (hiasan telinga) -->
        <g fill="url(#gtp11-gold)">
          <path d="M-60 12 C -82 6 -86 28 -70 34 C -58 38 -54 24 -60 12 Z"/>
          <path d="M60 12 C 82 6 86 28 70 34 C 58 38 54 24 60 12 Z"/>
        </g>
        <!-- alis -->
        <g fill="none" stroke="#3A2410" stroke-width="5" stroke-linecap="round">
          <path d="M-42 -16 C -30 -28 -14 -26 -6 -18"/>
          <path d="M42 -16 C 30 -28 14 -26 6 -18"/>
        </g>
        <!-- mata almond -->
        <g>
          <path d="M-42 -2 C -30 -14 -12 -14 -4 -2 C -12 8 -30 8 -42 -2 Z" fill="#FFFFFF" stroke="#3A2410" stroke-width="2.5"/>
          <circle cx="-23" cy="-2" r="5" fill="#241A0E"/>
          <path d="M42 -2 C 30 -14 12 -14 4 -2 C 12 8 30 8 42 -2 Z" fill="#FFFFFF" stroke="#3A2410" stroke-width="2.5"/>
          <circle cx="23" cy="-2" r="5" fill="#241A0E"/>
        </g>
        <!-- hidung -->
        <path d="M0 0 C 7 16 9 28 0 34 C -9 28 -7 16 0 0 Z" fill="#E7D3AE" stroke="#C8A878" stroke-width="1.5"/>
        <!-- bibir -->
        <path d="M-18 52 C -6 60 6 60 18 52 C 6 64 -6 64 -18 52 Z" fill="#C21F3E"/>
        <!-- riasan pipi (curl batik) -->
        <g fill="none" stroke="#DDA22F" stroke-width="3" stroke-linecap="round" opacity=".85">
          <path d="M-46 26 q -10 12 -2 24"/>
          <path d="M46 26 q 10 12 2 24"/>
        </g>
      </g>
    </svg>
    <div class="grd-hero-motif__inner">
      <span class="grd-hero-motif__eyebrow"><i class="fas fa-theater-masks"></i> <?= theme_config('hero_eyebrow', 'Tari Topeng') ?></span>
      <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
      <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Negeri seni — merawat Tari Topeng Dermayon yang adiluhung dari generasi ke generasi.') ?></p>
    </div>
  </div>
</section>
<style>
  .grd-hero-motif{position:relative;overflow:hidden;border-radius:var(--grd-r-xl,24px);box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));min-height:220px;display:flex;align-items:center;}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding:2rem 1.75rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(248,230,174,.2);backdrop-filter:blur(3px);color:#fff;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.45);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.95);max-width:32rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.45);margin:0;}
  @media(min-width:768px){.grd-hero-motif{min-height:300px;}}
</style>
