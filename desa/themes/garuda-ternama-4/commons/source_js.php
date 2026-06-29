<?php  defined('BASEPATH') || exit('No direct script access allowed'); ?>

<!-- Alpine & Splide (self-host, jalan walau offline) -->
<script defer src="<?= theme_asset('js/vendor/alpine.min.js?' . THEME_VERSION) ?>"></script>
<script src="<?= theme_asset('js/vendor/splide.min.js?' . THEME_VERSION) ?>"></script>

<?php if (cek_koneksi_internet()): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://unpkg.com/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-providers/1.6.0/leaflet-providers.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/2.0.1/mapbox-gl.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl-leaflet/0.0.14/leaflet-mapbox-gl.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.carousel.js"></script>
<?php endif ?>

<?= view('admin.layouts.components.token') ?>

<script>
    if (window.jQuery && $.fn.dataTable) {
        $.extend($.fn.dataTable.defaults, {
            lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Semua"]
            ],
            pageLength: 10,
            language: {
            url: "<?= asset('bootstrap/js/dataTables.indonesian.lang') ?>",
            }
        });
    }
</script>

<!-- Interaksi Garuda (dark mode, countdown, back-to-top) -->
<script defer src="<?= theme_asset('js/garuda.js?' . THEME_VERSION) ?>"></script>

<?php if (! setting('inspect_element')): ?>
    <script src="<?= asset('js/disabled.min.js') ?>"></script>
<?php endif ?>
