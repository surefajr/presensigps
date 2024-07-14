<?php



function hitungjamterlambat($jadwal_jam_masuk, $jam_presensi)
{
   $j1 = strtotime($jadwal_jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat  = floor($diffterlambat / ( 60 * 60 ));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $terlambat = $jterlambat . ":" . $mterlambat;
    return $terlambat;
}

function hitungjamterlambatdesimal($jadwal_jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jadwal_jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat  = floor($diffterlambat / ( 60 * 60 ));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $desimalterlambat = $jamterlambat + ROUND(($menitterlambat / 60), 2);
    return $desimalterlambat;
}

function hitunghari($tanggal_mulai,$tanggal_akhir)
{

 $tanggal1 = date_create($tanggal_mulai);
 $tanggal2 = date_create($tanggal_akhir);
 $diff = date_diff( $tanggal1, $tanggal2 );

 return $diff->days + 1;
}

function buatkode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
{
    /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
    string nomor baru dibawah ini harus dengan format XXX000000
    untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
    //    menyusun kunci dan nomor baru
    $kode = $kunci . $nomor_baru_plus_nol;
    return $kode;
}

function hitungjamkerja($jam_masuk, $jam_pulang)
{
    if (empty($jam_pulang) || empty($jam_masuk)) {
        return "0:0";
    }

    $j_masuk = strtotime($jam_masuk);
    $j_pulang = strtotime($jam_pulang);
    $diff = $j_pulang - $j_masuk;
    $jam = floor($diff / (60 * 60));
    $m = $diff - $jam * (60 * 60);
    $menit = floor($m / 60);

   // $jam = $jam > $max_total_jam ? $max_total_jam : $jam;
    // $menitdesimal = ROUND($menit / 60,2);
    // $jamdesimal =$jam + $menitdesimal;
    return $jam . ":" . $menit ;
}


function getgurulibur($dari,$sampai)
{
    $datalibur = DB::table('harilibur_detail')
    ->join('harilibur','harilibur_detail.kode_libur','=','harilibur.kode_libur')
    ->whereBetween('tanggal_libur',[$dari,$sampai])
    ->get();

    $gurulibur = [];
    foreach ($datalibur as $d){
        $gurulibur[] = [
            'nuptk' => $d->nuptk,
            'tanggal_libur' => $d->tanggal_libur,
            'keterangan' => $d->keterangan,
        ];
    }
    return $gurulibur;
}
function cekgurulibur ($array,$search_list)
{
    $result  =array();

    foreach ($array as $key => $value) {
       foreach ($search_list as $k => $v){
        if(!isset($value[$k]) || $value[$k] != $v){
            continue 2;
        }
       }
       $result[] = $value;
    }
    return $result;
}
function gethari($hari)
{
    switch ($hari){
        case 'Sun' :
            return 'Minggu';
        case 'Mon' :
            return 'Senin';
        case 'Tue' :
            return 'Selasa';
        case 'Wed' :
            return 'Rabu';
        case 'Thu' :
            return 'Kamis';
        case 'Fri' :
            return 'Jumat';
        case 'Sat' :
            return 'Sabtu';
        default:
            return 'Tidak Diketahui';
    }
}


 