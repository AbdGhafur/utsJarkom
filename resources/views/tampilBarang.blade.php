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
        <title>Data Beranda</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="bi bi-hexagon-fill"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="{{url('/beranda')}}" class="nav-item" active-color="blue"><i class="bi bi-house-door-fill"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/tampil-barang')}}" class="nav-item is-valid" active-color="blue"><i class="bi bi-database"></i> Data</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/ruang')}}" class="nav-item" active-color="blue"><i class="bi bi-buildings"></i> Ruang</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/lelang-dan-hapus')}}" class="nav-item" active-color="blue"><i class="bi bi-cart-x"></i> Lelang & <i class="bi bi-trash"></i> Hapus</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-item" active-color="blue"><i class="bi bi-clipboard-data"></i> Laporan</a>
                        </li>
                    </ul>
                    <span class="nav-indicator"></span>
                    <script src="{{asset('js/nav bar.js')}}"></script>
                </div>
                <div class="dropdown">
                    <span class="justify-content-end" style="text-decoration: none;" role="button" data-bs-toggle="dropdown" data-bs-target="#Dropdownpp" aria-expanded="false" aria-controls="Dropdownpp">Your Name Here</span>
                    <span class="dropdown-menu">
                        <a href="./sign-in.blade.php" class="dropdown-item bg-transparent">Sign Out</a>
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
                    <a href="{{url('/tambah-data')}}" type="button" class="btn btn-outline-primary shadow-sm fw">
                        <i class="bi bi-plus-lg"></i>
                        Baru
                    </a>
                </div>
                <div class="container-fluid">
                    <form class="d-flex sh" role="search">
                        <input class="form-control me-2 shadow-sm" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary shadow-sm" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
            <br><br>
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <label class="col-form-label col-sm-auto">Urut Berdasarkan</label>
                            <div class="col-sm-auto">
                              <select class="form-select">
                                <option value="1">A-Z</option>
                                <option value="2">Kategori</option>
                                <option value="3">Type</option>
                                <option value="4">Ruang</option>
                              </select>
                            </div>
                        </div>
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
                                    <td>{{$bar->ruang->nama_ruang}}</td>
                                    <td class="gap-3">
                                        <a href="./info-data.blade.php" class="btn btn-outline-info shadow-sm"><i class="bi bi-eye"></i> Lihat</a>
                                        <a href="./edit data.html" class="btn btn-outline-warning shadow-sm"><i class="bi bi-pencil-square"></i> Rubah</a>
                                        <a href="/data-delete/{{$bar->kode_barang}}"  class="btn btn-outline-danger shadow-sm"><i class="bi bi-trash2-fill"></i>@method('DELETE') Hapus</a>
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
