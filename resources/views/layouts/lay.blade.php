<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('image-removebg-preview.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ asset('NiceAdmin') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <link href="{{ asset('NiceAdmin') }}/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('image-removebg-preview.png') }}" alt="">
                <span class="d-none d-lg-block">AeroLearn</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar --> --}}

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                {{-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon--> --}}
                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="">


                        @foreach (Auth::user()->notif as $k => $v)
                            <li class="notification-item" style="width: 400px">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>{{ $v->title }}</h4>
                                    <p>{{ $v->detail }}</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endforeach


                    </ul><!-- End Notification Dropdown Items -->

                </li>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->user_role }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            @if (Auth::user()->user_role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('peserta.index') ? '' : 'collapsed' }}"
                        href="{{ route('peserta.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Peserta</span>
                    </a>
                </li><!-- End Dashboard Nav -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('user.index') ? '' : 'collapsed' }}"
                        href="{{ route('user.index') }}">
                        <i class="bi bi-people"></i>
                        <span>User</span>
                    </a>
                </li><!-- End Dashboard Nav -->
            @endif


            @if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'instruktur')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('pelatihan.index') || Request::routeIs('materi.index') || Request::routeIs('exam.index') ? '' : 'collapsed' }}"
                        href="{{ route('pelatihan.index') }}">
                        <i class="bi bi-pencil"></i>
                        <span>Pelatihan</span>
                    </a>
                </li><!-- End Dashboard Nav -->
            @endif

            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('pelaksanaan.index') || Request::routeIs('pelaksanaan-peserta.index') || Request::routeIs('pelaksanaan-alat.index') ? '' : 'collapsed' }}"
                    href="{{ route('pelaksanaan.index') }}">
                    <i class="bi bi-pencil"></i>
                    <span>Pelaksanaan</span>
                </a>
            </li>
            @if (Auth::user()->user_role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('alat.index') ? '' : 'collapsed' }}"
                        href="{{ route('alat.index') }}">
                        <i class="bi bi-gear"></i>
                        <span>Data Alat</span>
                    </a>
                </li><!-- End Dashboard Nav -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('ruangan.index') ? '' : 'collapsed' }}"
                        href="{{ route('ruangan.index') }}">
                        <i class="bi bi-house"></i>
                        <span>Data Ruangan</span>
                    </a>
                </li><!-- End Dashboard Nav -->
            @endif

            @if (Auth::user()->user_role == 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('feedback.index') ? '' : 'collapsed' }}"
                        href="{{ route('feedback.index') }}">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Feedback</span>
                    </a>
                </li><!-- End Dashboard Nav -->
            @endif

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('peserta.index') }}" class="">
                            <i class="bi bi-circle"></i><span>Peserta</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav --> --}}

            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan</span>
                </a>
            </li> --}}

        </ul>


    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Aerolearn</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @yield('content')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>AeroLearn</span></strong>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/quill/quill.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('NiceAdmin') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('.table:not(.not)');
    </script>
    

    <!-- Template Main JS File -->
    <script src="{{ asset('NiceAdmin') }}/assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>

</body>

</html>
