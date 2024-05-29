<?php

namespace App\Http\Controllers;


use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\dd;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;



class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->select('karyawan.*','nama_dept');
        $query->join('departemen','karyawan.kode_dept','=','departemen.kode_dept');
        $query ->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
           $query->where('nama_lengkap','like','%'.$request->nama_karyawan.'%');
        }

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept',$request->kode_dept);
         }
        $karyawan = $query->paginate(4);

        $departemen = DB::table('departemen')->get();
        return view('karyawan.index',compact('karyawan','departemen'));
    }

    public function store (Request $request)
    {
        //$nik = ($nik);
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('234');
        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        }

        try {
           $data = [
            'nik'=>$nik,
            'nama_lengkap'=>$nama_lengkap,
            'jabatan'=>$jabatan,
            'no_hp'=>$no_hp,
            'kode_dept'=>$kode_dept,
            'foto' => $foto ?: '',
            'password' =>$password
           ];
           $simpan = DB::table('karyawan')->insert($data);
           if($simpan){
            if ($request->hasFile('foto')) {
                $folderPath ='public/uploads/karyawan/';
                $request->file('foto')->storeAs($folderPath,$foto);
            }
            return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
        }
        } catch (\Exception $e) {
          //  dd($e);
            if($e->getCode() == 23000){
                $message = "Data dengan NIK " . $nik . "sudah ada";
            }else{
                $message = "NIK lebih dari 15";
            }
            return Redirect::back()->with(['warning'=>'Data Gagal Disimpan ' . $message]);
        }
    }

    public function edit (Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
        return view ('karyawan.edit',compact('departemen','karyawan'));
    }

    public function update ($nik, Request $request)
{
    $nik_baru = $request->nik_baru;
    $nama_lengkap = $request->nama_lengkap;
    $jabatan = $request->jabatan;
    $no_hp = $request->no_hp;
    $kode_dept = $request->kode_dept;
    $password = Hash::make('234');
    $old_foto = $request->old_foto;
    $foto = $old_foto; // Default value untuk $foto

    if ($request->hasFile('foto')) {
        $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
    }

    // Periksa apakah NIK baru sudah digunakan selain pada baris yang sedang diupdate
    $ceknik = DB::table('karyawan')->where('nik', $nik_baru)->where('nik', '!=', $nik)->count();
    if ($ceknik > 0) {
        return Redirect::back()->with(['warning'=>'NIK sudah digunakan.']);
    }

    try {
        $data = [
            'nik' => $nik_baru,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
            'no_hp' => $no_hp,
            'kode_dept' => $kode_dept,
            'foto' => $foto ?: '',
            'password' => $password
        ];
        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath ='public/uploads/karyawan/';
                $folderPathOld ="public/uploads/karyawan/".$old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath,$foto);
            }
            return Redirect::back()->with(['success'=>'Data Berhasil Di Update']);
        }
    } catch (\Exception $e) {
        return Redirect::back()->with(['warning'=>'Data Gagal Di Update']);
    }
}



    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik',$nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success'=>'Data Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning'=>'Data Gagal Di Hapus']);
        }
    }

    public function resetpassword($nik)
    {
        $nik = Crypt::decrypt($nik);
        $password = Hash::make('234');
        $reset = DB::table('karyawan')->where('nik',$nik)->update([
         'password' => $password
        ]);
        if($reset){
            return Redirect::back()->with(['success'=>'Password Berhasil Di Reset']);
        }else{
            return Redirect::back()->with(['warning'=>'Password Gagal Di Reset']);
        }
    }
}
