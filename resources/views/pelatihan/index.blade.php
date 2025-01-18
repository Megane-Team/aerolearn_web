@extends('layouts.lay')
@section('title')
    Data Pelatihan
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Pelatihan</h5>
                            @if (Auth::user()->user_role == 'admin')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                    Tambah Data
                                </button>
                            @endif
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Koordinator</th>
                                        <th>Kategori</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $k => $v)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $v->nama }}</td>
                                            <td>{{ $v->deskripsi }}</td>
                                            <td>{{ $v->koordinator }}</td>
                                            <td>{{ $v->kategori }}</td>
                                            <td>
                                                @if (Auth::user()->user_role == 'admin')
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#edit-{{ $v->id }}">Edit</button>
                                                    <a href="{{ route('pelatihan.hapus', $v->id) }}"
                                                        class="btn btn-danger btn-sm">Hapus</a>
                                                    <a href="{{ route('exam.index', $v->id) }}"
                                                        class="btn btn-primary btn-sm">Exam</a>
                                                @endif
                                                <a href="{{ route('materi.index', $v->id) }}"
                                                    class="btn btn-info btn-sm">Materi</a>
                                            </td>
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

    @if (Auth::user()->user_role == 'admin')
        <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pelatihan.tambah') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Koordinator</label>
                                <input type="text" class="form-control" id="" name="koordinator" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">kategori</label>
                                <select name="kategori" class="form-control" id="" required>
                                    <option disabled selected>Pilih Katergori</option>
                                    <option value="softskill">SoftSkill</option>
                                    <option value="hardskill">HardSkill</option>
                                </select>
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
        @foreach ($data as $k => $v)
            <div class="modal fade" id="edit-{{ $v->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pelatihan.update', $v->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" value="{{ $v->nama }}"
                                        name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="" class="form-control" rows="3">{{ $v->deskripsi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Koordinator</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $v->koordinator }}" name="koordinator" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">kategori</label>
                                    <select name="kategori" class="form-control" id="" required>
                                        <option disabled selected>Pilih Katergori</option>
                                        <option value="softskill" {{ $v->kategori == 'softskill' ? 'selected' : '' }}>
                                            SoftSkill</option>
                                        <option value="hardskill" {{ $v->kategori == 'hardskill' ? 'selected' : '' }}>
                                            HardSkill</option>
                                    </select>
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
    @endif
@endsection
