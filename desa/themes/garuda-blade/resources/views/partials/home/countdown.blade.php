{{-- Garuda — Countdown hari besar nasional. Self-contained, gate theme_config('event_countdown'). --}}
@if (theme_config('event_countdown', '1') == '1')
    @php
        $ok      = true;
        $next    = null;
        $iso     = null;
        $tglNext = null;

        try {
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

            if ($nextTs === null) {
                $ok = false;
            } else {
                $iso     = date('Y-m-d\T00:00:00', $nextTs);
                $tglNext = date('Y-m-d', $nextTs);
            }
        } catch (\Throwable $e) {
            $ok = false;
        }
    @endphp
    @if ($ok && $next !== null)
        <section class="grd-countdown-band">
            <div class="grd-container grd-countdown-band__inner">
                <div class="grd-countdown-band__label">
                    <span class="grd-section-eyebrow">Menyambut</span>
                    <h3 class="grd-countdown-band__title">{{ $next }}</h3>
                    <p class="grd-countdown-band__date">{{ tgl_indo($tglNext) }}</p>
                </div>
                <div class="grd-countdown" data-grd-countdown="{{ $iso }}" data-grd-done="Selamat {{ $next }}!" aria-hidden="true">
                    <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="hari">00</span><span class="grd-countdown__label">Hari</span></div>
                    <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="jam">00</span><span class="grd-countdown__label">Jam</span></div>
                    <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="menit">00</span><span class="grd-countdown__label">Menit</span></div>
                    <div class="grd-countdown__tile"><span class="grd-countdown__num" data-cd="detik">00</span><span class="grd-countdown__label">Detik</span></div>
                </div>
            </div>
        </section>
        <script>
            (function () {
                function pad(n) { return (n < 10 ? '0' : '') + n; }
                function run() {
                    document.querySelectorAll('[data-grd-countdown]').forEach(function (el) {
                        var target = new Date(el.getAttribute('data-grd-countdown')).getTime();
                        if (isNaN(target)) return;
                        var f = {
                            hari:  el.querySelector('[data-cd="hari"]'),
                            jam:   el.querySelector('[data-cd="jam"]'),
                            menit: el.querySelector('[data-cd="menit"]'),
                            detik: el.querySelector('[data-cd="detik"]')
                        };
                        var timer;
                        function tick() {
                            var diff = target - Date.now();
                            if (diff <= 0) {
                                if (f.hari) f.hari.textContent = '00';
                                if (f.jam) f.jam.textContent = '00';
                                if (f.menit) f.menit.textContent = '00';
                                if (f.detik) f.detik.textContent = '00';
                                clearInterval(timer);
                                return;
                            }
                            var s = Math.floor(diff / 1000);
                            var d = Math.floor(s / 86400); s -= d * 86400;
                            var h = Math.floor(s / 3600);  s -= h * 3600;
                            var m = Math.floor(s / 60);    s -= m * 60;
                            if (f.hari) f.hari.textContent = pad(d);
                            if (f.jam) f.jam.textContent = pad(h);
                            if (f.menit) f.menit.textContent = pad(m);
                            if (f.detik) f.detik.textContent = pad(s);
                        }
                        tick();
                        timer = setInterval(tick, 1000);
                    });
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', run);
                } else {
                    run();
                }
            })();
        </script>
    @endif
@endif
