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
        <title>Data - Edit Data</title>
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
                <form class="d-flex" role="search">
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
        <br><br>
        <br><br>
        <div class="container">
            <div class="card">
                <div class="card-body shadow">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title fw-bold" style="text-align: center;">Form Edit data</div>
                            <br><br>
                           <form action="{{ url('/admin/update/' . $barang->idbarang) }}" method="GET" class="mb-3">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Kode Barang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="kode_barang" value="{{ $barang->kode_barang }}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Nama Barang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama" value="{{ $barang->nama }}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Kategori</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" aria-label="kategori...." aria-placeholder="dd" name="kategori" disabled>
                                            <option value="Baik" {{ $barang->kategori == 1 ? 'selected' : '' }}>Baik</option>
                                            <option value="Rusak Ringan" {{ $barang->kategori == 2 ? 'selected' : '' }}>Rusak Ringan</option>
                                            <option value="Rusak Berat" {{ $barang->kategori == 3 ? 'selected' : '' }}>Rusak Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" aria-label="kategori...." aria-placeholder="dd" name="type" disabled>
                                            <option value="Elektronik" {{ $barang->type == 1 ? 'selected' : '' }}>Elektronik</option>
                                            <option value="Non Elektronik" {{ $barang->type == 2 ? 'selected' : '' }}>Non Elektronik</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Ruang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_ruang" value="{{ $barang->ruang->nama_ruang }}" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Keterangan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" aria-label="With textarea" name="keterangan" disabled>{{ $barang->keterangan }}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row justify-content-between">
                                    <label class="col-form-label col-sm-4">Harga</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="harga" value="{{ $barang->harga }}">
                                    </div>
                                </div>
                                <br>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a class="btn btn-primary shadow-sm" href="{{ route('lelang') }}" role="button" style="text-decoration: none;" >Batal</a>
                                    <button class="btn btn-primary me-md-2 shadow-sm" type="submit" >Simpan</button>
                                </div>
                            </form>
                        </div>
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