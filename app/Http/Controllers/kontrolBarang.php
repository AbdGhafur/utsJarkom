<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Barang;
use App\Models\Ruang;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Illuminate\Support\Facades\DB;
use Whoops\Run;
use Illuminate\Support\Facades\Mail;
use App\Mail\KonfirmasiLelang;
use PDF;


class kontrolBarang extends Controller
{
    public function index(){
       return view('sign-up');
    }
    public function haveAkun(){
        return view('sign-in');
    }
    public function home(){
        return view('beranda');
    }
    public function data(){
        $barang = Barang::with('Ruang')-> get();
        return view('data', compact('barang'));
    }
    public function add_data(){
        return view('tambah-data');
    }
    public function store_data(Request $request){
        $validatedData = $request->validate([
            'kode_barang' => 'required',
            'nama' => 'required',
            'type' => 'required',
            'kategori' => 'required',
            'nama_ruang' => 'required',
            'keterangan' => 'required',
    
        ]);
    
        $ruang = new Ruang();
        $ruang->nama_ruang = $request->input('nama_ruang');
        $ruang->save();
    
        $barang = new Barang();
        $barang->kode_barang = $request->input('kode_barang');
        $barang->nama = $request->input('nama');
        $barang->type = $request->input('type');
        $barang->kategori = $request->input('kategori');
        $barang->keterangan= $request->input('keterangan');
        $barang->idruang = $ruang->idruang;
        $barang->save();
    
        return redirect('/admin/data')->with('success', 'Data has been saved.');
    }
    
    public function delete(Request $request, $idbarang){
        $barang = Barang::find($idbarang);
        if(!$barang){
            return redirect()->back()->with('error','Tabel tidak ditemukan.');
        }
        // hapus relasi pada tabel 'ruang' jika ada
        if($barang->ruang){
            $barang->ruang()->delete();
        }
        $barang->delete();
        return redirect()->route('data')->with('success','Data berhasil dihapus.');
    }
    public function showInfoData($idbarang){
        $barang = Barang::with('ruang')->find($idbarang);
        return view('info-data',['barang' => $barang]);
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
        return view('info-data', ['barang' => $barang, 'pngData' => $pngData]);
    }
    
    public function showQRCode($idbarang){
        $barang = Barang::findOrFail($idbarang);
        return view('info-QR', ['barang' => $barang]);
    }

    public function edit($idbarang){
        $barang = Barang::findOrFail($idbarang);
        $ruang = Ruang::pluck('nama_ruang', 'idruang');
        return view('edit-data', compact('barang', 'ruang'));
    }

    public function update(Request $request, $idbarang){
        $barang = Barang::findOrFail($idbarang);
        $barang->kode_barang = $request->input('kode_barang');
        $barang->nama = $request->input('nama');
        $barang->kategori = $request->input('kategori');
        $barang->type = $request->input('type');
        
        // mendapatkan instance dari model Ruang yang terkait dengan Barang
        $ruang = $barang->ruang;
        $ruang->nama_ruang = $request->input('nama_ruang');
        
        $barang->keterangan = $request->input('keterangan');

        // menyimpan perubahan pada kedua model
        $barang->save();
        $ruang->save();

        return redirect()->route('data')->with('success', 'Data berhasil diperbarui!');
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

        return view('data', compact('barang'));
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
    
        return view('data', compact('barang'));
    }

    //----------------------//

    public function GedungA(Request $request)
    {
        $sort = $request->input('sort') ?? 'kode_barang';
        $order = $request->input('order') ?? 'asc';
        $nama_ruang = $request->input('nama_ruang');

        $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                        ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                        ->where('ruang.nama_ruang', 'like', 'RA%')
                        ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                        ->orderBy($sort, $order)
                        ->get();

        return view('G-A', compact('barangs'));
    }

