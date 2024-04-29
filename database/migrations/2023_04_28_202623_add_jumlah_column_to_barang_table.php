<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddJumlahColumnToBarangTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE barang ADD jumlah INT NOT NULL DEFAULT 1 AFTER keterangan');

        $query = 'CREATE TEMPORARY TABLE tmp_barang AS 
                  SELECT kode_barang, nama, kategori , keterangan, COUNT(*) as jumlah 
                  FROM barang GROUP BY kode_barang, nama, kategori, type keterangan';
        DB::statement($query);

        DB::statement('UPDATE barang, tmp_barang SET barang.jumlah = tmp_barang.jumlah 
                        WHERE barang.kode_barang = tmp_barang.kode_barang 
                        AND barang.nama = tmp_barang.nama 
                        AND barang.kategori = tmp_barang.kategori 
                        AND barang.type = tmp_barang.type 
                        AND barang.keterangan = tmp_barang.keterangan');

        DB::statement('DROP TEMPORARY TABLE IF EXISTS tmp_barang');
    }

    public function down()
    {
        DB::statement('ALTER TABLE barang DROP COLUMN jumlah');
    }
}
