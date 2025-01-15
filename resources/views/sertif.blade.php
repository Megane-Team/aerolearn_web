<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @page {
            size: 1654px 2339px;
            /* Ukuran kertas A4 potret */
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            width: 1654px;
            /* Ukuran template PNG */
            height: 2339px;
            font-family: 'Arial', sans-serif;
            background-image: url('{{ public_path('sertif/kosong.png') }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            position: relative;
        }

        .content {
            position: absolute;
            text-align: center;
            width: 100%;
            top: 900px;
        }
        .content1 {
            position: absolute;
            text-align: center;
            width: 100%;
            top: 700px;
        }
        .content2 {
            position: absolute;
            text-align: center;
            width: 100%;
            top: 1100px;
        }
        .content3 {
            position: absolute;
            text-align: center;
            width: 100%;
            top: 1200px;
        }
        .content4 {
            position: absolute;
            text-align: center;
            width: 100%;
            top: 1400px;
        }
        .name {
            font-size: 60px;
            /* Sesuaikan ukuran teks */
            font-weight: bold;
            color: #333;
        }
        .pelatihan {
            font-size: 54px;
            /* Sesuaikan ukuran teks */
            font-weight: bold;
            color: #333;
        }
        .exp {
            font-size: 38px;
            /* Sesuaikan ukuran teks */
            font-weight: bold;
            color: rgb(85, 85, 85);
        }

        .title {
            font-size: 40px;
            margin-top: 10px;
            color: #555;
        }

        .signature {
            position: absolute;
            bottom: 300px;
            left: 150px;
            text-align: center;
        }
        .barcode {
            position: absolute;
            bottom: 360px;
            right: 240px;
            text-align: center;
        }

        .validity {
            position: absolute;
            bottom: 50px;
            left: 150px;
            font-size: 16px;
            color: #555;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

</head>

<body>
    <div class="content1">
        <div class="title">This is sertify that</div>
    </div>
    <div class="content">
        <div class="name">{{ $name }}</div>
    </div>
    <div class="content2">
        <div class="title">Has Completed the training of</div>
    </div>
    <div class="content3">
        <div class="pelatihan">{{ $judul }}</div>
    </div>
    <div class="content4">
        <div class="exp">valid until {{ date('d F Y') }}</div>
    </div>
    <div class="signature">
        <img src="{{ public_path('sertif/ttd2.png') }}" alt="Signature" width="480">
    </div>
    <div class="barcode">
        {{-- <img src="{{ public_path('sertif/barcodeyeni.jpg') }}" alt="Signature" width="380"> --}}
        <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
    </div>
</body>

</html>
