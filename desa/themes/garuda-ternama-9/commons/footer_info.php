<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $grd_ada_peta = ! empty($data_config['lat']) && ! empty($data_config['lng']); ?>
<?php if (theme_config('footer_peta', '1') == '1' && $grd_ada_peta) : ?>
<?php
  $sebutan = ucwords($this->setting->sebutan_desa);
  $sm_icon = ['facebook' => 'fa-facebook-f', 'twitter' => 'fa-twitter', 'instagram' => 'fa-instagram', 'telegram' => 'fa-telegram', 'whatsapp' => 'fa-whatsapp', 'youtube' => 'fa-youtube', 'tiktok' => 'fa-tiktok'];
?>
<section class="grd-footer-info">
  <div class="grd-container grd-footer-info__grid">
    <div class="grd-footer-info__col">
      <?php $this->load->view($folder_themes . '/widgets/peta_lokasi_kantor', ['judul_widget' => 'Lokasi Kantor ' . $sebutan]) ?>
    </div>
    <div class="grd-footer-info__identity">
      <img src="<?= gambar_desa($desa['logo']) ?>" class="grd-footer-info__logo" alt="Logo">
      <h3 class="grd-footer-info__name">PEMERINTAH <?= strtoupper($sebutan) ?> <?= strtoupper($desa['nama_desa']) ?></h3>
      <p class="grd-footer-info__addr">
        <?php if (! empty($desa['alamat_kantor'])) : ?><?= $desa['alamat_kantor'] ?><br><?php endif ?>
        <?= ucfirst($this->setting->sebutan_kecamatan_singkat) . ' ' . ucwords($desa['nama_kecamatan']) ?>, <?= ucfirst($this->setting->sebutan_kabupaten_singkat) . ' ' . ucwords($desa['nama_kabupaten']) ?><br>
        Provinsi <?= ucwords($desa['nama_propinsi']) ?>
      </p>
      <ul class="grd-footer-info__contact">
        <?php if (! empty($desa['telepon'])) : ?><li><i class="fas fa-phone-alt"></i> <?= $desa['telepon'] ?></li><?php endif ?>
        <?php if (! empty($desa['nomor_operator'])) : ?><li><i class="fas fa-mobile-alt"></i> <?= $desa['nomor_operator'] ?></li><?php endif ?>
        <?php if (! empty($desa['email_desa'])) : ?><li><i class="fas fa-envelope"></i> <?= strtolower($desa['email_desa']) ?></li><?php endif ?>
      </ul>
      <ul class="grd-footer-info__social">
        <?php foreach (($sosmed ?? []) as $sm) : ?>
          <?php $nm = strtolower($sm['nama'] ?? ''); ?>
          <?php if (! empty($sm['link']) && isset($sm_icon[$nm])) : ?>
            <li><a href="<?= $sm['link'] ?>" target="_blank" rel="noopener" aria-label="<?= $sm['nama'] ?>"><i class="fab <?= $sm_icon[$nm] ?>"></i></a></li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="grd-footer-info__col">
      <?php $this->load->view($folder_themes . '/widgets/peta_wilayah_desa', ['judul_widget' => 'Wilayah ' . $sebutan]) ?>
    </div>
  </div>
</section>
<?php endif ?>