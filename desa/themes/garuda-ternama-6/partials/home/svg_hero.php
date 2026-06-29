<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 6 — Motif RUSA EMAS (emblem kepala rusa, medali) — full-bleed elegan */ ?>
<section class="grd-hero-motif grd-hero-motif--full grd-hero-motif--rusaemas">
  <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Emblem kepala rusa khas Indramayu">
    <defs>
      <linearGradient id="gtp6-bg" x1="0" y1="0" x2="1" y2="1">
        <stop offset="0" stop-color="#0B5F78"/><stop offset="1" stop-color="#06303D"/>
      </linearGradient>
      <linearGradient id="gtp6-gold" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#FBE38E"/><stop offset=".5" stop-color="#D4AF37"/><stop offset="1" stop-color="#9A7B1B"/>
      </linearGradient>
    </defs>
    <rect width="1440" height="320" fill="url(#gtp6-bg)"/>
    <g stroke="#D4AF37" stroke-width="1" opacity=".14" fill="none">
      <circle cx="220" cy="80" r="60"/><circle cx="220" cy="80" r="92"/>
      <circle cx="1240" cy="250" r="70"/><circle cx="1240" cy="250" r="104"/>
    </g>
    <g transform="translate(720 160)">
      <circle r="118" fill="none" stroke="url(#gtp6-gold)" stroke-width="6"/>
      <circle r="104" fill="none" stroke="#D4AF37" stroke-width="1.5" opacity=".6"/>
      <!-- laurel -->
      <g fill="url(#gtp6-gold)" opacity=".9">
        <g transform="translate(-96 18)"><path d="M0 0 q -16 -10 -34 -6 q 10 16 34 6 Z"/><path d="M6 22 q -16 -10 -34 -6 q 10 16 34 6 Z"/><path d="M12 44 q -16 -10 -34 -6 q 10 16 34 6 Z"/></g>
        <g transform="translate(96 18) scale(-1 1)"><path d="M0 0 q -16 -10 -34 -6 q 10 16 34 6 Z"/><path d="M6 22 q -16 -10 -34 -6 q 10 16 34 6 Z"/><path d="M12 44 q -16 -10 -34 -6 q 10 16 34 6 Z"/></g>
      </g>
      <!-- deer head frontal -->
      <g fill="url(#gtp6-gold)">
        <path d="M0 86 C -28 86 -40 56 -38 26 C -36 0 -18 -16 0 -16 C 18 -16 36 0 38 26 C 40 56 28 86 0 86 Z"/>
        <path d="M-30 -4 q -22 -2 -30 14 q 20 8 32 -6 Z"/><path d="M30 -4 q 22 -2 30 14 q -20 8 -32 -6 Z"/>
        <g fill="none" stroke="url(#gtp6-gold)" stroke-width="6" stroke-linecap="round">
          <path d="M-16 -12 C -22 -46 -44 -56 -42 -92"/><path d="M-20 -36 C -42 -44 -52 -62 -56 -74"/><path d="M-30 -62 C -46 -70 -52 -82 -54 -94"/>
          <path d="M16 -12 C 22 -46 44 -56 42 -92"/><path d="M20 -36 C 42 -44 52 -62 56 -74"/><path d="M30 -62 C 46 -70 52 -82 54 -94"/>
        </g>
      </g>
      <g fill="#0B5F78"><circle cx="-14" cy="30" r="5"/><circle cx="14" cy="30" r="5"/><path d="M0 52 q -7 8 0 14 q 7 -6 0 -14 Z"/></g>
      <!-- star above -->
      <path d="M0 -132 l 6 16 l 17 1 l -13 11 l 5 17 l -15 -10 l -15 10 l 5 -17 l -13 -11 l 17 -1 Z" fill="url(#gtp6-gold)"/>
    </g>
  </svg>
  <div class="grd-container grd-hero-motif__inner grd-hero-motif__inner--center">
    <span class="grd-hero-motif__eyebrow"><i class="fas fa-award"></i> <?= theme_config('hero_eyebrow', 'Lambang Kebanggaan') ?></span>
    <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
    <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Berwibawa dan bermartabat — pelayanan prima bagi seluruh masyarakat desa.') ?></p>
  </div>
</section>
<style>
  .grd-hero-motif--full{position:relative;overflow:hidden;min-height:240px;display:flex;align-items:center;box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding-block:2.2rem;}
  .grd-hero-motif__inner--center{text-align:center;display:flex;flex-direction:column;align-items:center;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(212,175,55,.18);backdrop-filter:blur(3px);color:#FBE38E;font-weight:700;font-size:.72rem;letter-spacing:.08em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;border:1px solid rgba(212,175,55,.4);}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.7rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.5);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.9);max-width:34rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.45);margin:0;}
  @media(min-width:768px){.grd-hero-motif--full{min-height:330px;}}
</style>
