@extends('layouts.lay')
@section('title')
    Data Alat
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Alat Pelatihan {{ $data->id }}</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                Edit Data
                            </button>
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Nama Alat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->tablealat as $k => $v)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $v->alat->nama }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pelaksanaan-alat.tambah') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Pilih alat</label>
                            <input type="hidden" value="{{ $data->id }}" name="id_pelaksanaan_pelatihan">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>checklist</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alat as $k => $v)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="id_alat[]" value="{{ $v->id }}"
                                                    id="" {{ $v->sudah_terdaftar ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $v->nama }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
@endsection
