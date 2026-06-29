<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 1 — Motif PESISIR / PANTAI (perahu nelayan, ombak, matahari) */ ?>
<section class="grd-container" style="margin-top:1.5rem;">
  <div class="grd-hero-motif grd-hero-motif--pesisir">
    <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi pantai, ombak, dan perahu nelayan">
      <defs>
        <linearGradient id="gtp1-sky" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#0E7490"/><stop offset="1" stop-color="#155E75"/>
        </linearGradient>
        <linearGradient id="gtp1-sea" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#2DD4DE"/><stop offset="1" stop-color="#0E7490"/>
        </linearGradient>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp1-sky)"/>
      <circle cx="1190" cy="92" r="72" fill="#FBBF24" opacity=".18"/>
      <circle cx="1190" cy="92" r="50" fill="#FBBF24"/>
      <path d="M250 74q14-14 28 0 14-14 28 0" fill="none" stroke="#E0F7FA" stroke-width="3" stroke-linecap="round"/>
      <path d="M338 104q11-11 22 0 11-11 22 0" fill="none" stroke="#E0F7FA" stroke-width="2.5" stroke-linecap="round"/>
      <path d="M0 208 C 240 168 480 248 720 208 C 960 168 1200 248 1440 208 L1440 320 L0 320 Z" fill="#2DD4DE" opacity=".5"/>
      <g transform="translate(560 146)">
        <rect x="-3" y="-58" width="6" height="118" rx="3" fill="#5B2A0C"/>
        <path d="M5 -56 L78 44 L5 44 Z" fill="#FCD34D"/>
        <path d="M-5 -42 L-64 44 L-5 44 Z" fill="#FDE68A"/>
        <path d="M-78 56 L78 56 L58 98 L-58 98 Z" fill="#7C3A12"/>
      </g>
      <path d="M0 252 C 220 222 460 288 720 254 C 980 222 1220 292 1440 254 L1440 320 L0 320 Z" fill="url(#gtp1-sea)"/>
      <path d="M0 288 C 240 270 520 312 760 292 C 1040 270 1240 312 1440 292 L1440 320 L0 320 Z" fill="#0B5566"/>
    </svg>
    <div class="grd-hero-motif__inner">
      <span class="grd-hero-motif__eyebrow"><i class="fas fa-water"></i> <?= theme_config('hero_eyebrow', 'Desa Pesisir') ?></span>
      <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
      <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Bersama membangun desa bahari yang maju, mandiri, dan sejahtera bagi seluruh warga.') ?></p>
    </div>
  </div>
</section>
<style>
  .grd-hero-motif{position:relative;overflow:hidden;border-radius:var(--grd-r-xl,24px);box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));min-height:220px;display:flex;align-items:center;}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding:2rem 1.75rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.18);backdrop-filter:blur(3px);color:#fff;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.35);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.94);max-width:31rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.3);margin:0;}
  @media(min-width:768px){.grd-hero-motif{min-height:300px;}}
</style>
