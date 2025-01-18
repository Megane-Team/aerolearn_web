@extends('layouts.lay')
@section('title')
    Import
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-header">
                        <input class="form-control" type="file" id="excelFile" accept=".xlsx, .xls" />
                    </div>
                    <div class="card-body">
                        <form id="excelForm" action="/import" method="POST">
                            @csrf
                            <table class="tbl" id="excelTable">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>NAMA</th>
                                        <th>TGL LHR</th>
                                        <th>TMT</th>
                                        <th>TMPT LHR</th>
                                        <th>JK</th>
                                        <th>UO</th>
                                        <th>JOB CODE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('excelFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });

                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet, {
                    header: 1
                });

                const tableBody = document.querySelector('#excelTable tbody');
                tableBody.innerHTML = ''; // Kosongkan body tabel sebelumnya

                jsonData.slice(1).forEach((row, rowIndex) => {
                    const tableRow = document.createElement('tr');

                    row.forEach((cell, cellIndex) => {
                        const tableCell = document.createElement('td');
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.classList.add('form-control');

                        // Menangani kolom Tanggal Lahir (index 2) dan TMT (index 3)
                        if ((cellIndex === 2 || cellIndex === 3) && !isNaN(cell)) {
                            const date = XLSX.SSF.parse_date_code(cell); // Parsing tanggal
                            input.value =
                                `${date.y}-${String(date.m).padStart(2, '0')}-${String(date.d).padStart(2, '0')}`; // Format YYYY-MM-DD
                        } else {
                            input.value = cell ||
                            ''; // Isi sel dengan nilai atau kosongkan jika null
                        }

                        input.name =
                        `data[${rowIndex}][${cellIndex}]`; // Tentukan nama input sesuai baris dan kolom
                        tableCell.appendChild(input); // Menambahkan input ke dalam tabel cell
                        tableRow.appendChild(tableCell); // Menambahkan tabel cell ke baris
                    });

                    tableBody.appendChild(tableRow); // Menambahkan baris ke dalam tabel
                });

                // Menginisialisasi DataTable jika diperlukan
                if (typeof DataTable !== "undefined") {
                    let tbl = new DataTable('.tbl');
                }
            };

            reader.readAsArrayBuffer(file); // Membaca file Excel
        });

        document.getElementById('excelForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit default form

            // Nonaktifkan DataTable sementara untuk memastikan semua data terkirim
            if (typeof DataTable !== "undefined") {
                const dataTable = $('.tbl').DataTable();
                dataTable.destroy(); // Hentikan DataTable agar data bisa diambil dengan benar
            }

            const tableData = []; // Array untuk menampung data tabel
            const tableRows = document.querySelectorAll('#excelTable tbody tr');

            // Mengambil data dari setiap baris tabel
            tableRows.forEach((row) => {
                const rowData = [];
                const tableCells = row.querySelectorAll('td input');

                tableCells.forEach((cell) => {
                    rowData.push(cell.value); // Menambahkan nilai cell ke rowData
                });

                tableData.push(rowData); // Menambahkan rowData ke tableData
            });

            // Hapus semua input yang ada di tabel (menghindari input form lainnya terkirim)
            const tableInputs = document.querySelectorAll('#excelTable input');
            tableInputs.forEach(input => input.remove());

            // Menyimpan data dalam input tersembunyi sebagai JSON
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'json_data'; // Nama parameter yang akan dikirim ke server
            input.value = JSON.stringify(tableData); // Mengonversi tableData menjadi format JSON

            document.getElementById('excelForm').appendChild(input); // Menambahkan input tersembunyi ke form

            // Submit form setelah data disiapkan
            this.submit();
        });
    </script>
@endsection
