<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  // Halaman beranda murni (bukan daftar kategori / pencarian / halaman lanjutan)
  $is_beranda = empty($cari)
    && $this->uri->segment(2) != 'kategori'
    && $this->uri->segment(2) !== 'index'
    && $this->uri->segment(1) !== 'index';

  $title = (! empty($judul_kategori)) ? $judul_kategori : 'Artikel Terkini';
  if (is_array($title)) {
    $title = $title['kategori'];
  }
?>

<?php if ($is_beranda) : ?>
  <?php $this->load->view($folder_themes . '/partials/home/svg_hero') ?>
  <?php $this->load->view($folder_themes . '/partials/home/banner') ?>
  <?php if (theme_config('slider_beranda', '1') == '1' && count($slider_gambar['gambar'] ?? []) > 0) : ?>
    <div class="grd-container" style="margin-top:1.25rem;">
      <?php $this->load->view($folder_themes . '/partials/slider') ?>
    </div>
  <?php endif ?>
  <?php $this->load->view($folder_themes . '/partials/home/statistik') ?>
<?php endif ?>

<?php // ====== Artikel Terkini (lebar penuh, tanpa sidebar) ====== ?>
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
  <div class="grd-section-bar">
    <div>
      <span class="grd-section-eyebrow"><?= $is_beranda ? 'Kabar Terbaru' : 'Kategori' ?></span>
      <h2 class="grd-section-title"><?= $title ?></h2>
    </div>
    <form action="<?= site_url() ?>" role="search" class="grd-search">
      <i class="fas fa-search"></i>
      <input type="text" name="cari" value="<?= htmlspecialchars($cari ?? '', ENT_QUOTES) ?>" placeholder="Cari artikel...">
    </form>
  </div>

  <?php if ($is_beranda && theme_config('headline_beranda', '1') == '1' && ! empty($headline)) : ?>
    <div class="mb-6"><?php $this->load->view($folder_themes . '/partials/headline') ?></div>
  <?php endif ?>

  <?php if ($artikel) : ?>
    <div class="grd-article-grid">
      <?php foreach ($artikel as $post) : ?>
        <?php
          $url   = site_url('artikel/' . buat_slug($post));
          $image = ($post['gambar'] && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar']))
            ? AmbilFotoArtikel($post['gambar'], 'sedang')
            : gambar_desa($desa['logo']);
          $abstrak = potong_teks(strip_tags($post['isi']), 110);
        ?>
        <article class="grd-article-card">
          <a href="<?= $url ?>" class="grd-article-card__media" tabindex="-1" aria-hidden="true">
            <img loading="lazy" src="<?= $image ?>" alt="<?= htmlspecialchars($post['judul'], ENT_QUOTES) ?>">
          </a>
          <div class="grd-article-card__body">
            <ul class="grd-article-card__meta">
              <li><i class="fas fa-calendar-alt"></i> <?= tgl_indo($post['tgl_upload']) ?></li>
              <?php if (! empty($post['kategori'])) : ?><li><i class="fas fa-bookmark"></i> <?= $post['kategori'] ?></li><?php endif ?>
            </ul>
            <h3 class="grd-article-card__title"><a href="<?= $url ?>"><?= potong_teks($post['judul'], 75) ?></a></h3>
            <p class="grd-article-card__excerpt"><?= $abstrak ?></p>
            <a href="<?= $url ?>" class="grd-article-card__more">Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
          </div>
        </article>
      <?php endforeach ?>
    </div>
    <?php $data['paging_page'] = $paging_page ?>
    <div class="grd-pagination flex-wrap w-full mt-8 justify-center">
      <?php $this->load->view($folder_themes . '/commons/paging', $data) ?>
    </div>
  <?php else : ?>
    <?php $data['title'] = $title ?>
    <div class="bg-white rounded-lg shadow p-6"><?php $this->load->view($folder_themes . '/partials/empty_article', $data) ?></div>
  <?php endif ?>
</section>

<?php if ($is_beranda) : ?>
  <?php $this->load->view($folder_themes . '/partials/home/aparatur') ?>
  <?php $this->load->view($folder_themes . '/partials/home/galeri') ?>
  <?php $this->load->view($folder_themes . '/partials/home/statistik_layanan') ?>
  <?php $this->load->view($folder_themes . '/partials/home/layanan') ?>
  <?php $this->load->view($folder_themes . '/partials/home/countdown') ?>
  <div style="height:var(--section-y,3rem)"></div>
<?php endif ?>
