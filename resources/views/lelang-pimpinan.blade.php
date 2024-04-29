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
        <title>Lelang</title>
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
                            <a href="{{ route('data.pimpinan') }}" class="nav-item" active-color="blue"><i class="bi bi-database"></i> Data</a>
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
                <form action="{{ route('pimpinan.search') }}" class="d-flex me-2" role="search">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary shadow-sm" type="submit"><i class="bi bi-search"></i></button>
                </form>
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
        <br><br>
        <div class="container">
            <br>
            <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <br>
                        <div class="card shadow">
                            <div class="card-body">
                                <br>
                                <h5 class="card-title">Daftar Barang Yang Diajukan</h5>
                                <br>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th scope="col">NO.</th>
                                            <th scope="col">Barang</th>
                                            <th scope="col">Harga Awal</th>
                                            <th scope="col">Tanggal Masuk</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($barang as $item)
                                        <tr style="text-align: center;">
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{ $item->nama}}</td>
                                            <td>Rp{{ number_format($item->harga, 0, '.', '.') }}</td>
                                            <td>{{ $item->updated_at->format('d M Y H:i:s') }}</td>
                                            <td>
                                                @if($item->status == 0)
                                                <span class="badge bg-primary">Menunggu Konfirmasi</span>
                                                @elseif($item->status == 1)
                                                <span class="badge bg-success">Disetujui</span>
                                                @elseif($item->status == 2)
                                                <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="grid gap-3">
                                                @if($item->status == 0)
                                                <a href="{{ route('lelang.approve', $item->idbarang) }}" class="col btn btn-outline-primary btn-sm">Setujui</a>
                                                <a href="{{ route('lelang.reject', $item->idbarang) }}" class="col btn btn-outline-warning btn-sm">Tolak</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
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