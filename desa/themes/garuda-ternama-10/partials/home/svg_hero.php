<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php /* Garuda Ternama 10 — Motif BATIK COMPLONGAN khas Pabean Udik/Indramayu
        (titik-titik complong, sulur Dermayon, kembang & burung loksan) */ ?>
<section class="grd-container" style="margin-top:1.5rem;">
  <div class="grd-hero-motif grd-hero-motif--batik">
    <svg class="grd-hero-motif__art" viewBox="0 0 1440 320" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi Batik Complongan khas Indramayu: titik complong, sulur, dan kembang">
      <defs>
        <linearGradient id="gtp10-bg" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stop-color="#3B36A8"/><stop offset="1" stop-color="#221C5E"/>
        </linearGradient>
        <linearGradient id="gtp10-gold" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stop-color="#F6E4B0"/><stop offset="1" stop-color="#E0A437"/>
        </linearGradient>
        <!-- tekstur titik COMPLONGAN (ciri khas: kain dilubangi jarum) -->
        <pattern id="gtp10-complong" width="24" height="24" patternUnits="userSpaceOnUse">
          <circle cx="6" cy="6" r="2.3" fill="#EBCB7A" opacity=".45"/>
          <circle cx="18" cy="18" r="2.3" fill="#EBCB7A" opacity=".45"/>
        </pattern>
      </defs>
      <rect width="1440" height="320" fill="url(#gtp10-bg)"/>
      <rect width="1440" height="320" fill="url(#gtp10-complong)"/>
      <!-- pita complongan rapat di tepi atas -->
      <g fill="#F0D58A">
        <?php for ($x = 30; $x < 1440; $x += 34): ?>
          <circle cx="<?= $x ?>" cy="26" r="3.4" opacity=".8"/>
          <circle cx="<?= $x + 17 ?>" cy="40" r="2.6" opacity=".5"/>
        <?php endfor; ?>
      </g>
      <!-- sulur (tendril) Dermayon mengalir -->
      <g fill="none" stroke="url(#gtp10-gold)" stroke-width="5" stroke-linecap="round" opacity=".9">
        <path d="M-20 250 C 180 250 240 150 360 150 C 470 150 500 250 620 240"/>
        <path d="M620 240 C 740 232 770 140 880 150 C 980 158 1010 250 1120 244"/>
        <path d="M360 150 c -10 -40 -54 -44 -60 -84"/>
        <path d="M880 150 c 10 -38 56 -40 64 -82"/>
      </g>
      <!-- daun-daun kecil sepanjang sulur -->
      <g fill="#CDA8E8">
        <path d="M300 66 q -22 6 -26 26 q 22 2 30 -18 Z"/>
        <path d="M944 68 q 22 6 26 26 q -22 2 -30 -18 Z"/>
        <path d="M205 250 q -22 -8 -40 4 q 16 16 38 4 Z"/>
        <path d="M1095 246 q 22 -8 40 4 q -16 16 -38 4 Z"/>
      </g>
      <!-- kembang batik (mandala) kiri -->
      <g transform="translate(250 168)">
        <g fill="url(#gtp10-gold)">
          <?php for ($i = 0; $i < 8; $i++): $a = $i * 45; ?>
            <g transform="rotate(<?= $a ?>)"><path d="M0 -16 C 16 -40 16 -70 0 -86 C -16 -70 -16 -40 0 -16 Z"/></g>
          <?php endfor; ?>
        </g>
        <circle r="22" fill="#7A1330"/><circle r="11" fill="#F0D58A"/>
        <g fill="#F0D58A"><?php for ($i = 0; $i < 12; $i++): $a = $i * 30; ?><circle cx="<?= round(54 * cos(deg2rad($a)), 1) ?>" cy="<?= round(54 * sin(deg2rad($a)), 1) ?>" r="3"/><?php endfor; ?></g>
      </g>
      <!-- burung loksan (merak ter-stilir) kanan -->
      <g transform="translate(1120 150)">
        <path d="M0 0 C -34 -10 -54 -44 -40 -78 C -30 -60 -8 -54 6 -64 C 26 -46 24 -14 0 0 Z" fill="url(#gtp10-gold)"/>
        <circle cx="-30" cy="-66" r="7" fill="#221C5E"/><circle cx="-30" cy="-66" r="3" fill="#F0D58A"/>
        <path d="M-30 -73 l 14 -16" stroke="#7A1330" stroke-width="4" stroke-linecap="round"/>
        <!-- ekor merak -->
        <g fill="none" stroke="url(#gtp10-gold)" stroke-width="4" stroke-linecap="round">
          <path d="M2 -6 C 50 6 70 40 60 84"/><path d="M10 2 C 64 18 86 52 78 96"/><path d="M-4 8 C 36 30 44 66 30 100"/>
        </g>
        <g fill="#9BE3EC"><circle cx="60" cy="84" r="6"/><circle cx="78" cy="96" r="6"/><circle cx="30" cy="100" r="6"/></g>
      </g>
      <!-- gelombang isen di dasar -->
      <path d="M0 296 C 240 282 520 312 760 298 C 1040 282 1240 312 1440 298 L1440 320 L0 320 Z" fill="#1A1550" opacity=".8"/>
    </svg>
    <div class="grd-hero-motif__inner">
      <span class="grd-hero-motif__eyebrow"><i class="fas fa-paint-brush"></i> <?= theme_config('hero_eyebrow', 'Batik Complongan') ?></span>
      <h2 class="grd-hero-motif__title"><?= theme_config('hero_title', '') ?: ('Selamat Datang di ' . NAMA_DESA) ?></h2>
      <p class="grd-hero-motif__sub"><?= theme_config('hero_sub', 'Negeri pembatik — melestarikan Batik Complongan khas Dermayon dari titik ke titik.') ?></p>
    </div>
  </div>
</section>
<style>
  .grd-hero-motif{position:relative;overflow:hidden;border-radius:var(--grd-r-xl,24px);box-shadow:var(--grd-shadow-md,0 4px 14px rgba(8,24,48,.1));min-height:220px;display:flex;align-items:center;}
  .grd-hero-motif__art{position:absolute;inset:0;width:100%;height:100%;}
  .grd-hero-motif__inner{position:relative;z-index:2;padding:2rem 1.75rem;}
  .grd-hero-motif__eyebrow{display:inline-flex;align-items:center;gap:.4rem;background:rgba(240,213,138,.22);backdrop-filter:blur(3px);color:#fff;font-weight:700;font-size:.72rem;letter-spacing:.06em;text-transform:uppercase;padding:.3rem .85rem;border-radius:9999px;}
  .grd-hero-motif__title{font-family:var(--grd-font-display,sans-serif);color:#fff;font-weight:800;font-size:clamp(1.4rem,1rem+2vw,2.4rem);margin:.65rem 0 .35rem;text-shadow:0 2px 14px rgba(0,0,0,.45);line-height:1.1;}
  .grd-hero-motif__sub{color:rgba(255,255,255,.95);max-width:32rem;font-size:.95rem;text-shadow:0 1px 8px rgba(0,0,0,.45);margin:0;}
  @media(min-width:768px){.grd-hero-motif{min-height:300px;}}
</style>
