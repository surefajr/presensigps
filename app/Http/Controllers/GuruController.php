<?php

namespace App\Http\Controllers;


use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\dd;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;



class GuruController extends Controller
{
    public function index(Request $request)
{
    $query = Guru::query();
    $query->select('guru.*');
    // Menghapus join ke tabel departemen dan kolom kode_dept
    $query->orderBy('nama_lengkap');
    
    if (!empty($request->nama_guru)) {
        $query->where('nama_lengkap', 'like', '%' . $request->nama_guru . '%');
    }

    

    $guru = $query->paginate(4);

   
    return view('guru.index', compact('guru'));
}


public function store(Request $request)
{
    $nuptk = $request->nuptk;
    $username = $request->username;
    $nama_lengkap = $request->nama_lengkap;
    $jabatan = $request->jabatan;
    $no_hp = $request->no_hp;
    $defaultPassword = '234'; // Password default
    
    // Tidak menggunakan hashing untuk password
    $password = $defaultPassword;

    if ($request->hasFile('foto')) {
        $foto = $nuptk . "." . $request->file('foto')->getClientOriginalExtension();
    } else {
        $foto = null;
    }

    $cekusername = DB::table('guru')->where('username', $username)->count();
    if ($cekusername > 0) {
        return Redirect::back()->with(['warning' => 'Username ' . $username . ' sudah digunakan.']);
    }

    try {
        $data = [
            'nuptk' => $nuptk,
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
            'no_hp' => $no_hp,
            'foto' => $foto ?: '',
            'password' => $password
        ];

        $simpan = DB::table('guru')->insert($data);

        if ($simpan) {
            if ($request->hasFile('foto')) {
                $folderPath = 'public/uploads/guru/';
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        }
    } catch (\Exception $e) {
        if ($e->getCode() == 23000) {
            $message = "Data dengan NUPTK " . $nuptk . " sudah ada";
        } else {
            $message = "username lebih dari 15 karakter";
        }
        return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $message]);
    }
}


    public function edit (Request $request)
    {
        $nuptk = $request->nuptk;
        
        $guru = DB::table('guru')->where('nuptk',$nuptk)->first();
        return view ('guru.edit',compact('guru'));
    }

    public function update($nuptk, Request $request)
{
    $nuptk_baru = $request->nuptk_baru;
    $username_baru = $request->username_baru;
    $nama_lengkap = $request->nama_lengkap;
    $jabatan = $request->jabatan;
    $no_hp = $request->no_hp;
    $password = $request->password; // Mengambil password dari request
    $old_foto = $request->old_foto;
    $foto = $old_foto; // Default value untuk $foto

    if ($request->hasFile('foto')) {
        $foto = $nuptk . "." . $request->file('foto')->getClientOriginalExtension();
    }

    // Periksa apakah NUPTK baru sudah digunakan selain pada baris yang sedang diupdate
    $ceknuptk = DB::table('guru')->where('nuptk', $nuptk_baru)->where('nuptk', '!=', $nuptk)->count();
    if ($ceknuptk > 0) {
        return Redirect::back()->with(['warning' => 'NUPTK sudah digunakan.']);
    }

    $cekusername = DB::table('guru')->where('username', $username_baru)->where('nuptk', '!=', $nuptk)->count();
    if ($cekusername > 0) {
        return Redirect::back()->with(['warning' => 'Username sudah digunakan.']);
    }

    try {
        $data = [
            'nuptk' => $nuptk_baru,
            'username' => $username_baru,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
            'no_hp' => $no_hp,
            'foto' => $foto ?: ''
        ];

        // Tambahkan password ke data hanya jika diisi dalam request
        if (!empty($password)) {
            $data['password'] = $password;
        }

        $update = DB::table('guru')->where('nuptk', $nuptk)->update($data);

        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = 'public/uploads/guru/';
                $folderPathOld = 'public/uploads/guru/' . $old_foto;
                Storage::delete($folderPathOld);
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }
    } catch (\Exception $e) {
        return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
    }
}




public function delete($nuptk)
{
    DB::beginTransaction();

    try {
        // Hapus baris terkait di tabel presensi
        DB::table('presensi')->where('nuptk', $nuptk)->delete();

        // Hapus baris terkait di tabel konfigurasi_jamkerja
        DB::table('konfigurasi_jamkerja')->where('nuptk', $nuptk)->delete();
        
        // Hapus baris terkait di tabel pengajuan_izin
        DB::table('pengajuan_izin')->where('nuptk', $nuptk)->delete();

        // Hapus data di tabel guru
        $delete = DB::table('guru')->where('nuptk', $nuptk)->delete();

        DB::commit();

        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        return Redirect::back()->with(['warning' => 'Data Gagal Dihapus: ' . $e->getMessage()]);
    }
}



public function resetpassword($nuptk)
{
    // Tidak perlu mendekripsi NUPTK
    $password = '234'; // Password default tanpa hashing
    $reset = DB::table('guru')->where('nuptk', $nuptk)->update([
        'password' => $password
    ]);

    if ($reset) {
        return Redirect::back()->with(['success' => 'Password Berhasil Di Reset']);
    } else {
        return Redirect::back()->with(['warning' => 'Password Gagal Di Reset']);
    }
}

    
}
