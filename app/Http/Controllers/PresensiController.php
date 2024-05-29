<?php

namespace App\Http\Controllers;
use App\Helpers\PointLocation;

use App\Models\Pengajuanizin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\dd;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function gethari()
    {
        $hari = date("D");

        switch ($hari){
            case 'Sun' :
                $hari_ini = 'Minggu';
                break;
            case 'Mon' :
                $hari_ini = 'Senin';
                break;
            case 'Tue' :
                $hari_ini = 'Selasa';
                break;
            case 'Wed' :
                $hari_ini = 'Rabu';
                break;
            case 'Thu' :
                $hari_ini = 'Kamis';
                break;
            case 'Fri' :
                $hari_ini = 'Jumat';
                break;
            case 'Sat' :
                $hari_ini = 'Sabtu';
                break;

            default:
                $hari_ini = 'Tidak Diketahui';
                break;
        }
            return $hari_ini;
    }
    public function create()
    {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensi = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik',$nik);
        $cek = $presensi->count();
        $datapresensi = $presensi->first();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id',1)->first();
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja','konfigurasi_jamkerja.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
            ->where('nik',$nik)->where('hari',$namahari)->first();


            if($datapresensi != null && $datapresensi->status != "h"){
                return view('presensi.notifizin');
            }else if($jamkerja == null){
                return view('presensi.notifjadwal');
            }else{
                return view('presensi.create', compact('cek','lok_kantor','jamkerja'));
            }

    }

    public function store(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id',1)->first();
        $lok = explode (",",$lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $namahari = $this->gethari();
        //cek jam kerja
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja','konfigurasi_jamkerja.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
            ->where('nik',$nik)->where('hari',$namahari)->first();

        $presensi = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik',$nik);
        $cek = $presensi->count();
        $datapresensi = $presensi->first();
        if($cek > 0 ){
            $ket ="out";
        }else{
            $ket ="in";
        }
        $image = $request->image;
        $folderPath ="public/uploads/absensi/";
        $formatName = $nik ."-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64",$image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;

        if($radius > $lok_kantor->radius){
            echo "maaf|anda berada diluar jangkauan,anda berada ".$radius." meter dari sekolah|";
        } else {

            if ($cek > 0) {
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf,belum saatnya melakukan absen pulang|out";
                } else if(!empty($datapresensi->jam_out)){
                    echo "error|Maaf,sebelumnya sudah melakukan absen pulang|out";
                }else {
                    $data_pulang = [
                    'jam_out'  => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                ];
                $update = DB::table('presensi')->where('tgl_presensi',$tgl_presensi)->where('nik',$nik)->update($data_pulang);
                if($update){
                    echo "success|Hati-Hati Dijalan|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Silahkan Hubungi IT|out";
                }
            }


            } else {
                if ($jam < $jamkerja->awal_jam_masuk)
                {
                    echo "error|Maaf gagal belum waktunya melakukan absen|in";
                } else if($jam > $jamkerja->akhir_jam_masuk){
                    echo "error|Maaf waktu untuk absen sudah habis|in";
                }else{
                    $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in'  => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                    'kode_jam_kerja' => $jamkerja->kode_jam_kerja,
                    'status' => 'h'
                    ];

                    $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo "success|Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Silahkan Hubungi IT|in";
                }

                }
            }
        }
    }

    // Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();

        return view ('presensi.editprofile',compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik',$nik)->first();
        $request -> validate([
            'foto' => 'image|mimes:png,jpg|max:5120'
        ]);
        if($request->hasFile('foto')){
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $karyawan->foto;
        }

        if(empty($request->password)){
            $data =[
                'nama_lengkap' => $nama_lengkap,
                'no_hp'=> $no_hp,
                'foto' => $foto
            ];
        }else{
            $data =[
                'nama_lengkap' => $nama_lengkap,
                'no_hp'=> $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('karyawan')->where ('nik',$nik)->update($data);
        if($update){
            if ($request->hasFile('foto')) {
                $folderPath ='public/uploads/karyawan/';
                $request->file('foto')->storeAs($folderPath,$foto);
            }
            return Redirect::back()->with(['success'=> 'Data berhasil Diperbarui']);
        }else{
            return Redirect::back()->with(['error'=> 'Data gagal Diperbarui']);
        }

    }

    public function histori(){
        $namabulan =
        ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view ('presensi.histori',compact('namabulan'));
    }

    public function gethistori(Request $request) {
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;
        $nik = Auth::guard('karyawan')->user()->nik;
    
        $histori = DB::table('presensi')
            ->select('presensi.*', 'keterangan', 'jam_kerja.*', 'doc_sid', 'nama_cuti')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
            ->leftJoin('master_cuti', 'pengajuan_izin.kode_cuti', '=', 'master_cuti.kode_cuti')
            ->where('presensi.nik', $nik)
            ->whereBetween('tgl_presensi', [$tanggal_mulai, $tanggal_selesai])
            ->orderBy('tgl_presensi')
            ->get();
    
        return view('presensi.gethistori', compact('histori'));
    }
    

    public function izin(Request $request)
{
    $nik = Auth::guard('karyawan')->user()->nik;

    if (!empty($request->tanggal_mulai) && !empty($request->tanggal_selesai)) {
        $dataizin = DB::table('pengajuan_izin')
            ->leftjoin('master_cuti', 'pengajuan_izin.kode_cuti', '=', 'master_cuti.kode_cuti')
            ->orderBy('tgl_izin_dari', 'desc')
            ->where('nik', $nik)
            ->whereBetween('tgl_izin_dari', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->get();
    } else {
        $dataizin = DB::table('pengajuan_izin')
            ->leftjoin('master_cuti', 'pengajuan_izin.kode_cuti', '=', 'master_cuti.kode_cuti')
            ->where('nik', $nik)
            ->orderBy('tgl_izin_dari', 'desc')
            ->limit(5)
            ->get();
    }

    $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    return view('presensi.izin', compact('dataizin', 'namabulan'));
}

    public function buatizin()
    {

        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data =[
            'nik'=> $nik,
            'tgl_izin'=> $tgl_izin,
            'status'=>$status,
            'keterangan'=> $keterangan
        ];
        $simpan = DB::table('pengajuan_izin')->insert($data);
        if($simpan){
            return redirect('/presensi/izin')->with(['success'=>'Data Berhasil di simpan']);
        }else{
            return redirect('/presensi/izin')->with(['error'=>'Data Gagal di simpan']);
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap','karyawan.jabatan','jam_masuk','nama_jam_kerja','jam_masuk','jam_pulang','keterangan')
        ->leftJoin('jam_kerja','presensi.kode_jam_kerja','=','jam_kerja.kode_jam_kerja')
        ->leftJoin('pengajuan_izin','presensi.kode_izin','=','pengajuan_izin.kode_izin')
        ->join('karyawan','presensi.nik','=','karyawan.nik')
        ->join('departemen','karyawan.kode_dept','=','departemen.kode_dept')
        ->where('tgl_presensi',$tanggal)
        ->get();

        return view('presensi.getpresensi',compact('presensi','tanggal'));
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id',$id)
        ->join('karyawan','presensi.nik','=','karyawan.nik')
        ->first();
        return view ('presensi.showmap',compact('presensi'));
    }

    public function laporan()
    {
        $namabulan =
        ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view ('presensi.laporan',compact('namabulan','karyawan'));
    }

    public function cetaklaporan(Request $request)
{
    $nik = $request->nik;
    $tanggal_mulai = $request->tanggal_mulai;
    $tanggal_selesai = $request->tanggal_selesai;
    $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    $karyawan = DB::table('karyawan')
        ->where('nik', $nik)
        ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        ->first();

    $presensi = DB::table('presensi')
        ->select('presensi.*', 'keterangan', 'jam_kerja.*')
        ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
        ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
        ->where('presensi.nik', $nik)
        ->whereBetween('tgl_presensi', [$tanggal_mulai, $tanggal_selesai])
        ->orderBy('tgl_presensi')
        ->get();

    if (isset($_POST['exportexcel'])) {
        $time = date("d-M-Y H:i:s");
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan Presensi $time.xls");
        return view('presensi.cetaklaporanexcel', compact('tanggal_mulai', 'tanggal_selesai', 'namabulan', 'karyawan', 'presensi'));
    }

    return view('presensi.cetaklaporan', compact('tanggal_mulai', 'tanggal_selesai', 'namabulan', 'karyawan', 'presensi'));
}


    public function rekap()
    {
        $namabulan =
        ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        return view ('presensi.rekap',compact('namabulan'));
    }

    public function cetakrekap(Request $request)
{
    $request->validate([
        'bulan' => 'required|numeric|between:1,12',
        'tahun' => 'required|numeric|min:2000',
        'jenis_laporan' => 'required|in:1,2'
    ]);

    $bulan = $request->bulan;
    $tahun = $request->tahun;
    $dari = $tahun . "-" . $bulan . "-01";
    $sampai = date("Y-m-t", strtotime($dari));
    $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    $datalibur = getkaryawanlibur($dari, $sampai);
    $harilibur = DB::table('harilibur')->whereBetween('tanggal_libur', [$dari, $sampai])->get();

    $select_date = "";
    $field_date = "";
    $i = 1;
    $rangetanggal = [];
    
    while (strtotime($dari) <= strtotime($sampai)) {
        $rangetanggal[] = $dari;
        $select_date .= "MAX(IF(tgl_presensi = '$dari', CONCAT(
            IFNULL(jam_in, 'NA'), '|',
            IFNULL(jam_out, 'NA'), '|',
            IFNULL(presensi.status, 'NA'), '|',
            IFNULL(nama_jam_kerja, 'NA'), '|',
            IFNULL(jam_masuk, 'NA'), '|',
            IFNULL(jam_pulang, 'NA'), '|',
            IFNULL(presensi.kode_izin, 'NA'), '|',
            IFNULL(keterangan, 'NA'), '|',
            IFNULL(total_jam, 'NA')
        ), NULL)) AS tgl_" . $i . ",";
        $field_date .= "tgl_" . $i . ",";
        $i++;
        $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
    }

    $jmlhari = count($rangetanggal);
    $lastrange = $jmlhari - 1;
    $sampai = $rangetanggal[$lastrange];
    if ($jmlhari == 30) {
        array_push($rangetanggal, NULL);
    } elseif ($jmlhari == 29) {
        array_push($rangetanggal, NULL, NULL);
    } elseif ($jmlhari == 28) {
        array_push($rangetanggal, NULL, NULL, NULL);
    }

    $query = Karyawan::query();
    $query->selectRaw(
        "$field_date karyawan.nik, nama_lengkap, jabatan"
    );

    $query->leftJoin(DB::raw("
        (
            SELECT
            $select_date
            presensi.nik
            FROM presensi
            LEFT JOIN jam_kerja ON presensi.kode_jam_kerja = jam_kerja.kode_jam_kerja
            LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
            WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
            GROUP BY nik
        ) presensi
    "), function($join) {
        $join->on('karyawan.nik', '=', 'presensi.nik');
    });

    $query->orderBy('nama_lengkap');
    $rekap = $query->get();

    if ($request->has('exportexcel')) {
        $time = date("d-M-Y H:i:s");
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Rekap Presensi $time.xls");
        return view('presensi.cetakrekapexcel', compact('bulan', 'tahun', 'namabulan', 'rekap'));
    }

    $data = compact('bulan', 'tahun', 'namabulan', 'rekap', 'rangetanggal', 'jmlhari', 'datalibur', 'harilibur');
    
    if ($request->jenis_laporan == 1) {
        return view('presensi.cetakrekap', $data);
    } elseif ($request->jenis_laporan == 2) {
        return view('presensi.cetakrekapdetail', $data);
    }
}



    public function izinsakit(Request $request)
    {
        $query = Pengajuanizin::query();
        $query->select('kode_izin', 'tgl_izin_dari','tgl_izin_sampai', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status','doc_sid', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin_dari', [$request->dari, $request->sampai]);
        }

        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }

        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->status_approved === '0' ||$request->status_approved === '1' ||$request->status_approved === '2') {
            $query->where('status_approved', $request->status_approved);
        }

        $query->orderBy('tgl_izin_dari', 'desc');
        $izinsakit = $query->paginate(5);
        $izinsakit ->appends($request->all());
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $kode_izin = $request->kode_izin_form;
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        $nik = $dataizin->nik;
        $tgl_dari = $dataizin->tgl_izin_dari;
        $tgl_sampai = $dataizin->tgl_izin_sampai;
        $status = $dataizin->status;
        DB::beginTransaction();
        try {
            if($status_approved == 1){
                while(strtotime($tgl_dari)<=strtotime ($tgl_sampai)){
                    DB::table('presensi')->insert([
                        'nik' =>$nik,
                        'tgl_presensi'=>$tgl_dari,
                        'status'=>$status,
                        'kode_izin' =>$kode_izin
                    ]);
                    $tgl_dari = date("Y-m-d",strtotime("+1 days",strtotime($tgl_dari)));
                }
            }

            DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->update([
                'status_approved' => $status_approved
            ]);
            DB::commit();
            return redirect::back()->with(['success'=>'Data Izin Berhasil Di Proses']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect::back()->with(['warning'=>'Data Izin Gagal Di Proses']);
        }
    }

    public function batalkanizinsakit($kode_izin)
    {
        DB::beginTransaction();
        try {
            DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->update([
                'status_approved' => 0
            ]);
            DB::table('presensi')->where('kode_izin',$kode_izin)->delete();
            DB::commit();
            return redirect::back()->with(['success'=>'Data Izin Berhasil Di Batalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect::back()->with(['warning'=>'Data Izin Gagal Di Batalkan']);
        }
    }


    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_izin')->where('nik',$nik)->where('tgl_izin',$tgl_izin)->count();
        return $cek;
    }

    public function showact($kode_izin )
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        return view('presensi.showact',compact('dataizin'));
    }

    public function deleteizin($kode_izin)
    {
        $cekdataizin = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->first();
        $doc_sid = $cekdataizin->doc_sid;

        try {
            DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->delete();
            if ($doc_sid != null) {
                Storage::delete('/public/uploads/sid/'.$doc_sid);
            }
            return redirect('/presensi/izin')->with(['success' =>'Data Izin Berhasil Di Hapus ']);
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with(['error' =>'Data Izin Gagal Di Hapus ']);
        }
    }

//    public function koreksipresensi(Request $request)
//    {
//    $nik = $request->nik;
//    $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
//    $tanggal = $request->tanggal;
//    $jamkerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
//    return view('presensi.koreksipresensi', compact('karyawan', 'tanggal','jamkerja'));
//    }

//    public function storekoreksipresensi (Request $request)
//    {
//        $nik = $request->nik;
//        $tanggal = $request->tanggal;
//        $jam_in = $request->jam_in;
//        $jam_out = $request->jam_out;
//        $kode_jam_kerja = $request->kode_jam_kerja;
//        $status = $request->status;

//        try {
//            DB::table('presensi')->insert([
//                'nik' => $nik,
//                'tgl_presensi' => $tanggal,
//                'jam_in' => $jam_in,
//                'jam_out' => $jam_out,
//                'kode_jam_kerja' => $kode_jam_kerja,
//                'status' => $status
//            ]);
//            return Redirect::back()->with(['success' => 'Data Presensi Berhasil Disimpan!']);
//        } catch (\Exception $e) {
//            return Redirect::back()->with(['warning' => 'Data Presensi Gagal Disimpan!']);
//        }
//    }

}

