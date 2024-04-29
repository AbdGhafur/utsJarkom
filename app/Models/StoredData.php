<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\KonfirmasiLelang;


class StoredData extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama',
        'kategori',
        'type',
        'nama_ruang',
        'keterangan',
        'status',
    ];

    public function sendEmail($email)
    {
        $barang = $this;
        Mail::to($email)->send(new KonfirmasiLelang($barang));
        $this->status = 'sudah dikirim';
        $this->save();
    }
}
