<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (theme_config('event_countdown', '1') == '1') : ?>
<?php
    // Hari besar nasional berulang tiap tahun (tanggal-bulan => nama)
    $events = [
        '01-01' => 'Tahun Baru Masehi',
        '21-04' => 'Hari Kartini',
        '01-05' => 'Hari Buruh Nasional',
        '02-05' => 'Hari Pendidikan Nasional',
        '20-05' => 'Hari Kebangkitan Nasional',
        '01-06' => 'Hari Lahir Pancasila',
        '01-07' => 'Hari Bhayangkara',
        '17-08' => 'HUT Kemerdekaan RI',
        '01-10' => 'Hari Kesaktian Pancasila',
        '28-10' => 'Hari Sumpah Pemuda',
        '10-11' => 'Hari Pahlawan',
        '22-12' => 'Hari Ibu',
        '25-12' => 'Hari Natal',
    ];
    $now    = time();
    $next   = null;
    $nextTs = null;
    foreach ($events as $md => $nama) {
        [$d, $m] = explode('-', $md);
        $ts = mktime(0, 0, 0, (int) $m, (int) $d, (int) date('Y'));
        if ($ts < $now) {
            $ts = mktime(0, 0, 0, (int) $m, (int) $d, (int) date('Y') + 1);
        }
        if ($nextTs === null || $ts < $nextTs) {
            $nextTs = $ts;
            $next   = $nama;
        }
    }
    $iso     = date('Y-m-d\T00:00:00', $nextTs);
    $tglNext = date('Y-m-d', $nextTs);
?>
<section class="grd-countdown-band">
    <div class="grd-container grd-countdown-band__inner">
        <div class="grd-countdown-band__label">
            <span class="grd-section-eyebrow">Menyambut</span>
            <h3 class="grd-countdown-band__title"><?= $next ?></h3>
            <p class="grd-countdown-band__date"><?= tgl_indo($tglNext) ?></p>
        </div>
        <div class="grd-countdown" data-grd-countdown="<?= $iso ?>" data-grd-done="Selamat <?= htmlspecialchars($next, ENT_QUOTES) ?>!" aria-hidden="true">
            <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="hari">00</span><span class="grd-countdown__label">Hari</span></div>
            <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="jam">00</span><span class="grd-countdown__label">Jam</span></div>
            <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="menit">00</span><span class="grd-countdown__label">Menit</span></div>
            <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="detik">00</span><span class="grd-countdown__label">Detik</span></div>
        </div>
    </div>
</section>
<?php endif ?>
