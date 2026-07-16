{{-- Garuda — Perkembangan Penduduk (mutasi) + Layanan Surat. Mandiri (Eloquent). --}}
@if (theme_config('layanan_surat', '1') == '1')
    @php
        $ok        = true;
        $bulan_ini = (int) date('m');
        $thn_ini   = (int) date('Y');
        $bln_lalu  = (int) date('m', strtotime('first day of last month'));
        $thn_lalu  = (int) date('Y', strtotime('first day of last month'));
        $perkembangan = ['bulan_ini' => [], 'bulan_lalu' => []];
        $surat = ['hari_ini' => 0, 'bulan_ini' => 0, 'tahun_ini' => 0, 'total' => 0];
        try {
            $LP = \App\Models\LogPenduduk::class;
            $hitung = static fn ($kode, $bln, $thn) => $LP::where('kode_peristiwa', $kode)->whereMonth('tgl_lapor', $bln)->whereYear('tgl_lapor', $thn)->count();
            foreach (['bulan_ini' => [$bulan_ini, $thn_ini], 'bulan_lalu' => [$bln_lalu, $thn_lalu]] as $key => $bt) {
                $perkembangan[$key] = [
                    'Kelahiran' => $hitung(1, $bt[0], $bt[1]),
                    'Kematian'  => $hitung(2, $bt[0], $bt[1]),
                    'Masuk'     => $hitung(5, $bt[0], $bt[1]),
                    'Pindah'    => $hitung(3, $bt[0], $bt[1]),
                ];
            }
            $LS = \App\Models\LogSurat::class;
            $surat['hari_ini']  = $LS::where('status', 1)->whereDate('tanggal', date('Y-m-d'))->count();
            $surat['bulan_ini'] = $LS::where('status', 1)->whereMonth('tanggal', $bulan_ini)->whereYear('tanggal', $thn_ini)->count();
            $surat['tahun_ini'] = $LS::where('status', 1)->whereYear('tanggal', $thn_ini)->count();
            $surat['total']     = $LS::where('status', 1)->count();

            // Sembunyikan seluruh seksi bila SEMUA angka 0 (belum ada data).
            $grand_total = array_sum($surat)
                + array_sum($perkembangan['bulan_ini'] ?? [])
                + array_sum($perkembangan['bulan_lalu'] ?? []);
            if ($grand_total <= 0) {
                $ok = false;
            }
        } catch (\Throwable $e) {
            $ok = false;
        }
    @endphp
    @if ($ok)
        <section class="grd-container grd-perkembangan" style="margin-top:var(--section-y,3rem);">
            <div class="grd-perkembangan__col">
                <span class="grd-section-eyebrow">Mutasi Penduduk</span>
                <h2 class="grd-section-title">Perkembangan Penduduk</h2>
                <div class="grd-perkembangan__periods">
                    @foreach (['bulan_ini' => 'Bulan Ini', 'bulan_lalu' => 'Bulan Lalu'] as $key => $judul)
                        <div class="grd-perkembangan__period">
                            <h4>{{ $judul }}</h4>
                            <div class="grd-perkembangan__tiles">
                                @php $ikon = ['Kelahiran' => 'fa-baby', 'Kematian' => 'fa-cross', 'Masuk' => 'fa-sign-in-alt', 'Pindah' => 'fa-sign-out-alt']; @endphp
                                @foreach ($perkembangan[$key] as $label => $jumlah)
                                    <div class="grd-mini-stat">
                                        <i class="fas {{ $ikon[$label] }}"></i>
                                        <span class="grd-mini-stat__num">{{ (int) $jumlah }}</span>
                                        <span class="grd-mini-stat__label">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="grd-perkembangan__col">
                <span class="grd-section-eyebrow">Pelayanan</span>
                <h2 class="grd-section-title">Layanan Surat</h2>
                <div class="grd-perkembangan__tiles grd-perkembangan__tiles--surat">
                    @foreach (['hari_ini' => 'Hari Ini', 'bulan_ini' => 'Bulan Ini', 'tahun_ini' => 'Tahun Ini', 'total' => 'Total'] as $key => $label)
                        <div class="grd-stat">
                            <i class="fas fa-file-alt grd-stat__icon"></i>
                            <span class="grd-stat__num">{{ (int) $surat[$key] }}</span>
                            <span class="grd-stat__label">{{ $label }} Surat</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif
