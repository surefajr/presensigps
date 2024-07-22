<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Rekap</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #tittle {
            font-family: 'Times New Roman';
            font-size: 15px;
            font-weight: bold;
        }

        .tabeldataguru {
            margin-top: 40px;
        }

        .tabeldataguru tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
            font-size: 10px;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 8px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }

        body.A4.landscape .sheet {
            width: 300mm !important;
            height: auto !important;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width:100%">
            <tr>
                <td style="width:30px">
                    <img src="{{ asset('assets/img/smk.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="tittle">
                        Rekap Kehadiran Guru<br>
                        Periode {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        SMK DHARMA SISWA TANGERANG<br>
                    </span>
                    <span>Jl. Teuku Umar No.76, RT.001/RW.001, Nusa Jaya, Kec. Karawaci, Kota Tangerang, Banten
                        15115</span>
                </td>
            </tr>
        </table>
        <div class="table-responsive">
            <table class="tabelpresensi">
                <tr>
                    <th rowspan="2">NUPTK</th>
                    <th rowspan="2">Nama Guru</th>
                    <th colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                    <th rowspan="2">H</th>
                    <th rowspan="2">I</th>
                    <th rowspan="2">S</th>
                    <th rowspan="2">C</th>
                    <th rowspan="2">L</th>
                    <th rowspan="2">A</th>
                </tr>
                <tr>
                    @foreach ($rangetanggal as $d)
                        @if ($d != null)
                            <th>{{ date('d', strtotime($d)) }}</th>
                        @endif
                    @endforeach
                </tr>
                @foreach ($rekap as $r)
                    <tr>
                        <td>{{ $r->nuptk }}</td>
                        <td>{{ $r->nama_lengkap }}</td>
                        <?php
                    $jml_hadir = 0;
                    $jml_izin = 0;
                    $jml_sakit = 0;
                    $jml_cuti = 0;
                    $jml_libur = 0;
                    $jml_alpa = 0;
                    for ($i=1; $i <=$jmlhari ; $i++) {
                        $tgl ="tgl_".$i;
                        $tgl_presensi = $rangetanggal[$i-1];
                        $search_items = [
                        'nuptk' => $r->nuptk,
                        'tanggal_libur' => $tgl_presensi
                    ];
                        $ceklibur = cekgurulibur($datalibur,$search_items);
                        $datapresensi = explode("|",$r->$tgl);
                        if ($r->$tgl != NULL) {
                            $status = $datapresensi[2];
                        }else {
                            $status ="";
                        }
                        $cekhari = gethari(date('D',strtotime($tgl_presensi)));
                        if ($status == "h") {
                            $jml_hadir += 1;
                            $color = "white";
                        }
                        if ($status == "i") {
                            $jml_izin += 1;
                            $color = "white";
                        }
                        if ($status == "s") {
                            $jml_sakit += 1;
                            $color = "white";
                        }
                        if ($status == "c") {
                            $jml_cuti += 1;
                            $color = "white";
                        }
                        if ($status == "l") {
                            $jml_libur += 1;
                            $color = "white";
                        }
                        if (empty($status)&& empty($ceklibur) && $cekhari != "Minggu") {
                            $jml_alpa += 1;
                            $color = "white";
                        }

                        if (!empty($ceklibur)) {
                            $color = "red";
                        }
                        if ($cekhari == "Minggu") {
                            $color = "red";
                        }
                    ?>
                        <td style="background-color: {{ $color }};">
                            {{ $status }}

                        </td>
                        <?php
                    }
                     ?>
                        <td>{{ !empty($jml_hadir) ? $jml_hadir : '' }}</td>
                        <td>{{ !empty($jml_izin) ? $jml_izin : '' }}</td>
                        <td>{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                        <td>{{ !empty($jml_cuti) ? $jml_cuti : '' }}</td>
                        <td>{{ !empty($jml_libur) ? $jml_libur : '' }}</td>
                        <td>{{ !empty($jml_alpa) ? $jml_alpa : '' }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
        <h4>Keterangan Libur : </h4>
        <ol>
            @foreach ($harilibur as $d)
                <li>{{ date('d-m-Y', strtotime($d->tanggal_libur)) }} - {{ $d->keterangan }}</li>
            @endforeach
        </ol>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align:right">
                    <?php
                    // Mendapatkan tanggal saat ini
                    $tanggal = date('d');
                    
                    // Mendapatkan nama bulan dalam Bahasa Indonesia
                    $nama_bulan = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                    
                    // Mendapatkan bulan saat ini
                    $bulan = date('n');
                    
                    // Mendapatkan tahun saat ini
                    $tahun = date('Y');
                    
                    // Menampilkan tanggal dengan nama bulan dan tahun
                    echo 'Tangerang, ' . $tanggal . ' ' . $nama_bulan[$bulan] . ' ' . $tahun;
                    ?>
                    <br>
                    <b>Kepala Sekolah</b>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right" height="200px">
                    <u>Sari Lestari Nasution, S.pd</u><br>
                    NIP

                </td>
            </tr>
        </table>

    </section>
</body>

</html>
