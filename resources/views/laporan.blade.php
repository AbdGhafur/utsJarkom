<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
        <link rel="stylesheet" href="{{asset('css/nav bar.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <title>Laporan</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-light">
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
                            <span class="dropdown-menu border-primary shadow bg-transparent">
                                <a href="{{ url('/gedung-A') }}" class="dropdown-item bg-transparent btn btn-outline-primary" active-color="blue">Gedung A</a>
                                <a href="{{ url('/gedung-B') }}"  class="dropdown-item bg-transparent btn btn-outline-primary" active-color="blue">Gedung B</a>
                                <a href="{{ url('/gedung-C') }}"  class="dropdown-item bg-transparent btn btn-outline-primary">Gedung C</a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-item dropdown-toggle" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp" active-color="blue"><i class="bi bi-bucket-fill"></i> Lelang dan hapus</span>
                            <span class="dropdown-menu border-primary shadow">
                                <a href="{{ route('lelang') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-cart-x"></i> Lelang </a>
                                <a href="{{ route('hapus') }}" class="dropdown-item bg-transparent" active-color="blue"><i class="bi bi-trash"></i> Hapus</a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan') }}" class="nav-item is-valid" active-color="blue"><i class="bi bi-clipboard-data"></i> Laporan</a>
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
        <br><br>
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="container-fluid">
                    <form action="{{ url('/laporan/search') }}" method="GET" class="d-flex sh ">
                        <div class="input-group mb-3">
                            <input type="text" name="keyword" class="form-control shadow-sm" placeholder="Cari barang..." aria-label="Cari barang..." aria-describedby="button-cari">
                            <button class="btn btn-primary shadow-sm" type="submit" id="button-cari"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid mt-4">
                <div class="card shadow">
                    <div class="card-body">
                        <br>
                        <form action="{{ url('/laporan/filter') }}" method="GET">
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
                        <!-- <h5 class="card-title" style="text-align: center;"></h5> -->
                        <table class="table table-bordered">
                            <thead>
                                <tr style="text-align: center;">
                                    <th scope="col">NO.</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($barangs->count() > 0)
                                @foreach($barangs as $key => $barang)
                                <tr style="text-align: center;">
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $barang->kode_barang }}</td>
                                    <td>{{ $barang->nama }}</td>
                                    <td>{{ $barang->kategori }}</td>
                                    <td>{{ $barang->type }}</td>
                                    <td>{{ $barang->jumlah }}</td>
                                    <td>{{ $barang->keterangan }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" style="text-align: center;">Tidak ada data barang</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                        <a href="{{ url('/admin/statistik/laporan') }}" role="button" class="btn btn-primary shadow">Lihat Persentase</a>
                        <br>
                    </div>
                </div>
            </div>
            <!-- Menu Cetak Data Per Ruangan  -->
            <div class="container-fluid mt-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 style="text-align: center;" class="card-tittle">Menu daftar cetak data per ruang</h5>
                        <hr>
                        <div class="justify-content-around mt-4" style="text-align: center;">
                            <a href="{{ route('cetak.ruangAdmin') }}" role="button" class="btn btn-primary shadow ">Cetak Ruang Admin</a>
                            <a href="" role="button" class="btn btn-primary shadow ">Cetak Ruang Dosen</a>
                            <a href="" role="button" class="btn btn-primary shadow ">Cetak Ruang Perpustakaan</a>
                            <a href="" role="button" class="btn btn-primary shadow">Cetak Ruang Pegawai</a>
                            <a href="" role="button" class="btn btn-primary shadow">Cetak Ruang Akademik</a>
                        </div>
                        <div class="justify-content-around mt-4" style="text-align: center;">
                            <a href="" role="button" class="btn btn-primary shadow">Cetak Ruang B - Praktek 1</a>
                            <a href="" role="button" class="btn btn-primary shadow">Cetak Ruang B - Praktek 2</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>