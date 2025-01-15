@extends('layouts.lay')
@section('title')
    Home
@endsection

@section('content')
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 h-100 ">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Peserta Internal</h5>
                        <p class="card-text fs-3 fw-bold">{{ $internal }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Peserta Eksternal</h5>
                        <p class="card-text fs-3 fw-bold">{{ $eksternal }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-pencil-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Pelatihan</h5>
                        <p class="card-text fs-3 fw-bold">{{ $pelatihan }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card 3 -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-pencil-fill" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">Pelaksanaan</h5>
                        <p class="card-text fs-3 fw-bold">{{ $pelatihan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
