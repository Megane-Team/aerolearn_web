@extends('layouts.lay')
@section('title')
    Data Peaserta
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Peserta Pelaksanaan Pelatihan {{ $data->id }}</h5>
                            @if (Auth::user()->user_role == 'admin')
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambah">
                                        Edit Data
                                    </button>
                                    <!-- <a href="{{ route('pelaksanaan-peserta.generatesertif', $data->id) }}"
                                        class="btn btn-success btn-sm">generate all sertif</a> -->
                                </div>
                            @endif
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Nama Peserta</th>
                                        @foreach ($pelatihan->materi as $k => $v)
                                            <th>Absensi Materi {{ $v->judul }}</th>
                                        @endforeach
                                        @foreach ($pelatihan->exam as $k => $v)
                                            <th>Absensi Exam {{ $v->judul }}</th>
                                        @endforeach
                                        <th>Sertifikat</th>
                                        <th>Nilai</th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->tablepeserta as $k => $v)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $v->user->info->nama }}</td>
                                            @foreach ($pelatihan->materi as $key => $value)
                                                <td>
                                                    @if ($absensiM[$k][$key])
                                                        {{ $absensiM[$k][$key]->status_absen }}<br>
                                                        @if (Auth::user()->user_role == 'instruktur')
                                                            @if ($absensiM[$k][$key]->status_absen == 'Belum Validasi')
                                                                <a href="{{ route('pelaksanaan-peserta.validasi', $absensiM[$k][$key]->id) }}"
                                                                    class="btn btn-success btn-sm">Validasi</a>
                                                            @endif
                                                        @endif
                                                    @else
                                                        Belum Absen
                                                    @endif
                                                </td>
                                            @endforeach
                                            @foreach ($pelatihan->exam as $key => $value)
                                                <td>
                                                    @if ($absensiE[$k][$key])
                                                        {{ $absensiE[$k][$key]->status_absen }}<br>
                                                        @if (Auth::user()->user_role == 'instruktur')
                                                            @if ($absensiE[$k][$key]->status_absen == 'Belum Validasi')
                                                                <a href="{{ route('pelaksanaan-peserta.validasi', $absensiE[$k][$key]->id) }}"
                                                                    class="btn btn-success btn-sm">Validasi</a>
                                                            @endif
                                                        @endif
                                                    @else
                                                        Balum Absen
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                @if ($sertif[$k])
                                                    <a href="{{ route('pelaksanaan-peserta.sertif', $sertif[$k]->id) }}"
                                                        class="btn btn-primary btn-sm">Lihat Sertif</a>
                                                @else
                                                    Sertifikat belum di generate
                                                @endif
                                            </td>
                                            <td>
                                                @if ($nilai[$k])
                                                    {{ $nilai[$k]->score }}
                                                @else
                                                    belum terdapat nilai
                                                @endif
                                            </td>
                                            <td>
                                                @if ($feedback[$k])
                                                    {{ $feedback[$k]->feedbackquestion->text }}
                                                @else
                                                    belum terdapat feedback
                                                @endif
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pelaksanaan-peserta.tambah') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Pilih Peserta</label>
                                <input type="hidden" value="{{ $data->id }}" name="id_pelaksanaan_pelatihan">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>checklist</th>
                                            <th>Nama</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peserta as $k => $v)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="id_peserta[]" value="{{ $v->id }}"
                                                        id="" {{ $v->sudah_terdaftar ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $v->info->nama }}</td>
                                                <td>
                                                    @if ($v->id_karyawan)
                                                        internal
                                                    @else
                                                        Eksternal
                                                    @endif
                                                </td>
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
    @endif
@endsection
