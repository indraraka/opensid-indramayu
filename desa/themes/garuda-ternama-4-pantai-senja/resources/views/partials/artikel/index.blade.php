@php
    $is_beranda = empty($cari) && empty(request()->segment(1));
    $title = !empty($judul_kategori) ? (is_array($judul_kategori) ? ($judul_kategori['kategori'] ?? 'Artikel') : $judul_kategori) : 'Artikel Terkini';
@endphp
@extends($is_beranda ? 'theme::layouts.beranda' : 'theme::layouts.right-sidebar')

@section('content')
    @if ($is_beranda)
        {{-- ===== Beranda Garuda (lebar penuh, bersection) ===== --}}
        @include('theme::partials.home.countdown')
        @include('theme::partials.home.svg_hero')
        @if (theme_config('slider_beranda', '1') == '1' && count($slider_gambar['gambar'] ?? []) > 0)
            <div class="grd-container" style="margin-top:1.25rem;">@include('theme::partials.slider')</div>
        @endif
        @include('theme::partials.home.banner')
        @include('theme::partials.home.statistik')

        <section class="grd-container" style="margin-top:var(--section-y,3rem);">
            <div class="grd-section-bar">
                <div>
                    <span class="grd-section-eyebrow">Kabar Terbaru</span>
                    <h2 class="grd-section-title">{{ $title }}</h2>
                </div>
                <form action="{{ site_url() }}" role="search" class="grd-search">
                    <i class="fas fa-search"></i>
                    <input type="text" name="cari" value="{{ $cari ?? '' }}" placeholder="Cari artikel...">
                </form>
            </div>

            @if (theme_config('headline_beranda', '1') == '1' && !empty($headline))
                <div class="mb-6">@include('theme::partials.headline')</div>
            @endif
            @if ($artikel->count() > 0)
                <div class="grd-article-grid">
                    @foreach ($artikel as $post)
                        @php
                            $url   = $post->url_slug;
                            $image = $post['gambar'] && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar'])
                                ? AmbilFotoArtikel($post['gambar'], 'sedang')
                                : gambar_desa($desa['logo']);
                        @endphp
                        <article class="grd-article-card">
                            <a href="{{ $url }}" class="grd-article-card__media" tabindex="-1" aria-hidden="true">
                                <img loading="lazy" src="{{ $image }}" alt="{{ $post['judul'] }}">
                            </a>
                            <div class="grd-article-card__body">
                                <ul class="grd-article-card__meta">
                                    <li><i class="fas fa-calendar-alt"></i> {{ tgl_indo($post['tgl_upload']) }}</li>
                                    @if (!empty($post['kategori']))
                                        <li><i class="fas fa-bookmark"></i> {{ $post['category']['kategori'] ?? '' }}</li>
                                    @endif
                                </ul>
                                <h3 class="grd-article-card__title"><a href="{{ $url }}">{{ potong_teks($post['judul'], 75) }}</a></h3>
                                <p class="grd-article-card__excerpt">{{ potong_teks(strip_tags(html_entity_decode((string) $post['isi'])), 110) }}</p>
                                <a href="{{ $url }}" class="grd-article-card__more">Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="grd-pagination flex-wrap w-full mt-8 justify-center">
                    @include('theme::commons.paging', ['paging_page' => $paging_page ?? ''])
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6">@include('theme::partials.artikel.empty', ['title' => $title])</div>
            @endif
        </section>

        @include('theme::partials.home.aparatur')
        @include('theme::partials.home.layanan')
        @include('theme::partials.home.statistik_layanan')
        @include('theme::partials.home.galeri')
        <div style="height:var(--section-y,3rem)"></div>
    @else
        {{-- ===== Kategori / pencarian: daftar + sidebar ===== --}}
        <div class="flex justify-between items-center w-full">
            <h3 class="text-h4 text-primary-200">{{ $title }}</h3>
            <a href="{{ site_url('arsip') }}" class="text-sm hover:text-primary-100">Indeks <i class="fas fa-chevron-right ml-1"></i></a>
        </div>
        @if ($artikel->count() > 0)
            @foreach ($artikel as $post)
                @include('theme::partials.artikel.list', ['post' => $post])
            @endforeach
            <div class="pagination space-y-1 flex-wrap w-full">
                @include('theme::commons.paging', ['paging_page' => $paging_page ?? ''])
            </div>
        @else
            @include('theme::partials.artikel.empty', ['title' => $title])
        @endif
    @endif
@endsection
