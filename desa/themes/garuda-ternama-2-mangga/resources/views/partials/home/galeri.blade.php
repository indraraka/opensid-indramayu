@php defined('BASEPATH') || exit('No direct script access allowed'); @endphp

@php
    // Self-contained: ambil sendiri daftar album galeri lewat Eloquent.
    // Bungkus SEMUA akses data dalam try/catch — bila error / kosong, tidak merender apa pun
    // sehingga section ini tidak akan pernah merusak halaman beranda.
    $grdGaleriTampil  = false;
    $grdGaleriAlbums  = [];
    $grdGaleriUrlMore = '#';
    $grdSebutanDesa   = '';

    try {
        if (theme_config('galeri_strip', '1') == '1') {
            $grdGaleriAlbums = \App\Models\Galery::widget();

            // Hanya album yang berkas gambar kecilnya benar-benar ada.
            if ($grdGaleriAlbums && method_exists($grdGaleriAlbums, 'filter')) {
                $grdGaleriAlbums = $grdGaleriAlbums->filter(static function ($album) {
                    return ! empty($album->gambar) && is_file(LOKASI_GALERI . 'kecil_' . $album->gambar);
                });
            }

            $grdGaleriTampil = $grdGaleriAlbums && method_exists($grdGaleriAlbums, 'isNotEmpty')
                ? $grdGaleriAlbums->isNotEmpty()
                : ! empty($grdGaleriAlbums);

            if ($grdGaleriTampil) {
                $grdGaleriUrlMore = route('web.galeri.index');
                $grdSebutanDesa   = ucwords((string) setting('sebutan_desa'));
            }
        }
    } catch (\Throwable $e) {
        $grdGaleriTampil = false;
    }
@endphp

@if ($grdGaleriTampil)
<section class="grd-container grd-galeri" style="margin-top:var(--section-y,3rem);">
    <div class="grd-galeri__head">
        <div>
            <span class="grd-section-eyebrow">Dokumentasi</span>
            <h2 class="grd-section-title">Galeri {{ $grdSebutanDesa }}</h2>
        </div>
        <a href="{{ $grdGaleriUrlMore }}" class="grd-galeri__more">Semua Album <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="grd-galeri__strip">
        @foreach ($grdGaleriAlbums as $album)
            <a href="{{ route('web.galeri.detail', $album->id) }}" class="grd-galeri__item" title="{{ $album->nama }}">
                <img loading="lazy" src="{{ AmbilGaleri($album->gambar, 'kecil') }}" alt="{{ $album->nama }}">
                <span class="grd-galeri__caption">{{ $album->nama }}</span>
            </a>
        @endforeach
    </div>
</section>
@endif
