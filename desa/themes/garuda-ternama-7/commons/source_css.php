<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (cek_koneksi_internet()): ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.compat.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css">
<link rel="stylesheet" href="https://unpkg.com/datatables@1.10.18/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.1.0/leaflet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/1.11.1/mapbox-gl.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.0/css/ionicons.min.css">
<?php endif ?>

<!-- Slider (self-host, jalan offline) -->
<link rel="stylesheet" href="<?= theme_asset("css/vendor/splide.min.css?" . THEME_VERSION) ?>">

<!-- Tailwind base (esensi) -->
<link rel="stylesheet" href="<?= theme_asset("css/style.min.css?" . THEME_VERSION) ?>">

<!-- Garuda design layer -->
<link rel="stylesheet" href="<?= theme_asset("css/custom.css?" . THEME_VERSION) ?>">

<!-- Variabel warna dari Pengaturan Tema + bootstrap mode gelap (harus paling akhir) -->
<?php $this->load->view($folder_themes . '/commons/theme_vars') ?>
