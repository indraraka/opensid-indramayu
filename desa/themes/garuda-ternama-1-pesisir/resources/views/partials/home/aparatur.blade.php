{{-- Garuda — Pemerintah Desa (Struktur Organisasi / Aparatur) --}}
@php
    // Self-contained: ambil daftar perangkat langsung dari model (cara esensi/natra),
    // bukan dari variabel controller. Bungkus dalam try/catch agar tidak pernah
    // merusak halaman beranda — bila error / kosong, render kosong.
    $perangkat = [];

    try {
        if (theme_config('aparatur_beranda', '1') == '1') {
            $perangkat = \App\Models\Pamong::listAparaturDesa()['daftar_perangkat'] ?? [];
        }
    } catch (\Throwable $e) {
        $perangkat = [];
    }

    $placeholder = base_url('desa/themes/garuda/assets/images/foto-tidak-tersedia.png');
@endphp

@if (! empty($perangkat))
<section class="grd-container" style="margin-top:var(--section-y,3rem);">
    <div class="grd-section-bar">
        <div>
            <span class="grd-section-eyebrow">Struktur Organisasi</span>
            <h2 class="grd-section-title">Pemerintah {{ ucwords((string) setting('sebutan_desa')) }}</h2>
        </div>
        <a href="{{ site_url('pemerintah') }}" class="grd-section-link">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="grd-aparatur-grid">
        @foreach (array_slice($perangkat, 0, 10) as $i => $data)
        <div class="grd-official {{ $i === 0 ? 'grd-official--kepala' : '' }}">
            <div class="grd-official__media">
                <img loading="lazy" src="{{ $data['foto'] ?: $placeholder }}" alt="{{ $data['nama'] }}" onerror="this.src='{{ $placeholder }}'">
                @if ($i === 0)<span class="grd-official__crown"><i class="fas fa-star"></i></span>@endif
            </div>
            <div class="grd-official__body">
                <h4>{{ $data['nama'] }}</h4>
                <p>{{ $data['jabatan'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
