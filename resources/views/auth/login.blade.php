<?php 
    use Illuminate\Support\Fascades\Route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('niceAdmin') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ asset('niceAdmin') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('niceAdmin') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ asset('niceAdmin') }}/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('niceAdmin') }}/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main style="background: #00B98E">
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                        <p class="text-center small">Masukan Email dan Password</p>
                                    </div>

                                    <form class="row g-3 needs-validation" action="{{ route('login') }}"
                                        method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="email" class="form-control" id="email"
                                                    required>
                                                @error('password')
                                                    <div class="invalid-feedback">Please enter your email.</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            @error('password')
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-12">
                                            <a href="{{ route('register') }}">Tidak punya akun? daftar disini</a>
                                        </div> --}}

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <script src="{{ asset('niceAdmin') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/quill/quill.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('niceAdmin') }}/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('niceAdmin') }}/assets/js/main.js"></script>

</body>

</html>
Z
