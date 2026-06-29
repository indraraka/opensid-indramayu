<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 3 — Motif RUSA WANA (rusa khas Indramayu, hutan) — full-bleed */ ?>
<section class="grd-hero-motif grd-hero-motif--full grd-hero-motif--rusa">
  <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi rusa khas Indramayu di tepi hutan">
    <defs>
      <linearGradient id="gtp3-bg" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#16314F"/><stop offset="1" stop-color="#0A1A33"/>
      </linearGradient>
      <linearGradient id="gtp3-deer" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#F0C24B"/><stop offset="1" stop-color="#B97D17"/>
      </linearGradient>
    </defs>
    <rect width="1440" height="320" fill="url(#gtp3-bg)"/>
    <circle cx="1140" cy="96" r="62" fill="#FDE9B8" opacity=".9"/>
    <circle cx="1140" cy="96" r="86" fill="#FDE9B8" opacity=".12"/>
    <g fill="#0A2A45">
      <path d="M120 320 L210 150 L300 320 Z"/><path d="M250 320 L340 130 L430 320 Z"/>
      <path d="M1050 320 L1130 175 L1210 320 Z"/><path d="M1200 320 L1300 145 L1400 320 Z"/>
    </g>
    <path d="M0 286 C 260 262 520 300 760 282 C 1020 262 1240 300 1440 282 L1440 320 L0 320 Z" fill="#122E4A"/>
    <g transform="translate(640 96)" fill="url(#gtp3-deer)" stroke="url(#gtp3-deer)">
      <!-- legs -->
      <rect x="6" y="150" width="11" height="74" rx="5" stroke="none"/><rect x="44" y="150" width="11" height="74" rx="5" stroke="none"/>
      <rect x="120" y="150" width="11" height="74" rx="5" stroke="none"/><rect x="158" y="150" width="11" height="74" rx="5" stroke="none"/>
      <!-- body -->
      <ellipse cx="92" cy="138" rx="92" ry="42" stroke="none"/>
      <!-- tail -->
      <path d="M182 110 q 22 -6 18 22 q -14 4 -18 -22 Z" stroke="none"/>
      <!-- neck + head -->
      <path d="M8 150 C -18 96 -10 56 24 40 C 40 32 48 44 44 60 C 36 96 44 128 30 150 Z" stroke="none"/>
      <ellipse cx="22" cy="40" rx="20" ry="26" transform="rotate(-22 22 40)" stroke="none"/>
      <path d="M2 26 q -20 -10 -30 4 q 18 6 30 -4 Z" stroke="none"/>
      <!-- ears -->
      <path d="M30 16 q -16 -16 -2 -30 q 12 12 2 30 Z" stroke="none"/>
      <!-- antlers -->
      <g fill="none" stroke-width="7" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 8 C 16 -28 36 -44 28 -78"/><path d="M24 -22 C 4 -34 -2 -52 -6 -64"/><path d="M26 -48 C 12 -58 8 -70 6 -82"/>
        <path d="M34 6 C 44 -26 30 -46 44 -76"/><path d="M36 -24 C 56 -34 62 -52 66 -64"/><path d="M40 -50 C 54 -60 58 -72 60 -84"/>
      </g>
    </g>
  </svg>
  <div class="grd-container grd-hero-motif__inner">
    <span class="grd-hero-motif__eyebrow"><i class="fas fa-tree"></i> <?= theme_config('hero_eyebrow', 'Khas Indramayu') ?></span>
    <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
    <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Anggun dan lestari — desa yang menjaga alam serta budaya warisan leluhur.') ?></p>
  </div>
</section>
<style>
  .grd-hero-motif--full{position:relative;overflow:hidden;min-height:240px;display:flex;align-items:center;box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding-block:2.2rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(240,194,75,.22);backdrop-filter:blur(3px);color:#FDE9B8;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.45);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.92);max-width:31rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.4);margin:0;}
  @media(min-width:768px){.grd-hero-motif--full{min-height:320px;}}
</style>
