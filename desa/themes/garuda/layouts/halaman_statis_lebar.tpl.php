<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <?php $this->load->view($folder_themes . '/commons/meta') ?>
  <?php $this->load->view($folder_themes . '/commons/source_css') ?>
</head>
<body class="font-primary bg-gray-100">

  <?php $this->load->view($folder_themes . '/commons/loading_screen') ?>
  <?php $this->load->view($folder_themes . '/commons/header') ?>

  <div class="grd-container my-8" style="margin-top:var(--section-y,3rem);margin-bottom:var(--section-y,3rem);">
    <main class="w-full space-y-1 bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow text-gray-600">
      <?php if ($tampil) : ?>
        <?php
          // Normalisasi slug legacy/premium agar selalu resolve ke partial tema
          $halaman_statis = str_replace(['home/idm', 'web/halaman_statis/lapak'], ['idm/index', 'lapak/index'], $halaman_statis);
        ?>
        <?php if (preg_match('/halaman_statis/i', $halaman_statis)) : ?>
          <?php $this->load->view($halaman_statis); ?>
        <?php else : ?>
          <?php $this->load->view("{$folder_themes}/partials/{$halaman_statis}"); ?>
        <?php endif ?>
      <?php else : ?>
        <?php theme_view('partials/not_found'); ?>
      <?php endif ?>
    </main>
  </div>

  <?php $this->load->view($folder_themes .'/commons/footer') ?>
  <?php $this->load->view($folder_themes . '/commons/source_js') ?>
  <script src="<?= theme_asset("js/script.min.js?" . THEME_VERSION) ?>"></script>

</body>
</html>
