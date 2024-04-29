<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $primaryKey = 'idbarang';
    public function ruang(){
        return $this->belongsTo(Ruang::class, 'idruang');
    }
    protected $table = 'barang';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = ['kode_barang', 'nama', 'kategori', 'type',    'keterangan', 'jumlah'];

}
