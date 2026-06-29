<?php  defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $bg_header = $latar_website ?>

<header style="background-image: url(<?= $bg_header ?>);" class="grd-topbg bg-center bg-cover bg-no-repeat relative text-white">
  <div class="grd-topbg__overlay"></div>

  <div class="grd-container relative z-10">
    <?php $this->load->view($folder_themes .'/commons/category_menu') ?>

    <section class="text-center space-y-2 pt-4 pb-10 px-3">
      <a href="<?= site_url() ?>" class="inline-block">
        <figure>
          <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo <?= ucfirst($this->setting->sebutan_desa).' '.ucwords($desa['nama_desa']) ?>" class="h-16 lg:h-20 mx-auto pb-2">
        </figure>
        <span class="text-h2 block"><?= NAMA_DESA ?></span>
        <p><?= ucfirst($this->setting->sebutan_kecamatan_singkat) ?>
          <?= ucwords($desa['nama_kecamatan']) ?>,
          <?= ucfirst($this->setting->sebutan_kabupaten_singkat) ?>
          <?= ucwords($desa['nama_kabupaten']) ?>,
          Provinsi
          <?= ucwords($desa['nama_propinsi']) ?>
        </p>
      </a>
    </section>
  </div>

  <?php if($teks_berjalan) : ?>
    <div class="relative z-20 bg-black bg-opacity-25 text-white py-1.5 text-xs">
      <div class="grd-container">
        <marquee onmouseover="this.stop();" onmouseout="this.start();" class="block">
          <?php foreach($teks_berjalan as $marquee) : ?>
            <span class="px-4">
              <i class="fas fa-bullhorn mr-1 text-amber-300"></i>
              <?= $marquee['teks'] ?>
              <?php if(trim($marquee['tautan']) && $marquee['judul_tautan']) : ?>
              <a href="<?= $marquee['tautan'] ?>" class="underline hover:text-amber-300"><?= $marquee['judul_tautan']?></a>
              <?php endif ?>
            </span>
          <?php endforeach ?>
        </marquee>
      </div>
    </div>
  <?php endif ?>
</header>
<?php $this->load->view($folder_themes .'/commons/main_menu') ?>
<?php $this->load->view($folder_themes .'/commons/mobile_menu') ?>
