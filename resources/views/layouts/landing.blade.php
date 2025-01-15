<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>AeroLearn</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing') }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing') }}/css/style.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container-xxl p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.html" class="navbar-brand p-0">
                    <h1 class="m-0">AeroLearn</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('index') }}"
                            class="nav-item nav-link {{ Request::is('index') ? 'active' : '' }}">Home</a>
                        <a href="" class="nav-item nav-link">Paket Pelatihan</a>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-light rounded-pill text-primary py-2 px-4 ms-lg-5">Login</a>
                </div>
            </nav>

            <div class="container-xxl bg-primary hero-header">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s"
            style="margin-top: 6rem;">
            <div class="container">
                <div class="copyright">
                    <div class="row d-flex justify-content-center">
                        <div class="text-center mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">AeroLearn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing') }}/lib/wow/wow.min.js"></script>
    <script src="{{ asset('landing') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('landing') }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('landing') }}/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing') }}/js/main.js"></script>
    @yield('script')
</body>

</html>
