@php
    // 3-column footer band — self-contained port of the old garuda PHP partial.
    // All data access is wrapped so the section renders NOTHING on any error.
    $grd_render = false;
    $grd        = [];

    try {
        $grd['lat'] = $desa['lat'] ?? null;
        $grd['lng'] = $desa['lng'] ?? null;
        $grd_ada_peta = ! empty($grd['lat']) && ! empty($grd['lng']);

        if (theme_config('footer_peta', '1') == '1' && $grd_ada_peta) {
            $grd['sebutan']       = ucwords((string) setting('sebutan_desa'));
            $grd['logo']          = gambar_desa($desa['logo'] ?? null);
            $grd['nama_desa']     = (string) ($desa['nama_desa'] ?? identitas('nama_desa'));
            $grd['alamat_kantor'] = (string) ($desa['alamat_kantor'] ?? '');
            $grd['kecamatan']     = ucfirst((string) setting('sebutan_kecamatan_singkat')) . ' ' . ucwords((string) ($desa['nama_kecamatan'] ?? ''));
            $grd['kabupaten']     = ucfirst((string) setting('sebutan_kabupaten_singkat')) . ' ' . ucwords((string) ($desa['nama_kabupaten'] ?? ''));
            $grd['provinsi']      = ucwords((string) ($desa['nama_propinsi'] ?? ''));
            $grd['telepon']       = (string) ($desa['telepon'] ?? '');
            $grd['operator']      = (string) ($desa['nomor_operator'] ?? '');
            $grd['email']         = (string) ($desa['email_desa'] ?? '');

            $grd_sm_icon = [
                'facebook'  => 'fa-facebook-f',
                'twitter'   => 'fa-twitter',
                'instagram' => 'fa-instagram',
                'telegram'  => 'fa-telegram',
                'whatsapp'  => 'fa-whatsapp',
                'youtube'   => 'fa-youtube',
                'tiktok'    => 'fa-tiktok',
            ];

            $grd['social'] = [];
            foreach (($sosmed ?? []) as $sm) {
                $nm = strtolower($sm['nama'] ?? '');
                if (! empty($sm['link']) && isset($grd_sm_icon[$nm])) {
                    $grd['social'][] = [
                        'link' => $sm['link'],
                        'nama' => $sm['nama'] ?? '',
                        'icon' => $grd_sm_icon[$nm],
                    ];
                }
            }

            $grd_render = true;
        }
    } catch (\Throwable $e) {
        $grd_render = false;
    }
@endphp
@if ($grd_render)
<section class="grd-footer-info">
  <div class="grd-container grd-footer-info__grid">
    <div class="grd-footer-info__col">
      @include('theme::widgets.peta_lokasi_kantor', ['judul_widget' => 'Lokasi Kantor ' . $grd['sebutan'], 'map_id' => 'grd_map_kantor'])
    </div>
    <div class="grd-footer-info__identity">
      <img src="{{ $grd['logo'] }}" class="grd-footer-info__logo" alt="Logo">
      <h3 class="grd-footer-info__name">PEMERINTAH {{ strtoupper($grd['sebutan']) }} {{ strtoupper($grd['nama_desa']) }}</h3>
      <p class="grd-footer-info__addr">
        @if (! empty($grd['alamat_kantor'])){{ $grd['alamat_kantor'] }}<br>@endif
        {{ $grd['kecamatan'] }}, {{ $grd['kabupaten'] }}<br>
        Provinsi {{ $grd['provinsi'] }}
      </p>
      <ul class="grd-footer-info__contact">
        @if (! empty($grd['telepon']))<li><i class="fas fa-phone-alt"></i> {{ $grd['telepon'] }}</li>@endif
        @if (! empty($grd['operator']))<li><i class="fas fa-mobile-alt"></i> {{ $grd['operator'] }}</li>@endif
        @if (! empty($grd['email']))<li><i class="fas fa-envelope"></i> {{ strtolower($grd['email']) }}</li>@endif
      </ul>
      <ul class="grd-footer-info__social">
        @foreach ($grd['social'] as $sm)
          <li><a href="{{ $sm['link'] }}" target="_blank" rel="noopener" aria-label="{{ $sm['nama'] }}"><i class="fab {{ $sm['icon'] }}"></i></a></li>
        @endforeach
      </ul>
    </div>
    <div class="grd-footer-info__col">
      @include('theme::widgets.peta_wilayah_desa', ['judul_widget' => 'Wilayah ' . $grd['sebutan'], 'map_id' => 'grd_map_wilayah'])
    </div>
  </div>
</section>
@endif
