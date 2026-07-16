{{-- Garuda — Statistik Desa (kependudukan). Mandiri (Eloquent), self-contained. --}}
@if (theme_config('statistik_beranda', '1') == '1')
    @php
        $ok      = true;
        $total   = null;
        $rincian = [];

        try {
            // Penduduk hidup (status_dasar = 1); sex: 1 = laki-laki, 2 = perempuan
            $laki      = (int) \App\Models\Penduduk::where('status_dasar', 1)->where('sex', 1)->count();
            $perempuan = (int) \App\Models\Penduduk::where('status_dasar', 1)->where('sex', 2)->count();
            $kk        = (int) \App\Models\Keluarga::aktif()->count();
            $total     = $laki + $perempuan;

            // Bentuk lama: array baris {nama, jumlah}, baris "JUMLAH" = total
            $rincian = [
                ['nama' => 'Laki-laki',       'jumlah' => $laki],
                ['nama' => 'Perempuan',       'jumlah' => $perempuan],
                ['nama' => 'Kepala Keluarga', 'jumlah' => $kk],
            ];

            if ($total <= 0) {
                $ok = false;
            }
        } catch (\Throwable $e) {
            $ok = false;
        }

        $ikon_rincian = ['fa-male', 'fa-female', 'fa-house', 'fa-users', 'fa-user'];
        $links = [
            ['url' => site_url('data-wilayah'),                       'icon' => 'fa-map-marker-alt',  'label' => 'Data Wilayah'],
            ['url' => site_url('data-statistik/pendidikan-dalam-kk'), 'icon' => 'fa-graduation-cap',  'label' => 'Data Pendidikan'],
            ['url' => site_url('data-statistik/pekerjaan'),           'icon' => 'fa-briefcase',       'label' => 'Data Pekerjaan'],
            ['url' => site_url('data-statistik/rentang-umur'),        'icon' => 'fa-users',           'label' => 'Data Usia'],
        ];
    @endphp
    @if ($ok && ! empty($rincian))
        <section class="grd-container" style="margin-top:var(--section-y,3rem);">
            <div class="grd-statistik">
                <div class="grd-statistik__total">
                    <i class="fas fa-users grd-statistik__total-icon"></i>
                    <span class="grd-statistik__total-num">{{ $total !== null ? ribuan((int) $total) : '-' }}</span>
                    <span class="grd-statistik__total-label">Total Penduduk</span>
                </div>
                <div class="grd-statistik__main">
                    <div class="grd-statistik__bar">
                        <div>
                            <span class="grd-section-eyebrow">Data Kependudukan</span>
                            <h2 class="grd-section-title">Statistik {{ ucwords((string) setting('sebutan_desa')) }}</h2>
                        </div>
                    </div>
                    <div class="grd-statistik__tiles">
                        @foreach (array_slice($rincian, 0, 4) as $i => $row)
                            <div class="grd-stat">
                                <i class="fas {{ $ikon_rincian[$i] ?? 'fa-user' }} grd-stat__icon"></i>
                                <span class="grd-stat__num">{{ ribuan((int) $row['jumlah']) }}</span>
                                <span class="grd-stat__label">{{ ucwords(strtolower($row['nama'])) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="grd-statistik__links">
                        @foreach ($links as $l)
                            <a href="{{ $l['url'] }}" class="grd-statistik__link">
                                <span class="grd-statistik__link-icon"><i class="fas {{ $l['icon'] }}"></i></span>
                                <span>{{ $l['label'] }}</span>
                                <i class="fas fa-chevron-right grd-statistik__link-arrow"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
