<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{asset('css/nav bar.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <title>Beranda</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary ">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi bi-hexagon-fill"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="{{ route('data') }}" class="nav-item" active-color="blue"><i class="bi bi-database"></i> Data</a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-item dropdown-toggle" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp" active-color="blue"><i class="bi bi-buildings"></i> Gedung</span>
                            <span class="dropdown-menu border-primary shadow">
                                <a href="{{ url('/gedung-A') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-buildings"></i>  Gedung A</a>
                                <a href="{{ url('/gedung-B') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-buildings"></i>  Gedung B</a>
                                <a href="{{ url('/gedung-C') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-buildings"></i>  Gedung C</a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-item is-valid dropdown-toggle" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp" active-color="blue"><i class="bi bi-bucket-fill"></i> Lelang dan hapus</span>
                            <span class="dropdown-menu border-primary shadow">
                                <a href="{{ route('lelang') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-cart-x"></i> Lelang </a>
                                <a href="{{ route('hapus') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-trash"></i> Hapus</a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/laporan')}}" class="nav-item" active-color="blue"><i class="bi bi-clipboard-data"></i> Laporan</a>
                        </li>
                    </ul>
                    <span class="nav-indicator"></span>
                    <script src="{{asset('js/nav bar.js')}}"></script>
                </div>
                <div class="dropdown">
                    <span class="nav-link dropdown-toggle" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp">
                        @if(Auth::check())
                            {{ Auth::user()->name }}
                        @else
                            Your Name Here
                        @endif
                    </span>
                    <span class="dropdown-menu border-primary shadow-sm">
                        <a href="{{ route('logout') }}" class="dropdown-item bg-transparent btn btn-outline-primary" style="text-align: center;" role="button" onclick="return confirm('Apakah anda yakin ingin melakukan Log - Out ?');">Sign Out</a>
                    </span>
                </div>
                <a class="nav-item bi bi-person-circle disabled"></a>
            </div>
        </nav>
        <br>
        <div class="container">
            <div class="row ">
                <div class="col-sm-4 ms-auto">
                    <div class="card shadow-sm">
                        <div class="card-body row">
                            <h5 class="card-title col-sm-10">jenis</h5>
                            <a href="./Data barang.html" class="col-sm-auto"><h4 class="bi bi-arrow-up-right-square-fill"></h4></a>
                            <p class="card-text">Barang layak</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ms-auto">
                    <div class="card shadow-sm">
                        <div class="card-body row">
                            <h5 class="card-title col-sm-10">jenis</h5>
                            <a href="./Data barang.html" class="col-sm-auto"><h4 class="bi bi-arrow-up-right-square-fill"></h4></a>
                            <p class="card-text">Barang cukup layak</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ms-auto">
                    <div class="card shadow-sm">
                        <div class="card-body row">
                            <h5 class="card-title col-sm-10">jenis</h5>
                            <a href="./Data barang.html" class="col-sm-auto"><h4 class="bi bi-arrow-up-right-square-fill"></h4></a>
                            <p class="card-text">Barang rusak</p>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="card shadow">
                <div class="card-body">
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-touch="false">
                        <div class="carousel-inner">
                        <!-- <div class="carousel-item active">
                                <img src="{{asset('img/IMG-0104042023.jpg')}}" class="d-block w-100" alt="...">
                            </div> -->
                            <div class="carousel-item">
                                <img src="" class="img-fluid rounded mx-auto d-block" alt="...">
                            </div>
                            <div class="carousel-item active rounded">
                                <img src="{{asset('img/IMG-0304042023.jpg')}}" class="img-fluid rounded mx-auto d-block" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <br>
        </div>
    </body>
    <footer>
        <div class="footer fw-bold">
            &copy; Copyright
        </div>
        <style>
            .footer{
                position:relative;
                bottom:0;
                width:100%;
                height:60px;
                text-align: center;
            }
        </style>
    </footer>
</html>