    public function filterRA(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if ($sort == 'kode_barang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kode_barang', $order)
                            ->get();
        } elseif ($sort == 'nama') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.nama', $order)
                            ->get();
        } elseif ($sort == 'kategori') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kategori', $order)
                            ->get();
        } elseif ($sort == 'type') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.type', $order)
                            ->get();
        } elseif ($sort == 'ruang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('ruang.nama_ruang', $order)
                            ->get();
        } else {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->get();
        }   
                 
        return view('G-A', compact('barang'));
    }

    public function GedungB(Request $request)
    {
        $sort = $request->input('sort') ?? 'kode_barang';
        $order = $request->input('order') ?? 'asc';
        $nama_ruang = $request->input('nama_ruang');

        $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                        ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                        ->where('ruang.nama_ruang', 'like', 'RB%')
                        ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                        ->orderBy($sort, $order)
                        ->get();
        return view('G-B', compact('barangs'));
    }

    public function filterRB(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if ($sort == 'kode_barang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kode_barang', $order)
                            ->get();
        } elseif ($sort == 'nama') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.nama', $order)
                            ->get();
        } elseif ($sort == 'kategori') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kategori', $order)
                            ->get();
        } elseif ($sort == 'type') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.type', $order)
                            ->get();
        } elseif ($sort == 'ruang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('ruang.nama_ruang', $order)
                            ->get();
        } else {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RB%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->get();
        }               
        return view('G-B', compact('barangs'));
    }

    public function GedungC(Request $request)
    {
        $sort = $request->input('sort') ?? 'kode_barang';
        $order = $request->input('order') ?? 'asc';
        $nama_ruang = $request->input('nama_ruang');

        $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                        ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                        ->where('ruang.nama_ruang', 'like', 'RC%')
                        ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                        ->orderBy($sort, $order)
                        ->get();

        return view('G-C', compact('barangs'));
    }
    public function filterRC(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if ($sort == 'kode_barang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kode_barang', $order)
                            ->get();
        } elseif ($sort == 'nama') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.nama', $order)
                            ->get();
        } elseif ($sort == 'kategori') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kategori', $order)
                            ->get();
        } elseif ($sort == 'type') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.type', $order)
                            ->get();
        } elseif ($sort == 'ruang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('ruang.nama_ruang', $order)
                            ->get();
        } else {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->where('ruang.nama_ruang', 'like', 'RC%')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->get();
        }               
        return view('G-B', compact('barangs'));

    }
    // lelang
    public function lelang()
    {
        $barang = Barang::with('Ruang')->where('kategori', '=', 'Rusak Ringan')->get();
        return view('lelang', compact('barang'));
    }
    //----------------- 

    public function sendToPimpinan(Request $request)
    {
        $selected_ids = $request->input('selected');
        // dd($selected_ids); // tambahkan kode ini untuk memeriksa nilai dari $selected_ids
        $barang = Barang::whereIn('idbarang', $selected_ids)->get();

        // validasi bahwa minimal satu barang yang dipilih
        if (count($barang) == 0) {
            return back()->with('error', 'Minimal pilih satu barang');
        }

        // perbarui status barang menjadi pending
        foreach ($barang as $b) {
            $b->status = 0;
            $b->save();
        }

        return back()->with('success', 'Status barang berhasil diperbarui.');
    }
    //-----------------------
    public function updateHarga(Request $request, $idbarang){
        $barang = Barang::findOrFail($idbarang);
        $barang->harga = $request->input('harga');
        
        // menyimpan perubahan pada kedua model
        $barang->save();
    
        return redirect()->route('lelang')->with('success', 'Data berhasil diperbarui!');
    }

    //-----------------------

    public function editHarga($idbarang){
        $barang = Barang::findOrFail($idbarang);
        $ruang = Ruang::pluck('nama_ruang', 'idruang');
        return view('edit-harga', compact('barang', 'ruang'));
    }

    //-----------------------

    public function filterLelang(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if($sort == 'kode_barang'){
            $barang = Barang::where('kategori', '=', 'Rusak Ringan')->orderBy('kode_barang', $order)->get();
        } elseif($sort == 'nama') {
            $barang = Barang::where('kategori', '=', 'Rusak Ringan')->orderBy('nama', $order)->get();
        } elseif($sort == 'kategori') {
            $barang = Barang::where('kategori', '=', 'Rusak Ringan')->orderBy('kategori', $order)->get();
        } elseif($sort == 'type') {
            $barang = Barang::where('kategori', '=', 'Rusak Ringan')->orderBy('type', $order)->get();
        } elseif($sort == 'ruang') {
            $barang = Barang::join('ruang', 'barang.idruang', '=', 'ruang.idruang')
                ->where('kategori', '=', 'Rusak Ringan')
                ->select('barang.*')
                ->orderBy('ruang.nama_ruang', $order)
                ->get();
        } else {
            $barang = Barang::where('kategori', '=', 'Rusak Ringan')->get();
        }
        return view('lelang', compact('barang'));
    }
