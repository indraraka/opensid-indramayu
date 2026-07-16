{{-- Garuda — layout beranda lebar penuh (tanpa sidebar, tanpa kartu pembungkus).
     Tiap section memakai .grd-container untuk menengahkan kontennya sendiri. --}}
@extends('theme::template')

@section('layout')
    @yield('content')
@endsection
