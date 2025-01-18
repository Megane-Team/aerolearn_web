@extends('layouts.lay')
@section('title')
    Data Materi
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Materi Pelatihan {{ $data->nama }}</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                Tambah Data
                            </button>
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Konten</th>
                                        <th>Materi</th>
                                        @if (Auth::user()->user_role == 'admin')
                                            <th>#</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->materi as $k => $v)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $v->judul }}</td>
                                            <td>{{ $v->konten }}</td>
                                            <td><a href="{{ asset($v->link) }}" target="_blank"
                                                    class="btn btn-sm btn-primary">lihat</a></td>
                                            @if (Auth::user()->user_role == 'admin')
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#edit-{{ $v->id }}">Edit</button>
                                                    <a href="{{ route('materi.hapus', $v->id) }}"
                                                        class="btn btn-danger btn-sm">Hapus</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>

    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('materi.tambah') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="" name="judul" required>
                            <input type="hidden" name="id_pelatihan" value="{{ $data->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Konten</label>
                            <textarea name="konten" id="" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">materi file (opsional)</label>
                            <input type="file" class="form-control" id="" name="materi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($data->materi as $k => $v)
        <div class="modal fade" id="edit-{{ $v->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('materi.update', $v->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="" name="judul" required
                                    value="{{ $v->judul }}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Konten</label>
                                <textarea name="konten" id="" class="form-control" rows="5" required>{{ $v->konten }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">materi file (opsional)</label>
                                <input type="file" class="form-control" id="" name="materi">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