// hapus 
    public function hapus(){
        $barang = Barang::with('Ruang')->where('kategori', '=', 'Rusak Berat')->get();
        return view('hapus', compact('barang'));
    }

    public function filterHapus(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if($sort == 'kode_barang'){
            $barang = Barang::where('kategori', '=', 'Rusak Berat')->orderBy('kode_barang', $order)->get();
        } elseif($sort == 'nama') {
            $barang = Barang::where('kategori', '=', 'Rusak Berat')->orderBy('nama', $order)->get();
        } elseif($sort == 'kategori') {
            $barang = Barang::where('kategori', '=', 'Rusak Berat')->orderBy('kategori', $order)->get();
        } elseif($sort == 'type') {
            $barang = Barang::where('kategori', '=', 'Rusak Berat')->orderBy('type', $order)->get();
        } elseif($sort == 'ruang') {
            $barang = Barang::join('ruang', 'barang.idruang', '=', 'ruang.idruang')
                ->where('kategori', '=', 'Rusak Berat')
                ->select('barang.*')
                ->orderBy('ruang.nama_ruang', $order)
                ->get();
        } else {
            $barang = Barang::where('kategori', '=', 'Rusak Berat')->get();
        }
        return view('hapus', compact('barang'));
    }

    public function laporan(){
        $barangs = Barang::select('kode_barang', 'nama', 'kategori', 'type', DB::raw('COUNT(*) as jumlah'))
                        ->with('ruang')
                        ->groupBy('kode_barang', 'nama', 'kategori', 'type')
                        ->get();
    
        return view('laporan', compact('barangs'));
    }
    

    public function filterLaporan(Request $request){
        $sort = $request->input('sort');
        $order = $request->input('order');
    
        if ($sort == 'kode_barang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kode_barang', $order)
                            ->get();
        } elseif ($sort == 'nama') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.nama', $order)
                            ->get();
        } elseif ($sort == 'kategori') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.kategori', $order)
                            ->get();
        } elseif ($sort == 'type') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('barang.type', $order)
                            ->get();
        } elseif ($sort == 'ruang') {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->orderBy('ruang.nama_ruang', $order)
                            ->get();
        } else {
            $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->get();
        }  
    
        return view('laporan', compact('barangs'));
    }
    public function searchLaporan(Request $request)
    {
        $keyword = $request->input('keyword');

        $barangs = Barang::where('kode_barang', 'like', "%$keyword%")
            ->orWhere('nama', 'like', "%$keyword%")
            ->orWhere('kategori', 'like', "%$keyword%")
            ->orWhere('type', 'like', "%$keyword%")
            ->orWhereHas('ruang', function ($query) use ($keyword) {
                $query->where('nama_ruang', 'like', "%$keyword%");
            })
            -> select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                            ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                            ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                            ->get();

        return view('laporan', compact('barangs'));
    }
    
    public function statistik()
    {
        $barang = Barang::with('ruang')->get();

        $total = $barang->count();

        $baik = $barang->where('kategori', 'Baik')->count();
        $rusak_ringan = $barang->where('kategori', 'Rusak Ringan')->count();
        $rusak_berat = $barang->where('kategori', 'Rusak Berat')->count();

        $baik_percent = $total > 0 ? number_format($baik / $total * 100, 2) : 0;
        $rusak_ringan_percent = $total > 0 ? number_format($rusak_ringan / $total * 100, 2) : 0;
        $rusak_berat_percent = $total > 0 ? number_format($rusak_berat / $total * 100, 2) : 0;

        $jumlah_barang = $barang->count();
        $rata_rata = $jumlah_barang > 0 ? number_format($total / $jumlah_barang, 2) : 0;

        return view('statistik', compact('total', 'baik', 'rusak_ringan', 'rusak_berat', 'baik_percent', 'rusak_ringan_percent', 'rusak_berat_percent', 'jumlah_barang', 'rata_rata'));
    }

    public function cetakGedungA()
    {
        $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                        ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                        ->where('ruang.nama_ruang', 'like', 'RA-Admin%')
                        ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                        ->get();

        // Render view menjadi PDF
        $pdf = PDF::loadView('ruang-admin', ['barangs' => $barangs]);
        
        return $pdf->download('laporan-data.pdf');
        
    }

    public function ruangAdmin(Request $request)
    {

        $barangs = Barang::select('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang', DB::raw('COUNT(*) as jumlah'))
                        ->leftJoin('ruang', 'barang.idruang', '=', 'ruang.idruang')
                        ->where('ruang.nama_ruang', 'like', 'RA-Admin%')
                        ->groupBy('barang.kode_barang', 'barang.nama', 'barang.kategori', 'barang.type', 'ruang.nama_ruang')
                        ->get();

        return view('ruang-admin', compact('barangs'));
    }
}