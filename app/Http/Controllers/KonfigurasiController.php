<?php

namespace App\Http\Controllers;

use App\Models\Setjamkerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\dd;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id',1)->first();
        return view('konfigurasi.lokasikantor',compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request-> radius;

        $update = DB::table('konfigurasi_lokasi')->where('id',1)->update([
            'lokasi_kantor'=>$lokasi_kantor,
            'radius' => $radius
        ]);
        if ($update) {
            return Redirect::back()->with(['success'=>'Lokasi Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning'=>'Lokasi Gagal Di Update']);
        }

    }

    public function jamkerja()
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jamkerja',compact('jam_kerja'));
    }

    public function storejamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $status_istirahat = $request->status_istirahat;
        $awal_istirahat = $request->awal_istirahat;
        $akhir_istirahat = $request->akhir_istirahat;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;

        $data = [
            'kode_jam_kerja'=> $kode_jam_kerja,
            'nama_jam_kerja'=> $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk'=> $jam_masuk,
            'akhir_jam_masuk'=> $akhir_jam_masuk,
            'status_istirahat'=> $status_istirahat,
            'awal_istirahat' => $awal_istirahat,
            'akhir_istirahat' => $akhir_istirahat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam
        ];
        try {
            DB::table('jam_kerja')->insert($data);
            return Redirect::back()->with(['success'=>'Data Jam Kerja Berhasil Di Tambahkan']);
        } catch (\Exception $e) {
            //dd($e);
            return Redirect::back()->with(['warning'=>'Data Jam Kerja Gagal Di Tambahkan']);
        }
    }

    public function editjamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jamkerja = DB::table('jam_kerja')->where('kode_jam_kerja',$kode_jam_kerja)->first();
        return view('konfigurasi.editjamkerja',compact('jamkerja'));
    }

    public function updatejamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $status_istirahat = $request->status_istirahat;
        $awal_istirahat = $request->awal_istirahat;
        $akhir_istirahat = $request->akhir_istirahat;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;

        $data = [

            'nama_jam_kerja'=> $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk'=> $jam_masuk,
            'akhir_jam_masuk'=> $akhir_jam_masuk,
            'status_istirahat'=> $status_istirahat,
            'awal_istirahat' => $awal_istirahat,
            'akhir_istirahat' => $akhir_istirahat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam
        ];
        try {
            DB::table('jam_kerja')->where('kode_jam_kerja',$kode_jam_kerja)->update($data);
            return Redirect::back()->with(['success'=>'Data Jam Kerja Berhasil Di Update']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning'=>'Data Jam Kerja Gagal Di Update']);
        }
    }

    public function deletejamkerja($kode_jam_kerja)
    {
        $delete = DB::table('jam_kerja')->where('kode_jam_kerja',$kode_jam_kerja)->delete();
        if ($delete) {
            return Redirect::back()->with(['success'=>'Data Jam Kerja Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Jam Kerja Gagal Di Hapus']);
        }
    }

    public function setjamkerja($nuptk)
    {
        $guru = DB::table('guru')->where('nuptk',$nuptk)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cekjamkerja = DB::table('konfigurasi_jamkerja')->where('nuptk',$nuptk)->count();
        if ($cekjamkerja > 0) {
            $setjamkerja = DB::table('konfigurasi_jamkerja')->where('nuptk',$nuptk)->get();
            return view('konfigurasi.editsetjamkerja',compact('guru','jamkerja','setjamkerja'));
        }else{
            return view('konfigurasi.setjamkerja',compact('guru','jamkerja'));
        }



    }

    public function storesetjamkerja(Request $request)
    {
        $nuptk = $request-> nuptk;
        $hari = $request-> hari;
        $kode_jam_kerja = $request-> kode_jam_kerja;

        for ($i = 0 ; $i <count($hari) ; $i++) {
            $data[]=[
                'nuptk'=> $nuptk,
                'hari'=> $hari[$i],
                'kode_jam_kerja'=> $kode_jam_kerja[$i]
            ];
        }
        try {
            Setjamkerja::insert($data);
            return redirect('/guru')->with(['success'=> 'Jam Kerja Berhasil Di Setting']);
        } catch (\Exception $e) {
            return redirect('/guru')->with(['warning'=> 'Jam Kerja Gagal Di Setting']);
        }
    }

    public function updatesetjamkerja(Request $request)
    {
        $nuptk = $request-> nuptk;
        $hari = $request-> hari;
        $kode_jam_kerja = $request-> kode_jam_kerja;

        for ($i = 0 ; $i <count($hari) ; $i++) {
            $data[]=[
                'nuptk'=> $nuptk,
                'hari'=> $hari[$i],
                'kode_jam_kerja'=> $kode_jam_kerja[$i]
            ];
        }

        DB::beginTransaction();
        try {
            DB::table('konfigurasi_jamkerja')->where('nuptk',$nuptk)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/guru')->with(['success'=> 'Jam Kerja Berhasil Di Update']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/guru')->with(['warning'=> 'Jam Kerja Gagal Di Update']);
        }
    }
}


