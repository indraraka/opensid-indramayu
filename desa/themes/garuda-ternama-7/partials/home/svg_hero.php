<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 7 — Motif BAHARI BIRU (jangkar, perahu layar, camar, ombak) */ ?>
<section class="grd-container" style="margin-top:1.5rem;">
  <div class="grd-hero-motif grd-hero-motif--bahari">
    <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi bahari: jangkar, perahu layar, dan camar">
      <defs>
        <linearGradient id="gtp7-sky" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#0E5E73"/><stop offset="1" stop-color="#0B4A5C"/>
        </linearGradient>
        <linearGradient id="gtp7-sea" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#22D3EE"/><stop offset="1" stop-color="#0E7490"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp7-sky)"/>
      <circle cx="240" cy="78" r="40" fill="#BFDBFE" opacity=".5"/>
      <g fill="none" stroke="#BAE6FD" stroke-width="3" stroke-linecap="round" opacity=".7">
        <path d="M300 70q14-14 28 0 14-14 28 0"/><path d="M380 100q11-11 22 0 11-11 22 0"/><path d="M1180 80q12-12 24 0 12-12 24 0"/>
      </g>
      <!-- anchor -->
      <g transform="translate(1130 70)" fill="none" stroke="#E0F2FE" stroke-width="9" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="0" cy="6" r="14"/><line x1="0" y1="20" x2="0" y2="150"/><line x1="-34" y1="60" x2="34" y2="60"/>
        <path d="M-46 110 C -46 150 -16 162 0 162 C 16 162 46 150 46 110"/>
        <path d="M-46 110 l -16 8 l 6 -24 Z" fill="#E0F2FE"/><path d="M46 110 l 16 8 l -6 -24 Z" fill="#E0F2FE"/>
      </g>
      <!-- sailboat -->
      <g transform="translate(520 120)">
        <rect x="-2" y="-60" width="5" height="120" fill="#E2E8F0"/>
        <path d="M6 -58 L70 50 L6 50 Z" fill="#F8FAFC"/><path d="M-6 -44 L-58 50 L-6 50 Z" fill="#CBD5E1"/>
        <path d="M-78 58 L80 58 L60 96 L-58 96 Z" fill="#7F1D1D"/>
      </g>
      <path d="M0 208 C 240 178 480 248 720 212 C 960 178 1200 248 1440 212 L1440 320 L0 320 Z" fill="#22D3EE" opacity=".5"/>
      <path d="M0 250 C 240 222 480 288 720 254 C 960 222 1200 290 1440 254 L1440 320 L0 320 Z" fill="url(#gtp7-sea)"/>
      <path d="M0 288 C 260 272 520 312 760 294 C 1040 272 1240 312 1440 294 L1440 320 L0 320 Z" fill="#0B5566"/>
    </svg>
    <div class="grd-hero-motif__inner">
      <span class="grd-hero-motif__eyebrow"><i class="fas fa-anchor"></i> <?= theme_config('hero_eyebrow', 'Desa Bahari') ?></span>
      <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
      <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Tangguh seperti nelayan, melaju bersama menuju desa yang berdaya.') ?></p>
    </div>
  </div>
</section>
<style>
  .grd-hero-motif{position:relative;overflow:hidden;border-radius:var(--grd-r-xl,24px);box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));min-height:220px;display:flex;align-items:center;}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding:2rem 1.75rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(34,211,238,.2);backdrop-filter:blur(3px);color:#fff;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.4);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.95);max-width:31rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.4);margin:0;}
  @media(min-width:768px){.grd-hero-motif{min-height:300px;}}
</style>
