<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $primaryKey = 'idruang';
    public function barang(){
        return $this->hasOne(Barang::class, 'idruang');
    }
    protected $table = 'ruang';
}
