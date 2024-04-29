<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Barang;
use App\Models\Ruang;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Illuminate\Support\Facades\Mail;
use App\Mail\KonfirmasiLelang;
use DateTime;

class UserKontrol extends Controller{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:admin,pimpinan'
        ]);

        if($validator->fails()){
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return redirect('/sign-in');
    }

    public function homePimpinan(){
        return view('beranda-pimpinan');
    }
    
    public function dataPimpinan(){
        $barang = Barang::with('Ruang')->get();
        return view('data-pimpinan', compact('barang'));
    }

    public function showInfoData($idbarang){
        $barang = Barang::with('ruang')->find($idbarang);
        return view('info-data-pimpinan',['barang' => $barang]);
    }

    public function generateQRCode($idbarang)
    {
        $barang = Barang::findOrFail($idbarang);
        $qrCode = new QrCode($barang->kode_barang);
        $qrCode->setSize(250);
        $qrCode->setEncoding(new Encoding('UTF-8'));
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());
        $writer = new PngWriter();
        $pngData = $writer->write($qrCode)->getDataUri();
        return view('info-data-pimpinan', ['barang' => $barang, 'pngData' => $pngData]);
    }
    
    public function showQRCode($idbarang){
        $barang = Barang::findOrFail($idbarang);
        return view('info-QR', ['barang' => $barang]);
    }

    //Serach
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $barang = Barang::where('kode_barang', 'like', "%$keyword%")
            ->orWhere('nama', 'like', "%$keyword%")
            ->orWhere('kategori', 'like', "%$keyword%")
            ->orWhere('type', 'like', "%$keyword%")
            ->orWhereHas('ruang', function ($query) use ($keyword) {
                $query->where('nama_ruang', 'like', "%$keyword%");
            })
            ->join('ruang', 'barang.idruang', '=', 'ruang.idruang')
            ->get();

        return view('data-pimpinan', compact('barang'));
    }

    public function filterdata(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if($sort == 'kode_barang'){
            $barang = Barang::orderBy('kode_barang', $order)->get();
        } elseif($sort == 'nama') {
            $barang = Barang::orderBy('nama', $order)->get();
        } elseif($sort == 'kategori') {
            $barang = Barang::orderBy('kategori', $order)->get();
        } elseif($sort == 'type') {
            $barang = Barang::orderBy('type', $order)->get();
        } elseif($sort == 'ruang') {
            $barang = Barang::join('ruang', 'barang.idruang', '=', 'ruang.idruang')
                ->select('barang.*')
                ->orderBy('ruang.nama_ruang', $order)
                ->get();
        } else {
            $barang = Barang::all();
        }
    
        return view('data-pimpinan', compact('barang'));
    }
    //----------------------//

    public function lelangPimpinan()
    {
        $barang = Barang::where('kategori', '=', 'Rusak Ringan')->get();
        foreach ($barang as $item) {
            $tanggal_masuk = DateTime::createFromFormat('Y-m-d H:i:s', $item->tanggal_masuk);
            $item->tanggal_masuk = $tanggal_masuk;
        }
        return view('lelang-pimpinan', compact('barang'));
    }

    public function approve($idbarang){
        $lelang = Barang::findOrFail($idbarang);
        $lelang -> status = 1;
        $lelang -> save();

        return redirect()->back();
    }

    public function reject($idbarang){
        $lelang = Barang::find($idbarang);

        if($lelang){
            $lelang -> status = 2;
            $lelang -> save();

            return redirect()->back()->with('success', 'Lelang berhasil ditolak.');
        }
        return redirect()->back()->with('error', 'Lelang tidak ditemukan.');
    }

    public function hapusPimpinan()
    {
        $barang = Barang::where('kategori', '=', 'Rusak Berat')->get();
        foreach ($barang as $item) {
            $tanggal_masuk = DateTime::createFromFormat('Y-m-d H:i:s', $item->tanggal_masuk);
            $item->tanggal_masuk = $tanggal_masuk;
        }
        return view('hapus-pimpinan', compact('barang'));
    }
    
    public function destroy($idbarang)
    {
        Barang::findOrFail($idbarang)->delete();

        return redirect()->route('barang.index')
                        ->with('success', 'Barang berhasil dihapus.');
    }
}