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
        <title>Ruang</title>
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
                            <a href="{{url('/tampil-barang')}}" class="nav-item" active-color="blue"><i class="bi bi-database"></i> Data</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/ruang')}}" class="nav-item is-valid" active-color="blue"><i class="bi bi-buildings"></i> Ruang</a>
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
            <div class="container-fluid">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary shadow-sm" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <br><br>
            <div class="container-fluid">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#Collapse1" aria-expanded="false" aria-controls="Collapse1">Ruang A</button>
                <div class="row">
                    <div class="col">
                        <!-- Ruang A -->
                        <br>
                        <div class="collapse multi-collapse" id="Collapse1">
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
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Ruang</th>
                                                <th scope="col">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="text-align: center;">
                                                <th scope="row">1</th>
                                                <td>kode </td>
                                                <td>Meja Kayu </td>
                                                <td>Rusak Parah</td>
                                                <td>Non Elektronik</td>
                                                <td>2</td>
                                                <td>RA-2</td>
                                                <td>...</td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th scope="row">2</th>
                                                <td>kode </td>
                                                <td>PC - HP </td>
                                                <td>Rusak Ringan</td>
                                                <td>Elektronik</td>
                                                <td>6</td>
                                                <td>RA-1</td>
                                                <td>...</td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th scope="row">3</th>
                                                <td>kode </td>
                                                <td>Kursi Besi </td>
                                                <td>Rusak Ringan</td>
                                                <td>Non Elektronik</td>
                                                <td>5</td>
                                                <td>RA-1</td>
                                                <td>...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Ruang B -->
                <br>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#Collapse2" aria-expanded="false" aria-controls="Collapse2">Ruang B</button>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="Collapse2">
                            <br>
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
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Ruang</th>
                                                <th scope="col">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="text-align: center;">
                                                <th scope="row">1</th>
                                                <td>kode </td>
                                                <td>Proyektor </td>
                                                <td>Rusak Ringan</td>
                                                <td>Elektronik</td>
                                                <td>1</td>
                                                <td>RB-1</td>
                                                <td>...</td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th scope="row">2</th>
                                                <td>kode </td>
                                                <td>PC - HP </td>
                                                <td>Rusak Parah</td>
                                                <td>Elektronik</td>
                                                <td>3</td>
                                                <td>RB-1</td>
                                                <td>Monitor Mati</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <!-- Ruang C -->
                <br>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#Collapse3" aria-expanded="false" aria-controls="Collapse3">Ruang C</button>
                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="Collapse3">
                            <br>
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
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Ruang</th>
                                                <th scope="col">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="text-align: center;">
                                                <th scope="row">1</th>
                                                <td>kode </td>
                                                <td>Meja Kayu </td>
                                                <td>Rusak Ringan</td>
                                                <td>Non Elektronik</td>
                                                <td>3</td>
                                                <td>RC-1</td>
                                                <td>...</td>
                                            </tr>
                                            <tr style="text-align: center;">
                                                <th scope="row">2</th>
                                                <td>kode </td>
                                                <td>Kursi Besi </td>
                                                <td>Rusak Parah</td>
                                                <td>Non Elektronik</td>
                                                <td>1</td>
                                                <td>RC-1</td>
                                                <td>...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
