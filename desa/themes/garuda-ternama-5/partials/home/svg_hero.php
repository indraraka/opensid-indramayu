<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 5 — Motif KEBUN MANGGA (kebun/pohon mangga, buah) */ ?>
<section class="grd-container" style="margin-top:1.5rem;">
  <div class="grd-hero-motif grd-hero-motif--kebun">
    <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi kebun pohon mangga">
      <defs>
        <linearGradient id="gtp5-sky" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#0EA5E9"/><stop offset="1" stop-color="#075985"/>
        </linearGradient>
        <radialGradient id="gtp5-canopy" cx=".4" cy=".35" r=".8">
          <stop offset="0" stop-color="#0E7490"/><stop offset="1" stop-color="#0B3B4A"/>
        </radialGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp5-sky)"/>
      <circle cx="1280" cy="70" r="46" fill="#FEF3C7" opacity=".85"/>
      <g>
        <!-- mango trees row -->
        <g transform="translate(180 96)"><rect x="-12" y="120" width="24" height="100" rx="6" fill="#5B3A1A"/><circle cx="0" cy="80" r="96" fill="url(#gtp5-canopy)"/><circle cx="-44" cy="96" r="11" fill="#F97316"/><circle cx="40" cy="70" r="11" fill="#FACC15"/><circle cx="8" cy="120" r="10" fill="#EA580C"/></g>
        <g transform="translate(560 70)"><rect x="-14" y="150" width="28" height="100" rx="6" fill="#5B3A1A"/><circle cx="0" cy="100" r="118" fill="url(#gtp5-canopy)"/><circle cx="-56" cy="120" r="13" fill="#F97316"/><circle cx="52" cy="96" r="13" fill="#FACC15"/><circle cx="0" cy="150" r="12" fill="#EA580C"/><circle cx="-10" cy="64" r="11" fill="#FB923C"/></g>
        <g transform="translate(980 100)"><rect x="-12" y="120" width="24" height="100" rx="6" fill="#5B3A1A"/><circle cx="0" cy="80" r="92" fill="url(#gtp5-canopy)"/><circle cx="42" cy="92" r="11" fill="#F97316"/><circle cx="-40" cy="70" r="11" fill="#FACC15"/></g>
        <g transform="translate(1300 110)"><rect x="-10" y="110" width="20" height="100" rx="5" fill="#5B3A1A"/><circle cx="0" cy="74" r="80" fill="url(#gtp5-canopy)"/><circle cx="-34" cy="86" r="10" fill="#F97316"/><circle cx="36" cy="64" r="10" fill="#FACC15"/></g>
      </g>
      <path d="M0 268 C 260 250 520 290 760 272 C 1020 250 1240 290 1440 272 L1440 320 L0 320 Z" fill="#0C4A6E"/>
      <path d="M0 296 C 300 282 560 312 820 298 C 1080 284 1280 312 1440 300 L1440 320 L0 320 Z" fill="#0B3B4A"/>
    </svg>
    <div class="grd-hero-motif__inner">
      <span class="grd-hero-motif__eyebrow"><i class="fas fa-seedling"></i> <?= theme_config('hero_eyebrow', 'Kebun Mangga') ?></span>
      <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
      <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Hijau menyejukkan, panen melimpah — kearifan agraris warga desa.') ?></p>
    </div>
  </div>
</section>
<style>
  .grd-hero-motif{position:relative;overflow:hidden;border-radius:var(--grd-r-xl,24px);box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));min-height:220px;display:flex;align-items:center;}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding:2rem 1.75rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.2);backdrop-filter:blur(3px);color:#fff;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.4);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.95);max-width:31rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.4);margin:0;}
  @media(min-width:768px){.grd-hero-motif{min-height:300px;}}
</style>
