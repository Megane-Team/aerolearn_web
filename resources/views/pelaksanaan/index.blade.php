@extends('layouts.lay')
@section('title')
    Data Pelaksanaan Pelatihan
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Pelaksanaan pelatihan</h5>
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
                                        <th>Pelatihan</th>
                                        <th>Instruktur</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Jenis</th>
                                        <th>Ruangan</th>
                                        <th>Selesai?</th>
                                        <th>Status</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $k => $v)
                                        <tr>
                                            <td>{{ $v->pelatihan->nama }}</td>
                                            <td>{{ $v->instruktur->email }}</td>
                                            <td>{{ $v->tanggal_mulai }}</td>
                                            <td>{{ $v->tanggal_selesai }}</td>
                                            <td>{{ $v->jam_mulai }}</td>
                                            <td>{{ $v->jam_selesai }}</td>
                                            <td>{{ $v->jenis_training }}</td>
                                            <td>{{ $v->ruangan->nama }}</td>
                                            <td>{{ $v->is_selesai }}</td>
                                            <td class="text-nowrap">
                                                <span
                                                    class="badge 
                                                    @if ($v->permintaantraining->status == 'menunggu' || $v->permintaantraining->status == 'instruktur menunggu') bg-warning
                                                    @elseif($v->permintaantraining->status == 'terima') bg-success
                                                    @elseif($v->permintaantraining->status == 'tolak' || $v->permintaantraining->status == 'instruktur menolak') bg-danger @endif">
                                                    {{ $v->permintaantraining->status }}
                                                </span>
                                                @if (Auth::user()->user_role == 'kepala pelatihan')
                                                    @if ($v->permintaantraining->status == 'menunggu')
                                                        <br>
                                                        <a href="{{ route('pelaksanaan.status', [$v->permintaantraining->id, 1]) }}"
                                                            class="btn btn-sm btn-success">terima</a>
                                                        <a href="{{ route('pelaksanaan.status', [$v->permintaantraining->id, 2]) }}"
                                                            class="btn btn-sm btn-danger">tolak</a>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->user_role == 'instruktur')
                                                    @if ($v->permintaantraining->status == 'instruktur menunggu')
                                                        <br>
                                                        <a href="{{ route('pelaksanaan.status', [$v->permintaantraining->id, 3]) }}"
                                                            class="btn btn-sm btn-success">terima</a>
                                                        <a href="{{ route('pelaksanaan.status', [$v->permintaantraining->id, 4]) }}"
                                                            class="btn btn-sm btn-danger">tolak</a>
                                                    @endif
                                                @endif
                                            </td>

                                            <td>
                                                @if (Auth::user()->user_role == 'admin')
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#edit-{{ $v->id }}">Edit</button>
                                                    <a href="{{ route('pelaksanaan.hapus', $v->id) }}"
                                                        class="btn btn-danger btn-sm">Hapus</a>
                                                    <a href="{{ route('pelaksanaan-alat.index', $v->id) }}"
                                                        class="btn btn-info btn-sm">Alat</a>
                                                @endif
                                                <a href="{{ route('pelaksanaan-peserta.index', $v->id) }}"
                                                    class="btn btn-primary btn-sm">peserta</a>
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
                    <form action="{{ route('pelaksanaan.tambah') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_pelatihan" class="form-label">ID Pelatihan</label>
                                <select class="form-select" id="id_pelatihan" name="id_pelatihan" required>
                                    <option disabled selected>Pilih Pelatihan</option>
                                    @foreach ($pelatihan as $k => $v)
                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>

                            <!-- ID Instruktur -->
                            <div class="mb-3">
                                <label for="id_instruktur" class="form-label">Instruktur</label>
                                <select class="form-select" id="id_instruktur" name="id_instruktur" required>
                                    <option disabled selected>Pilih Instruktur</option>
                                    @foreach ($instruktur as $k => $v)
                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>

                            <!-- Tanggal Selesai -->
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                            </div>

                            <!-- Jam Mulai -->
                            <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai">
                            </div>

                            <!-- Jam Selesai -->
                            <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai">
                            </div>

                            <!-- Jenis Training -->
                            <div class="mb-3">
                                <label for="jenis_training" class="form-label">Jenis Training</label>
                                <select class="form-select" id="jenis_training" name="jenis_training" required>
                                    <option disabled selected>Pilih Jenis</option>
                                    <option value="mandatory">mandatory</option>
                                    <option value="general knowledge">general knowledge</option>
                                    <option value="customer requested">Customer Request</option>
                                </select>
                            </div>

                            <!-- ID Ruangan -->
                            <div class="mb-3">
                                <label for="id_ruangan" class="form-label">Ruangan</label>
                                <select class="form-select" id="id_ruangan" name="id_ruangan" required>
                                    <option disabled selected>Pilih Ruangan</option>
                                    @foreach ($ruangan as $k => $v)
                                        <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Is Selesai -->
                            <div class="mb-3">
                                <label for="is_selesai" class="form-label">Status Selesai</label>
                                <select class="form-select" id="is_selesai" name="is_selesai" required>
                                    <option value="belum">Belum Selesai</option>
                                    <option value="selesai">Sudah Selesai</option>
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
        @foreach ($data as $ke => $va)
            <div class="modal fade" id="edit-{{ $va->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pelaksanaan.update', $va->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <!-- ID Pelatihan -->
                                <div class="mb-3">
                                    <label for="id_pelatihan" class="form-label">ID Pelatihan</label>
                                    <select class="form-select" id="id_pelatihan" name="id_pelatihan" required>
                                        <option disabled selected>Pilih Pelatihan</option>
                                        @foreach ($pelatihan as $k => $v)
                                            <option value="{{ $v->id }}"
                                                {{ $v->id == $va->id_pelatihan ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- ID Instruktur -->
                                <div class="mb-3">
                                    <label for="id_instruktur" class="form-label">Instruktur</label>
                                    <select class="form-select" id="id_instruktur" name="id_instruktur" required>
                                        <option disabled selected>Pilih Instruktur</option>
                                        @foreach ($instruktur as $k => $v)
                                            <option value="{{ $v->id }}"
                                                {{ $v->id == $va->id_instruktur ? 'selected' : '' }}>
                                                {{ $v->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                        value="{{ $va->tanggal_mulai }}">
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="mb-3">
                                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="tanggal_selesai"
                                        name="tanggal_selesai" value="{{ $va->tanggal_selesai }}">
                                </div>

                                <!-- Jam Mulai -->
                                <div class="mb-3">
                                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                        value="{{ $va->jam_mulai }}">
                                </div>

                                <!-- Jam Selesai -->
                                <div class="mb-3">
                                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                        value="{{ $va->jam_selesai }}">
                                </div>

                                <!-- Jenis Training -->
                                <div class="mb-3">
                                    <label for="jenis_training" class="form-label">Jenis Training</label>
                                    <select class="form-select" id="jenis_training" name="jenis_training" required>
                                        <option disabled selected>Pilih Jenis</option>
                                        <option value="mandatory"
                                            {{ $va->jenis_training == 'mandatory' ? 'selected' : '' }}>
                                            mandatory
                                        </option>
                                        <option value="general knowledge"
                                            {{ $va->jenis_training == 'general knowledge' ? 'selected' : '' }}>
                                            general knowledge
                                        </option>
                                        <option value="customer requested"
                                            {{ $va->jenis_training == 'customer requested' ? 'selected' : '' }}>
                                            Customer Request
                                        </option>
                                    </select>
                                </div>

                                <!-- ID Ruangan -->
                                <div class="mb-3">
                                    <label for="id_ruangan" class="form-label">Ruangan</label>
                                    <select class="form-select" id="id_ruangan" name="id_ruangan" required>
                                        <option disabled>Pilih Ruangan</option>
                                        @foreach ($ruangan as $k => $v)
                                            <option value="{{ $v->id }}"
                                                {{ $v->id == $va->id_ruangan ? 'selected' : '' }}>
                                                {{ $v->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Is Selesai -->
                                <div class="mb-3">
                                    <label for="is_selesai" class="form-label">Status Selesai</label>
                                    <select class="form-select" id="is_selesai" name="is_selesai" required>
                                        <option value="belum" {{ $va->is_selesai == 'belum' ? 'selected' : '' }}>Belum
                                            Selesai</option>
                                        <option value="selesai" {{ $va->is_selesai == 'selesai' ? 'selected' : '' }}>Sudah
                                            Selesai</option>
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
