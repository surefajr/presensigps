<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Rekap Detail Excel</title>
    <style>
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
    </style>
</head>

<body class="A4 landscape">
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
                    for ($i = 1; $i <= $jmlhari; $i++) {
                        $tgl = "tgl_" . $i;
                        $tgl_presensi = $rangetanggal[$i - 1];
                        $search_items = [
                            'nuptk' => $r->nuptk,
                            'tanggal_libur' => $tgl_presensi
                        ];
                        $ceklibur = cekgurulibur($datalibur, $search_items);
                        $datapresensi = explode("|", $r->$tgl);
                        if ($r->$tgl != null) {
                            $status = $datapresensi[2];
                            $jam_in = $datapresensi[0] != "NA" ? date("H:i", strtotime($datapresensi[0])) : '';
                            $jam_out = $datapresensi[1] != "NA" ? date("H:i", strtotime($datapresensi[1])) : '';
                            $jam_masuk = $datapresensi[4] != "NA" ? date("H:i", strtotime($datapresensi[4])) : '';
                            $jam_pulang = $datapresensi[5] != "NA" ? date("H:i", strtotime($datapresensi[5])) : '';
                            $nama_jam_kerja = $datapresensi[3] != "NA" ? $datapresensi[3] : '';
                            if ($jam_in != "NA" && $jam_out != "NA") {
                                $total_jam_kerja = hitungjamkerja($jam_in, $jam_out);
                            } else {
                                $total_jam_kerja = 0;
                            }
                        } else {
                            $status = "";
                            $jam_in = "";
                            $jam_out = "";
                            $jam_masuk = "";
                            $jam_pulang = "";
                            $nama_jam_kerja = "";
                            $total_jam_kerja = 0;
                        }
                        // Menambahkan kode izin ke dalam variabel
                        $kode_izin = '';
                        if ($status == 'i') {
                            $kode_izin = 'I';
                        } elseif ($status == 's') {
                            $kode_izin = 'S';
                        } elseif ($status == 'c') {
                            $kode_izin = 'C';
                        }elseif ($status == 'l') {
                            $kode_izin = 'LIBUR';
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

                        if (empty($status) && empty($ceklibur) && $cekhari != "Minggu") {
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
                        <!-- Menampilkan kode izin -->
                        {{ $kode_izin }}
                        @if ($status == 'h')
                            <span style="font-weight: bold">{{ $nama_jam_kerja }}</span><br>
                            <span style="color : green">{{ $jam_masuk }} - {{ $jam_pulang }}</span><br>
                            {{ $jam_in }} - {{ $jam_out }}<br>
                            Total Jam: {{ $total_jam_kerja }}
                        @endif
                    </td>
                    <?php
                    }
                    ?>
                    <td>{{ $jml_hadir ?: '' }}</td>
                    <td>{{ $jml_izin ?: '' }}</td>
                    <td>{{ $jml_sakit ?: '' }}</td>
                    <td>{{ $jml_cuti ?: '' }}</td>
                    <td>{{ $jml_libur ?: '' }}</td>
                    <td>{{ $jml_alpa ?: '' }}</td>
                </tr>
            @endforeach
        </table>
        <h4>Keterangan Libur:</h4>
        <ol>
            @foreach ($harilibur as $d)
                <li>{{ date('d-m-Y', strtotime($d->tanggal_libur)) }} - {{ $d->keterangan }}</li>
            @endforeach
        </ol>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align:right">
                    <?php
                    $tanggal = date('d');
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
                    $bulan = date('n');
                    $tahun = date('Y');
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
