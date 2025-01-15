@extends('layouts.lay')
@section('title')
    Data Pertanyaan
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Pertanyaan Exam {{ $data->judul }} - Pelatihan {{ $data->pelatihan->nama }} </h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                Tambah Data
                            </button>
                        </div>


                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>No</th>
                                        <th>Pertanyaan</th>
                                        <th>Opsi Jawaban</th>
                                        <th>Jawaban Benar</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->question as $k => $v)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $v->question }} <br>
                                                @if ($v->gambar)
                                                <img src="{{ asset($v->gambar) }}" width="160px" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($v->opsi_jawaban as $ke => $va)
                                                        <li>{{ $va->jawaban }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>{{ $v->jawaban_benar->text }}</td>
                                            <td>
                                                <a href="{{ route('question.hapus', $v->id) }}"
                                                    class="btn btn-danger btn-sm">Hapus</a>
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

    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('question.tambah') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control" id="" name="question" required>
                            
                            <input type="hidden" name="id_exam" value="{{ $data->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Gambar (opsional)</label>
                            <input type="file" class="form-control" id="" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Opsi Jawaban</label>
                            <div id="opsi-container">
                                <div class="input-group mb-3">
                                    <input type="text" name="opsi[]" class="form-control" placeholder="Opsi Jawaban">
                                    <button type="button" class="btn btn-danger btn-remove d-none">-</button>
                                </div>
                            </div>
                            <button type="button" id="tambah-opsi" class="btn btn-primary mt-2">Tambah Opsi</button>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jawaban Benar</label>
                            <select name="jawaban" id="jawaban-select" class="form-control" required>
                                <option value="">Pilih jawaban benar</option>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const opsiContainer = document.getElementById('opsi-container');
            const tambahOpsiButton = document.getElementById('tambah-opsi');
            const jawabanSelect = document.getElementById('jawaban-select');

            // Tambahkan opsi baru
            tambahOpsiButton.addEventListener('click', function() {
                const inputGroup = document.createElement('div');
                inputGroup.className = 'input-group mb-3';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'opsi[]';
                input.className = 'form-control';
                input.placeholder = 'Opsi Jawaban';

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-remove';
                removeButton.textContent = '-';

                // Hapus opsi
                removeButton.addEventListener('click', function() {
                    inputGroup.remove();
                    updateJawabanOptions();
                });

                // Update jawaban benar saat input berubah
                input.addEventListener('input', updateJawabanOptions);

                inputGroup.appendChild(input);
                inputGroup.appendChild(removeButton);
                opsiContainer.appendChild(inputGroup);

                updateJawabanOptions();
            });

            // Perbarui daftar pilihan jawaban benar
            function updateJawabanOptions() {
                // Simpan nilai saat ini
                const currentValue = jawabanSelect.value;

                // Hapus semua opsi
                while (jawabanSelect.firstChild) {
                    jawabanSelect.removeChild(jawabanSelect.firstChild);
                }

                // Tambahkan kembali placeholder
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = 'Pilih jawaban benar';
                jawabanSelect.appendChild(placeholderOption);

                // Tambahkan opsi baru berdasarkan input
                const inputs = opsiContainer.querySelectorAll('input[name="opsi[]"]');
                inputs.forEach((input) => {
                    if (input.value.trim() !== '') {
                        const option = document.createElement('option');
                        option.value = input.value.trim(); // Gunakan teks sebagai value
                        option.textContent = input.value.trim(); // Gunakan teks sebagai label
                        jawabanSelect.appendChild(option);
                    }
                });

                // Set kembali nilai jika valid
                if (currentValue) {
                    jawabanSelect.value = currentValue;
                }
            }
        });
    </script>
@endsection
