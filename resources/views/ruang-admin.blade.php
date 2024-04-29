<!DOCTYPE html>
<html>
    <head>
        <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <style type="text/css">
            table tr td,
            table tr th{
                font-size: 9pt;
            }
        </style>
        <center>
            <h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
        </center>
        <br>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Type</th>
                    <th>Jumlah</th>
                    <th>Ruang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach($barangs as $barang)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->kategori }}</td>
                    <td>{{ $barang->type }}</td>
                    <td>{{ $barang->jumlah }}</td>
                    <td>{{ $barang->nama_ruang }}</td>
                    <td>{{ $barang->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
