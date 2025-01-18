@extends('layouts.lay')
@section('title')
    Data Peserta
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Internal (karyawan)</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambah-internal">
                                Tambah Data
                            </button>
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable not">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Tempat Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Unit Org</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Email</th>
                                        <th>Notelp</th>
                                        <th>Posisi</th>
                                        <th>TMT</th>
                                        <th>JobCode</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['internal'] as $k => $v)
                                        <tr>
                                            <td>{{ $v->internal->nik }}</td>
                                            <td>{{ $v->internal->nama }}</td>
                                            <td>{{ $v->internal->tanggal_lahir }}</td>
                                            <td>{{ $v->internal->tempat_lahir }}</td>
                                            <td>{{ $v->internal->jenis_kelamin }}</td>
                                            <td>{{ $v->internal->unit_org }}</td>
                                            <td>{{ $v->internal->alamat }}</td>
                                            <td>{{ $v->internal->status }}</td>
                                            <td>{{ $v->internal->email }}</td>
                                            <td>{{ $v->internal->no_telp }}</td>
                                            <td>{{ $v->internal->posisi }}</td>
                                            <td>{{ $v->internal->tmt }}</td>
                                            <td>{{ $v->internal->jobcode }}</td>
                                            <td>

                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#sertif-internal-{{ $v->id }}">Sertif</button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#edit-internal-{{ $v->id }}">Edit</button>
                                                <a href="{{ route('peserta.hapus', [1, $v->id]) }}"
                                                    class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @php
                                $currentPage = request()->get('page', 1); // Halaman saat ini (default 1)
                                $previousPage = $currentPage > 1 ? $currentPage - 1 : null; // Previous page
                                $nextPage = $currentPage + 1; // Next page
                            @endphp

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{-- Previous Page --}}
                                    @if ($previousPage)
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ url()->current() }}?page={{ $previousPage }}">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                    @endif

                                    {{-- Current Page --}}
                                    <li class="page-item active">
                                        <span class="page-link">{{ $currentPage }}</span>
                                    </li>

                                    {{-- Next Page --}}
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ url()->current() }}?page={{ $nextPage }}">Next</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Eksternal</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambah-eksternal">
                                Tambah Data
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable not">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Tempat Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Notelp</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['eksternal'] as $k => $v)
                                        <tr>
                                            <td>{{ $v->eksternal->nama }}</td>
                                            <td>{{ $v->eksternal->tanggal_lahir }}</td>
                                            <td>{{ $v->eksternal->tempat_lahir }}</td>
                                            <td>{{ $v->eksternal->jenis_kelamin }}</td>
                                            <td>{{ $v->eksternal->alamat }}</td>
                                            <td>{{ $v->eksternal->email }}</td>
                                            <td>{{ $v->eksternal->no_telp }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#sertif-eksternal-{{ $v->id }}">Sertif</button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#edit-eksternal-{{ $v->id }}">Edit</button>
                                                <a href="{{ route('peserta.hapus', [2, $v->id]) }}"
                                                    class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @php
                                $currentPage = request()->get('page', 1); // Halaman saat ini (default 1)
                                $previousPage = $currentPage > 1 ? $currentPage - 1 : null; // Previous page
                                $nextPage = $currentPage + 1; // Next page
                            @endphp

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{-- Previous Page --}}
                                    @if ($previousPage)
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ url()->current() }}?page={{ $previousPage }}">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                    @endif

                                    {{-- Current Page --}}
                                    <li class="page-item active">
                                        <span class="page-link">{{ $currentPage }}</span>
                                    </li>

                                    {{-- Next Page --}}
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ url()->current() }}?page={{ $nextPage }}">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="tambah-internal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Internal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('peserta.tambah', 1) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="number" class="form-control" id="nik" name="nik" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="jenis_kelamin_l"
                                                name="jenis_kelamin" value="L" required>
                                            <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="jenis_kelamin_p"
                                                name="jenis_kelamin" value="P" required>
                                            <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="unit_org" class="form-label">Unit Organisasi</label>
                                    <input type="text" class="form-control" id="unit_org" name="unit_org" required>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status">
                                </div>
                                <div class="mb-3">
                                    <label for="posisi" class="form-label">Posisi</label>
                                    <input type="text" class="form-control" id="posisi" name="posisi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tmt" class="form-label">TMT</label>
                                    <input type="date" class="form-control" id="tmt" name="tmt">
                                </div>
                                <div class="mb-3">
                                    <label for="jobcode" class="form-label">Job Code</label>
                                    <input type="text" class="form-control" id="jobcode" name="jobcode">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
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
    <div class="modal fade" id="tambah-eksternal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Eksternal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('peserta.tambah', 2) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="jenis_kelamin_l"
                                                name="jenis_kelamin" value="L" required>
                                            <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="jenis_kelamin_p"
                                                name="jenis_kelamin" value="P" required>
                                            <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
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
    @foreach ($data['internal'] as $k => $v)
        <div class="modal fade" id="edit-internal-{{ $v->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Internal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('peserta.update', [1, $v->id]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="number" class="form-control" id="nik" name="nik"
                                            value="{{ old('nik', $v->internal->nik) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama', $v->internal->nama) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $v->internal->tanggal_lahir) }}"
                                            name="tanggal_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir"
                                            value="{{ old('tempat_lahir', $v->internal->tempat_lahir) }}"
                                            name="tempat_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_l"
                                                    name="jenis_kelamin" value="L"
                                                    {{ old('jenis_kelamin', $v->internal->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_p"
                                                    name="jenis_kelamin" value="P"
                                                    {{ old('jenis_kelamin', $v->internal->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit_org" class="form-label">Unit Organisasi</label>
                                        <input type="text" class="form-control" id="unit_org" name="unit_org"
                                            value="{{ old('unit_org', $v->internal->unit_org) }}" required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $v->internal->alamat) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status" name="status"
                                            value="{{ old('status', $v->internal->status) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="posisi" class="form-label">Posisi</label>
                                        <input type="text" class="form-control" id="posisi" name="posisi"
                                            value="{{ old('posisi', $v->internal->posisi) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $v->internal->email) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            value="{{ old('no_telp', $v->internal->no_telp) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tmt" class="form-label">TMT</label>
                                        <input type="date" class="form-control" id="tmt" name="tmt"
                                            value="{{ old('tmt', $v->internal->tmt) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jobcode" class="form-label">Job Code</label>
                                        <input type="text" class="form-control" id="jobcode" name="jobcode"
                                            value="{{ old('jobcode', $v->internal->jobcode) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password (opsional)</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
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

        <div class="modal fade" id="sertif-internal-{{ $v->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>sertifikasi</th>
                                    <th>masa berlaku</th>
                                    <th>lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($v->sertif as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->sertifikasi }}</td>
                                        <td>{{ $value->masa_berlaku }}</td>
                                        <td><a href="{{ route('pelaksanaan-peserta.sertif', $value->id) }}"
                                                class="btn btn-sm btn-primary">lihat</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($data['eksternal'] as $k => $v)
        <div class="modal fade" id="edit-eksternal-{{ $v->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Eksternal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('peserta.update', [2, $v->id]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama', $v->eksternal->nama) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $v->eksternal->tanggal_lahir) }}"
                                            name="tanggal_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir"
                                            value="{{ old('tempat_lahir', $v->eksternal->tempat_lahir) }}"
                                            name="tempat_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_l"
                                                    name="jenis_kelamin" value="L"
                                                    {{ old('jenis_kelamin', $v->eksternal->jenis_kelamin) == 'L' ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_p"
                                                    name="jenis_kelamin" value="P"
                                                    {{ old('jenis_kelamin', $v->eksternal->jenis_kelamin) == 'P' ? 'checked' : '' }}
                                                    required>
                                                <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $v->eksternal->alamat) }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $v->eksternal->email) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                                            value="{{ old('no_telp', $v->eksternal->no_telp) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password (opsional)</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
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
        <div class="modal fade" id="sertif-eksternal-{{ $v->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sertif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>sertifikasi</th>
                                    <th>masa berlaku</th>
                                    <th>lihat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($v->sertif as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->sertifikasi }}</td>
                                        <td>{{ $value->masa_berlaku }}</td>
                                        <td><a href="{{ route('pelaksanaan-peserta.sertif', $value->id) }}"
                                                class="btn btn-sm btn-primary">lihat</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
