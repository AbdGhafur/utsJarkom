<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="{{asset('css/nav bar.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <title>Laporan</title>
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
            <div>
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow">
                                <div class="card-header fw-bold">{{ __('Statistik Data Barang') }}</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Total jumlah data Barang</td>
                                                <td>{{ $total }}</td>
                                            </tr>
                                            <tr>
                                                <td>Barang dengan kategori "Baik"</td>
                                                <td>{{ $baik }} ({{ $baik_percent }}%)</td>
                                            </tr>
                                            <tr>
                                                <td>Barang dengan kategori "Rusak Ringan"</td>
                                                <td>{{ $rusak_ringan }} ({{ $rusak_ringan_percent }}%)</td>
                                            </tr>
                                            <tr>
                                                <td>Barang dengan kategori "Rusak Berat"</td>
                                                <td>{{ $rusak_berat }} ({{ $rusak_berat_percent }}%)</td>
                                            </tr>
                                            <tr>
                                                <td>Rata-rata Jumlah Barang</td>
                                                <td>{{ $rata_rata }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <canvas id="chart-kategori"></canvas>
                                    <script>
                                        var ctx = document.getElementById('chart-kategori').getContext('2d');
                                        var chartKategori = new Chart(ctx, {
                                            type: 'pie',
                                            data: {
                                                labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                                                datasets: [{
                                                    label: 'Persentase Kondisi Barang',
                                                    data: [
                                                        {{$baik_percent}},
                                                        {{$rusak_ringan_percent}},
                                                        {{$rusak_berat_percent}}
                                                    ],
                                                    backgroundColor: [
                                                        'rgba(75, 192, 192, 0.2)',
                                                        'rgba(255, 159, 64, 0.2)',
                                                        'rgba(255, 99, 132, 0.2)'
                                                    ],
                                                    borderColor: [
                                                        'rgba(75, 192, 192, 1)',
                                                        'rgba(255, 159, 64, 1)',
                                                        'rgba(255, 99, 132, 1)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                title: {
                                                    display: true,
                                                    text: 'Persentase Kondisi Barang'
                                                },
                                                legend: {
                                                    display: true,
                                                    position: 'bottom'
                                                },
                                                animation: {
                                                    animateScale: true,
                                                    animateRotate: true
                                                }
                                            }
                                        });
                                    </script>
                                    <hr>
                                    <a href="{{ url('/laporan') }}" role="button" class="btn btn-primary shadow">Lihat Tabel</a>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
