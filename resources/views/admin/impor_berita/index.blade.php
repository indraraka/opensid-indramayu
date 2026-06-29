@extends('admin.layouts.index')

@section('title')
    <h1>Impor Berita</h1>
@endsection

@section('breadcrumb')
    <li><a href="{{ ci_route('web', -1) }}">Artikel</a></li>
    <li class="active">Impor Berita</li>
@endsection

@section('content')
    @include('admin.layouts.components.notifikasi')

    <div class="row">
        {{-- ============================ PENGATURAN ============================ --}}
        <div class="col-md-5">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-cogs"></i> Pengaturan Impor</h3>
                </div>
                {!! form_open(ci_route('impor_berita.konfigurasi'), 'class="form-horizontal"') !!}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Impor Otomatis (Cron)</label>
                        <div class="col-sm-7">
                            <select name="berita_import_aktif" class="form-control input-sm">
                                <option value="1" @selected(setting('berita_import_aktif') == 1)>Aktif</option>
                                <option value="0" @selected(setting('berita_import_aktif') != 1)>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">URL Situs Sumber</label>
                        <div class="col-sm-7">
                            <input type="url" name="berita_import_url" class="form-control input-sm" placeholder="https://indramayukab.go.id" value="{{ setting('berita_import_url') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Metode</label>
                        <div class="col-sm-7">
                            <select name="berita_import_metode" class="form-control input-sm">
                                <option value="auto" @selected(setting('berita_import_metode') == 'auto')>Otomatis (REST + RSS)</option>
                                <option value="wp-rest" @selected(setting('berita_import_metode') == 'wp-rest')>WP REST API</option>
                                <option value="rss" @selected(setting('berita_import_metode') == 'rss')>RSS Feed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Kategori Tujuan</label>
                        <div class="col-sm-7">
                            <select name="berita_import_kategori" class="form-control input-sm">
                                <option value="">[Tanpa Kategori]</option>
                                @foreach ($list_kategori as $kat)
                                    <option value="{{ $kat->id }}" @selected((string) setting('berita_import_kategori') === (string) $kat->id)>{{ $kat->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Penulis</label>
                        <div class="col-sm-7">
                            <select name="berita_import_id_user" class="form-control input-sm">
                                <option value="">[Admin Utama]</option>
                                @foreach ($list_user as $u)
                                    <option value="{{ $u->id }}" @selected((string) setting('berita_import_id_user') === (string) $u->id)>{{ $u->nama ?? ('User #' . $u->id) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Batas per Hari</label>
                        <div class="col-sm-7">
                            <input type="number" min="1" max="50" name="berita_import_limit" class="form-control input-sm" value="{{ setting('berita_import_limit') }}">
                            <span class="help-block" style="margin-bottom:0">Mis. <b>1</b> = hanya 1 berita per hari.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Status Terbit</label>
                        <div class="col-sm-7">
                            <select name="berita_import_status" class="form-control input-sm">
                                <option value="1" @selected(setting('berita_import_status') == 1)>Langsung Tayang</option>
                                <option value="0" @selected(setting('berita_import_status') != 1)>Nonaktif (tinjau dulu)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Jumlah Pratinjau</label>
                        <div class="col-sm-7">
                            <input type="number" min="1" max="50" name="berita_import_jumlah_ambil" class="form-control input-sm" value="{{ setting('berita_import_jumlah_ambil') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Atribusi Sumber</label>
                        <div class="col-sm-7">
                            <select name="berita_import_atribusi" class="form-control input-sm">
                                <option value="1" @selected(setting('berita_import_atribusi') == 1)>Tambahkan tautan sumber</option>
                                <option value="0" @selected(setting('berita_import_atribusi') != 1)>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">User-Agent</label>
                        <div class="col-sm-7">
                            <input type="text" name="berita_import_user_agent" class="form-control input-sm" value="{{ setting('berita_import_user_agent') }}">
                            <span class="help-block" style="margin-bottom:0">Dipakai agar tidak diblokir WAF situs sumber.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Bypass Cloudflare</label>
                        <div class="col-sm-7">
                            <select name="berita_import_proxy" class="form-control input-sm">
                                <option value="none" @selected(setting('berita_import_proxy') == 'none' || !setting('berita_import_proxy'))>Tidak (langsung)</option>
                                <option value="template" @selected(setting('berita_import_proxy') == 'template')>Render API (URL template {url})</option>
                                <option value="flaresolverr" @selected(setting('berita_import_proxy') == 'flaresolverr')>FlareSolverr</option>
                            </select>
                            <span class="help-block" style="margin-bottom:0">Untuk situs di balik Cloudflare (mis. indramayukab.go.id) agar bisa ambil isi penuh + gambar.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">URL Proxy / Endpoint</label>
                        <div class="col-sm-7">
                            <input type="text" name="berita_import_proxy_url" class="form-control input-sm" placeholder="https://api.scraperapi.com/?api_key=XXX&url={url}" value="{{ setting('berita_import_proxy_url') }}">
                            <span class="help-block" style="margin-bottom:0"><b>Render API:</b> URL berisi <code>{url}</code>. <b>FlareSolverr:</b> endpoint server, mis. <code>http://127.0.0.1:8191</code>.</span>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    @if (can('u'))
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan Pengaturan</button>
                    @endif
                </div>
                {!! form_close() !!}
            </div>
        </div>

        {{-- ======================= DAFTAR BERITA SUMBER ====================== --}}
        <div class="col-md-7">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Berita di Situs Sumber</h3>
                    <div class="box-tools">
                        <button type="button" id="btn-muat" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Muat Daftar</button>
                        @if (can('u'))
                            <button type="button" id="btn-impor-sekarang" class="btn btn-primary btn-sm" title="Impor sesuai batas harian"><i class="fa fa-download"></i> Impor Sekarang</button>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div id="info-daftar" class="callout callout-info" style="margin-bottom:10px">
                        Klik <b>Muat Daftar</b> untuk menarik berita terbaru dari situs sumber, lalu impor per item dengan tombol <b>Impor</b>.
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tabel-sumber" style="display:none">
                            <thead>
                                <tr>
                                    <th>JUDUL</th>
                                    <th class="padat" nowrap>TANGGAL</th>
                                    <th class="padat text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================== RIWAYAT ============================== --}}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Impor (50 terakhir)</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="padat" nowrap>WAKTU</th>
                                <th>JUDUL</th>
                                <th class="padat">STATUS</th>
                                <th>KETERANGAN</th>
                                <th class="padat text-center">ARTIKEL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $r)
                                <tr>
                                    <td nowrap>{{ $r->created_at }}</td>
                                    <td>{{ $r->judul }}</td>
                                    <td>
                                        @if ($r->status === 'sukses')
                                            <span class="label label-success">sukses</span>
                                        @else
                                            <span class="label label-danger">gagal</span>
                                        @endif
                                    </td>
                                    <td>{{ $r->keterangan }}</td>
                                    <td class="text-center">
                                        @if ($r->id_artikel)
                                            <a href="{{ site_url('artikel/' . $r->id_artikel) }}" target="_blank" title="Lihat artikel">#{{ $r->id_artikel }}</a>
                                        @else
                                            &mdash;
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada riwayat impor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const urlDaftar = "{{ ci_route('impor_berita.daftar') }}";
        const urlImpor = "{{ ci_route('impor_berita.impor') }}";

        function badgeSudah() {
            return '<span class="label label-success"><i class="fa fa-check"></i> Sudah diimpor</span>';
        }

        function tombolImpor(id) {
            return $('<button>')
                .addClass('btn btn-success btn-xs btn-impor')
                .attr('data-id', id)
                .html('<i class="fa fa-download"></i> Impor');
        }

        function renderDaftar(data) {
            const $tbody = $('#tabel-sumber tbody').empty();
            if (!data || data.length === 0) {
                $('#info-daftar').removeClass('callout-info callout-success').addClass('callout-warning')
                    .text('Tidak ada berita yang dapat diambil. Periksa URL/metode sumber.');
                $('#tabel-sumber').hide();
                return;
            }
            data.forEach(function(item) {
                const $tr = $('<tr>');
                const $judul = $('<td>');
                $('<a>').attr({ href: item.link, target: '_blank' }).text(item.judul || '(tanpa judul)').appendTo($judul);
                $tr.append($judul);
                $tr.append($('<td nowrap>').text(item.tgl || ''));
                const $aksi = $('<td class="text-center">');
                if (item.diimpor) {
                    $aksi.html(badgeSudah());
                } else {
                    $aksi.append(tombolImpor(item.sumber_id));
                }
                $tr.append($aksi);
                $tbody.append($tr);
            });
            $('#info-daftar').removeClass('callout-warning callout-success').addClass('callout-info')
                .html('Menampilkan <b>' + data.length + '</b> berita terbaru dari situs sumber.');
            $('#tabel-sumber').show();
        }

        function muatDaftar() {
            const $btn = $('#btn-muat').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memuat...');
            $.getJSON(urlDaftar)
                .done(function(res) {
                    if (res.status === 'ok') {
                        renderDaftar(res.data);
                    } else {
                        $('#info-daftar').removeClass('callout-info').addClass('callout-danger').text(res.pesan || 'Gagal mengambil data.');
                    }
                })
                .fail(function() {
                    $('#info-daftar').removeClass('callout-info').addClass('callout-danger').text('Gagal menghubungi server.');
                })
                .always(function() {
                    $btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Muat Daftar');
                });
        }

        $(document).ready(function() {
            $('#btn-muat').on('click', muatDaftar);

            // Impor satu item
            $('#tabel-sumber').on('click', '.btn-impor', function() {
                const $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                const id = $btn.data('id');
                $.post(urlImpor, { sumber_id: id }, null, 'json')
                    .done(function(res) {
                        if (res.status === 'sukses') {
                            $btn.closest('td').html(badgeSudah());
                        } else {
                            $btn.prop('disabled', false).html('<i class="fa fa-download"></i> Impor');
                            alert(res.pesan || 'Gagal mengimpor.');
                        }
                    })
                    .fail(function() {
                        $btn.prop('disabled', false).html('<i class="fa fa-download"></i> Impor');
                        alert('Gagal menghubungi server.');
                    });
            });

            // Impor Sekarang (batch, sesuai batas harian)
            $('#btn-impor-sekarang').on('click', function() {
                const $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengimpor...');
                $.post(urlImpor, {}, null, 'json')
                    .done(function(res) {
                        alert(res.pesan || 'Selesai.');
                        location.reload();
                    })
                    .fail(function() {
                        alert('Gagal menghubungi server.');
                        $btn.prop('disabled', false).html('<i class="fa fa-download"></i> Impor Sekarang');
                    });
            });
        });
    </script>
@endpush
