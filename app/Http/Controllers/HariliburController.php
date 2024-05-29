<?php

namespace App\Http\Controllers;
use App\Models\Harilibur;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class HariliburController extends Controller
{
    public function index()
    {
        $query = Harilibur::query();
        $query->orderBy('kode_libur','desc');
        $harilibur = $query->paginate(5);
        return view('harilibur.index',compact('harilibur'));
    }

    public function create()
    {
        return view('harilibur.create');
    }

    public function store(Request $request)
    {


        $tahun = date('Y',strtotime($request->tanggal_libur));
        $thn = substr($tahun,2,2);
        $lastlibur = DB::table('harilibur')
        ->whereRaw ('YEAR(tanggal_libur)="' . $tahun . '"')
        ->orderBy('kode_libur','desc')
        ->first();

    $lastkodelibur = $lastlibur != null ? $lastlibur->kode_libur : "";
    $format = "LB" . $thn;
    $kode_libur = buatkode($lastkodelibur,$format,3);

       try {
        DB::table('harilibur')
        ->insert([
            'kode_libur' => $kode_libur,
            'tanggal_libur' =>$request->tanggal_libur,
            'keterangan' => $request->keterangan
        ]);
        return Redirect::back()->with(['success' => 'Hari Libur Berhasil Di Tambahkan']);
       } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => $e->getMessage()]);
       }
    }

    public function edit(Request $request)
    {
        $kode_libur = $request->kode_libur;
        $harilibur = DB::table('harilibur')->where('kode_libur',$kode_libur)->first();
        return view('harilibur.edit',compact('harilibur'));
    }

    public function update(Request $request,$kode_libur)
    {

       try {
        DB::table('harilibur')
        ->where('kode_libur',$kode_libur)
        ->update([
            'tanggal_libur' =>$request->tanggal_libur,
            'keterangan' => $request->keterangan
        ]);
        return Redirect::back()->with(['success' => 'Hari Libur Berhasil Di Update']);
       } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => $e->getMessage()]);
       }
    }

    public function delete($kode_libur)
    {
        try {
            DB::table('harilibur')->where('kode_libur',$kode_libur)->delete();
            return Redirect::back()->with(['success' => 'Hari Libur Berhasil Di Hapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => $e->getMessage()]);
        }
    }

    public function setkaryawanlibur($kode_libur)
    {
        $harilibur = DB::table('harilibur')->where('kode_libur',$kode_libur)->first();
        return view('harilibur.setkaryawanlibur',compact('harilibur'));
    }

    public function setlistkaryawanlibur($kode_libur)
    {

        return view('harilibur.setlistkaryawanlibur',compact('kode_libur'));
    }

    public function getsetlistkaryawanlibur($kode_libur)
    {
        $harilibur = DB::table('harilibur')->where('kode_libur',$kode_libur)->first();
        $karyawan = DB::table('karyawan')
        ->select('karyawan.*','hariliburdetail.nik as ceknik')
        ->leftJoin(DB::raw("(

            SELECT nik FROM harilibur_detail
            WHERE kode_libur = '$kode_libur'
            )hariliburdetail"),


        function($join){
            $join->on('karyawan.nik','=','hariliburdetail.nik');
        }
    )
        ->orderBy('nama_lengkap')
        ->get();
        return view('harilibur.getsetlistkaryawanlibur',compact('karyawan','kode_libur'));
    }

    public function storekaryawanlibur(Request $request)
    {
        try {
            $cek = DB::table('harilibur_detail')
                ->where('kode_libur', $request->kode_libur)
                ->where('nik', $request->nik)
                ->count();

            if ($cek > 0) {
                // Karyawan sudah ada dalam daftar libur
                return response()->json(['status' => 'duplicate']);
            }

            DB::table('harilibur_detail')->insert([
                'kode_libur' => $request->kode_libur,
                'nik' => $request->nik,
            ]);

            // Operasi penyisipan berhasil
            return 0;
        } catch (\Exception $e) {
            // Terjadi kesalahan, kirim pesan kesalahan
            return  $e->getMessage();
        }
    }


    public function batalkanliburkaryawan(Request $request)
    {
        try {
        DB::table('harilibur_detail')
        ->where('kode_libur',$request->kode_libur)
        ->where('nik',$request->nik)
        ->delete();
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getkaryawanlibur($kode_libur)
{
    $karyawanlibur = DB::table('harilibur_detail')
        ->join('karyawan', 'harilibur_detail.nik', '=', 'karyawan.nik')
        ->where('kode_libur', $kode_libur)
        ->get(); 
    return view('harilibur.getkaryawanlibur', compact('karyawanlibur', 'kode_libur'));
}

}

