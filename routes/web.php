<?php
use App\Models\User;
use App\Models\Harilibur;


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\IzinabsenController;
use App\Http\Controllers\IzinsakitController;
use App\Http\Controllers\IzincutiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HariliburController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::middleware(['guest:karyawan'])->group(function (){
    Route::get('/', function () {
        return view('auth.login');
    }) ->name('login');
    Route::post('/proseslogin', [AuthController::class,'proseslogin']);
});

Route::middleware(['guest:user'])->group(function (){
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    }) ->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class,'prosesloginadmin']);
});

Route::middleware(['auth:karyawan'])->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/proseslogout',[AuthController::class,'proseslogout']);

    //presensi
    Route::get('/presensi/create',[PresensiController::class,'create']);
    Route::post('/presensi/store',[PresensiController::class,'store']);

    //Edit Profile
    Route::get('/editprofile',[PresensiController::class,'editprofile']);
    Route::post('/presensi/{nik}/updateprofile',[PresensiController::class,'updateprofile']);

    //histori
    Route::get('/presensi/histori',[PresensiController::class,'histori']);
    Route::post('/gethistori',[PresensiController::class,'gethistori']);

    //Izin
    Route::get('/presensi/izin',[PresensiController::class,'izin']);
    Route::get('/presensi/buatizin',[PresensiController::class,'buatizin']);
    Route::post('/presensi/storeizin',[PresensiController::class,'storeizin']);
    Route::post('/presensi/cekpengajuanizin',[PresensiController::class,'cekpengajuanizin']);

    //Izin Absen
    Route::get('/izinabsen',[IzinabsenController::class,'create']);
    Route::post('/izinabsen/store',[IzinabsenController::class,'store']);
    Route::get('/izinabsen/{kode_izin}/edit',[IzinabsenController::class,'edit']);
    Route::post('/izinabsen/{kode_izin}/update',[IzinabsenController::class,'update']);

    //Izin Sakit
    Route::get('/izinsakit',[IzinsakitController::class,'create']);
    Route::post('/izinsakit/store',[IzinsakitController::class,'store']);
    Route::get('/izinsakit/{kode_izin}/edit',[IzinsakitController::class,'edit']);
    Route::post('/izinsakit/{kode_izin}/update',[IzinsakitController::class,'update']);


    //Izin Cuti
    Route::get('/izincuti',[IzincutiController::class,'create']);
    Route::post('/izincuti/store',[IzincutiController::class,'store']);
    Route::get('/izincuti/{kode_izin}/edit',[IzincutiController::class,'edit']);
    Route::post('/izincuti/{kode_izin}/update',[IzincutiController::class,'update']);
    Route::post('/izincuti/getmaxcuti',[IzincutiController::class,'getmaxcuti']);


    Route::get('/izin/{kode_izin}/showact',[PresensiController::class,'showact']);
    Route::get('/izin/{kode_izin}/delete',[PresensiController::class,'deleteizin']);


});
//Route yang bisa di akses oleh admin dan admin 2
Route::group(['middleware' => ['role:administator|administator 2,user']], function () {
    Route::get('/proseslogoutadmin',[AuthController::class,'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin',[DashboardController::class,'dashboardadmin']);

    //karyawan
    Route::get('/karyawan',[KaryawanController::class,'index']);
    Route::post('/karyawan/store',[KaryawanController::class,'store']);
    Route::post('/karyawan/edit',[KaryawanController::class,'edit']);
    Route::post('/karyawan/{nik}/update',[KaryawanController::class,'update']);
    Route::post('/karyawan/{nik}/delete',[KaryawanController::class,'delete']);
    Route::get('/karyawan/{nik}/resetpassword',[KaryawanController::class,'resetpassword']);

    //Departemen
    Route::get('/departemen',[DepartemenController::class,'index']);
    Route::post('/departemen/store',[DepartemenController::class,'store']);
    Route::post('/departemen/edit',[DepartemenController::class,'edit']);
    Route::post('/departemen/{kode_dept}/update',[DepartemenController::class,'update']);
    Route::post('/departemen/{kode_dept}/delete',[DepartemenController::class,'delete']);

    //Presensi
    Route::get('/presensi/monitoring',[PresensiController::class,'monitoring']);
    Route::post('/getpresensi',[PresensiController::class,'getpresensi']);
    Route::post('/tampilkanpeta',[PresensiController::class,'tampilkanpeta']);
    Route::get('/presensi/laporan',[PresensiController::class,'laporan']);
    Route::post('/presensi/cetaklaporan',[PresensiController::class,'cetaklaporan']);
    Route::get('/presensi/rekap',[PresensiController::class,'rekap']);
    Route::post('/presensi/cetakrekap',[PresensiController::class,'cetakrekap']);
    Route::get('/presensi/izinsakit',[PresensiController::class,'izinsakit']);
    Route::post('/presensi/approveizinsakit',[PresensiController::class,'approveizinsakit']);
    Route::get('/presensi/{kode_izin}/batalkanizinsakit',[PresensiController::class,'batalkanizinsakit']);

  //  Route::post('/koreksipresensi',[PresensiController::class,'koreksipresensi']);
  //  Route::post('/storekoreksipresensi',[PresensiController::class,'storekoreksipresensi']);


    //Konfigurasi
    Route::get('/konfigurasi/lokasikantor',[KonfigurasiController::class,'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor',[KonfigurasiController::class,'updatelokasikantor']);
    Route::get('/konfigurasi/jamkerja',[KonfigurasiController::class,'jamkerja']);
    Route::post('/konfigurasi/storejamkerja',[KonfigurasiController::class,'storejamkerja']);
    Route::post('/konfigurasi/editjamkerja',[KonfigurasiController::class,'editjamkerja']);
    Route::post('/konfigurasi/updatejamkerja',[KonfigurasiController::class,'updatejamkerja']);
    Route::post('/konfigurasi/{kode_jam_kerja}/delete',[KonfigurasiController::class,'deletejamkerja']);
    Route::get('/konfigurasi/{nik}/setjamkerja',[KonfigurasiController::class,'setjamkerja']);
    Route::post('/konfigurasi/storesetjamkerja',[KonfigurasiController::class,'storesetjamkerja']);
    Route::post('/konfigurasi/updatesetjamkerja',[KonfigurasiController::class,'updatesetjamkerja']);

    //Admim
    Route::get('/konfigurasi/users',[UserController::class,'index']);
    Route::post('/konfigurasi/users/store',[UserController::class,'store']);
    Route::post('/konfigurasi/users/edit',[UserController::class,'edit']);
    Route::post('/konfigurasi/users/{id_user}/update',[UserController::class,'update']);
    Route::post('/konfigurasi/users/{id_user}/delete',[UserController::class,'delete']);

     //Hari Libur
     Route::get('/konfigurasi/harilibur',[HariliburController::class,'index']);
     Route::get('/konfigurasi/harilibur/create',[HariliburController::class,'create']);
     Route::post('/konfigurasi/harilibur/store',[HariliburController::class,'store']);
     Route::post('/konfigurasi/harilibur/edit',[HariliburController::class,'edit']);
     Route::post('/konfigurasi/harilibur/{kode_libur}/update',[HariliburController::class,'update']);
     Route::post('/konfigurasi/harilibur/{kode_libur}/delete',[HariliburController::class,'delete']);
     Route::get('/konfigurasi/harilibur/{kode_libur}/setkaryawanlibur',[HariliburController::class,'setkaryawanlibur']);
     Route::get('/konfigurasi/harilibur/{kode_libur}/setlistkaryawanlibur',[HariliburController::class,'setlistkaryawanlibur']);
     Route::get('/konfigurasi/harilibur/{kode_libur}/getsetlistkaryawanlibur',[HariliburController::class,'getsetlistkaryawanlibur']);
     Route::post('/konfigurasi/harilibur/storekaryawanlibur',[HariliburController::class,'storekaryawanlibur']);
     Route::post('/konfigurasi/harilibur/batalkanliburkaryawan',[HariliburController::class,'batalkanliburkaryawan']);
     Route::get('/konfigurasi/harilibur/{kode_libur}/getkaryawanlibur',[HariliburController::class,'getkaryawanlibur']);




    //Cuti
    Route::get('/cuti',[CutiController::class,'index']);
    Route::post('/cuti/store',[CutiController::class,'store']);
    Route::post('/cuti/edit',[CutiController::class,'edit']);
    Route::post('/cuti/{kode_cuti}/update',[CutiController::class,'update']);
    Route::post('/cuti/{kode_cuti}/delete',[CutiController::class,'delete']);



});


//Route yang hanya bisa di akses oleh admin
//Route::group(['middleware' => ['role:administator,user']], function () {


        //karyawan





   // });

    Route::get('/createrolepermission',function(){
        try {
            Role::create(['name' => 'administator 2']);
            //Permission::create(['name' => 'view-karyawan']);
            //Permission::create(['name' => 'view-departemen']);
            echo "Sukses";
        } catch (\Exception $e) {
            echo "Error!";
        }
    });

    Route::get('/give-user-role',function(){
        try {
           $user = User::findorfail(1);
           $user->assignRole('administator');
            echo "Berhasil";
        } catch (\Exception $e) {
            echo "Error!";
        }
    });

    Route::get('/give-role-permission',function(){
        try {
           $role = Role::findorfail(1);
           $role->givePermissionTo('view-departemen');
            echo "YAHUUD";
        } catch (\Exception $e) {
            echo "Error!";
        }
    });

