<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{asset('css/nav bar.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <title>Data Beranda</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="bi bi-hexagon-fill"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="{{ route('data.pimpinan') }}" class="nav-item is-valid" active-color="blue"><i class="bi bi-database"></i> Data</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-item is-valid dropdown-toggle" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp" active-color="blue"><i class="bi bi-bucket-fill"></i> Lelang dan hapus</span>
                                <span class="dropdown-menu border-primary shadow">
                                    <a href="{{ route('lelang.pimpinan') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-cart-x"></i> Lelang </a>
                                    <a href="{{ route('hapus.pimpinan') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-trash"></i> Hapus</a>
                                </span>
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
            <br>
            <br>
            <div class="container">
                <div class="d-flex justify-content-between">
                    <div class="container-fluid">
                        <form action="{{ route('pimpinan.search') }}" method="GET" class="d-flex sh ">
                            <div class="input-group mb-3">
                                <input type="text" name="keyword" class="form-control shadow-sm border-primary" placeholder="Cari barang..." aria-label="Cari barang..." aria-describedby="button-cari">
                                <button class="btn btn-primary shadow-sm" type="submit" id="button-cari"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-body">
                            <br>
                            <form action="{{ route('pimpinan.filter') }}" method="GET">
                                <div class="row">
                                    <label class="col-form-label col-sm-auto" for="sort">Sort By : </label>
                                    <div class="col-sm-auto">
                                        <select class="form-select" name="sort" id="sort">
                                            <option value="kode_barang">Kode Barang</option>
                                            <option value="nama">Nama Barang</option>
                                            <option value="kategori">Kategori</option>
                                            <option value="type">Type</option>
                                            <option value="ruang">Ruang</option>
                                        </select>
                                    </div>
                                    <label for="order" class="col-form-label col-sm-auto">Order :</label>
                                    <div class="col-sm-auto">
                                        <select class="form-select" name="order" id="order">
                                            <option value="asc">A-Z / 1-10</option>
                                            <option value="desc">Z-A / 10-1</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-sm-auto"><i class="bi bi-funnel-fill"></i> Filter </button>
                                </div>
                            </form>
                            <br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th scope="col">NO.</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Ruang</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barang as $bar)
                                    <tr style="text-align: center;">
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$bar->kode_barang}}</td>
                                        <td>{{$bar->nama}} </td>
                                        <td>{{$bar->kategori}}</td>
                                        <td>{{$bar->type}}</td>
                                        <td>{{$bar->ruang ? $bar->ruang->nama_ruang: '-' }}</td>
                                        <td class="gap-3">
                                            <a href="{{url('/pimpinan/generateQRCode/'.$bar->idbarang)}}" class="btn btn-outline-info shadow-sm"><i class="bi bi-eye"></i> Lihat</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="6" class="text-center">Tidak Ada Data..</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </body>
    <br><br>
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
