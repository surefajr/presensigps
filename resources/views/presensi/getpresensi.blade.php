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
@foreach ($presensi as $d)
    @php
        $foto_in = Storage::url('uploads/absensi/' . $d->foto_in);
        $foto_out = Storage::url('uploads/absensi/' . $d->foto_out);
    @endphp
    @if ($d->status == 'h')
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nuptk }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->jabatan }}</td>
            <td>{{ $d->nama_jam_kerja }}</td>
            <td>{{ $d->jam_in }}</td>
            <td>
                <img src="{{ url($foto_in) }}" class="avatar" alt="">
            </td>
            <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger" style="color: white;">Belum Absen</span>' !!}</td>
            <td>
                @if ($d->foto_out != null)
                    <img src="{{ url($foto_out) }}" class="avatar" alt="">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-high">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6.5 7h11" />
                        <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" />
                        <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
                    </svg>
                @endif

            </td>
            <td>{{ $d->status }}</td>
            <td>
                @if ($d->jam_in >= $d->jam_masuk)
                    @php
                        $jamterlambat = selisih($d->jam_masuk, $d->jam_in);
                    @endphp
                    <span class="badge bg-danger" style="color: white;">Terlambat {{ $jamterlambat }}</span>
                @else
                    <span class="badge bg-success" style="color: white;">Tepat Waktu</span>
                @endif
            </td>
            <td>
                <div class="d-flex">
                    <a href="" class="btn btn-primary btn-sm tampilkanpeta" id="{{ $d->id }}">
                        Peta
                    </a>
                    {{-- <a href="#" class="btn btn-warning btn-sm koreksipresensi">
                        Koreksi
                    </a> --}}
                </div>
            </td>
        </tr>
    @else
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nuptk }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->jabatan }}</td>
            <td>
                <span class="badge bg-danger" style="color: white">{{ $d->status }}</span>
            </td>
            <td>
                <span class="badge bg-danger" style="color: white">{{ $d->status }}</span>
            </td>
            <td>
                <span class="badge bg-danger" style="color: white">{{ $d->status }}</span>
            </td>
            <td>
                <span class="badge bg-danger" style="color: white">{{ $d->status }}</span>
            </td>
            <td>
                <span class="badge bg-danger" style="color: white">{{ $d->status }}</span>
            </td>
            <td>
                @if ($d->status == 'h')
                    <span class="badge bg-success" style="color: white">Hadir</span>
                @elseif($d->status == 'i')
                    <span class="badge bg-info" style="color: white">Izin</span>
                @elseif($d->status == 's')
                    <span class="badge bg-warning" style="color: white">Sakit</span>
                @elseif($d->status == 'c')
                    <span class="badge bg-danger" style="color: white">Cuti</span>
                @endif
            </td>
            <td>{{ $d->keterangan }}</td>
            {{-- <td>
                <a href="#" class="btn btn-warning btn-sm koreksipresensi">Koreksi</a>
            </td> --}}

        </tr>
    @endif
@endforeach




<script>
    $(function() {
        $(".tampilkanpeta").click(function(e) {
            e.preventDefault(); // Mencegah link mengarahkan ke URL "#" default
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond) {
                    $("#loadmap").html(respond);
                    $("#modal-tampilkanpeta").modal(
                        "show"); // Memanggil modal setelah konten dimuat
                }
            });
        });

        //  $(".koreksipresensi").click(function(e) {
        //      e.preventDefault();
        //      var nuptk = $(this).attr("nuptk");
        //      var tanggal = "{{ $tanggal }}";

        //      $.ajax({
        //          type: 'POST',
        //          url: '/koreksipresensi',
        //          data: {
        //              _token: "{{ csrf_token() }}",
        //              nuptk: nuptk,
        //              tanggal: tanggal
        //          },
        //          cache: false,
        //          success: function(respond) {
        //              $("#loadkoreksipresensi").html(respond);

        //          }
        //      });
        //      $("#modal-koreksipresensi").modal(
        //          "show");
        //  });
    });
</script>
