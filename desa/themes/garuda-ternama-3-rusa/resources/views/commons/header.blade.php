@php
    $bg_header = $latar_website;
@endphp

<div class="w-full">
    <header style="background-image: url({{ $bg_header }});" class="grd-topbg bg-center bg-cover bg-no-repeat relative text-white">
        <div class="grd-topbg__overlay"></div>

        @include('theme::commons.category_menu')

        <section class="relative z-10 text-center space-y-2 mt-3 px-3 lg:px-5 pb-6 lg:pb-10">
            <a href="{{ site_url('/') }}">
                <figure>
                    <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ ucfirst(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']) }}" class="h-16 lg:h-20 mx-auto pb-2">
                </figure>
                <span class="text-h2 block">{{ ucwords(setting('sebutan_desa')) . ' ' . ucwords($desa['nama_desa']) }}</span>
                <p>{{ ucfirst(setting('sebutan_kecamatan_singkat')) }}
                    {{ ucwords($desa['nama_kecamatan']) }},
                    {{ ucfirst(setting('sebutan_kabupaten_singkat')) }}
                    {{ ucwords($desa['nama_kabupaten']) }},
                    Provinsi
                    {{ ucwords($desa['nama_propinsi']) }}
                </p>
            </a>
        </section>
        @if ($teks_berjalan)
            <div class="block px-3 bg-black bg-opacity-25 py-1.5 text-xs mt-6 mb-0 z-20 relative">
                <marquee onmouseover="this.stop();" onmouseout="this.start();" class="block divide-x-4 relative">
                    @foreach ($teks_berjalan as $marquee)
                        <span class="px-3">
                            <i class="fas fa-bullhorn mr-1 text-amber-300"></i> {{ $marquee['teks'] }}
                            @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                                <a href="{{ $marquee['tautan'] }}" class="underline hover:text-amber-300">{{ $marquee['judul_tautan'] }}</a>
                            @endif
                        </span>
                    @endforeach
                </marquee>
            </div>
        @endif
    </header>
    @include('theme::commons.main_menu')
    @include('theme::commons.mobile_menu')
</div>
