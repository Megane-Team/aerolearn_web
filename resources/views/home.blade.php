@extends('layouts.landing')

@section('content')
    <div class="row">
        <div class="col-lg-6 text-center text-lg-start">
            <h1 class="text-white mb-4 animated zoomIn">Tingkatkan Kemampuan Anda dengan Pelatihan Terbaik</h1>
            <p class="text-white pb-3 animated zoomIn">Temukan cara belajar yang cocok dengan kebutuhan Anda. Dengan mentor ahli, raih keterampilan baru kapan saja, di mana saja</p>
            <a href=""
                class="btn btn-outline-light rounded-pill border-2 py-3 px-5 animated slideInRight">
                Mulai Sekarang
            </a>
        </div>
        <div class="col-lg-6 text-center text-lg-start">
            <img class="img-fluid animated zoomIn" src="{{ asset('hero2.png') }}" alt="">
        </div>
    </div>
@endsection
