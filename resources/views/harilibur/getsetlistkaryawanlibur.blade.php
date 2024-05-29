@foreach ($karyawan as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->jabatan }}</td>
        <td>
            @if (!empty($d->ceknik))
                <a href="#" class="btn btn-danger btn-sm batalkanlibur" nik="{{ $d->nik }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </a>
            @else
                <a href="#" class="btn btn-success btn-sm tambahkaryawan" nik="{{ $d->nik }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                </a>
            @endif

        </td>
    </tr>
@endforeach
<script>
    $(function() {
        // Fungsi untuk memuat daftar karyawan libur
        function loadkaryawanlibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur + '/getkaryawanlibur');
        }

        // Fungsi untuk memuat daftar karyawan libur dan setelah itu menambahkan event listener ke tombol batalkanlibur
        function loadsetlistkaryawanlibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadsetlistkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur +
                '/getsetlistkaryawanlibur',
                function() {
                    // Setelah konten dimuat, tambahkan event listener ke tombol batalkanlibur
                    $(".batalkanlibur").click(function(e) {
                        e.preventDefault();
                        var kode_libur = "{{ $kode_libur }}";
                        var nik = $(this).attr('nik');
                        $.ajax({
                            type: 'POST',
                            url: '/konfigurasi/harilibur/batalkanliburkaryawan',
                            data: {
                                _token: "{{ csrf_token() }}",
                                kode_libur: kode_libur,
                                nik: nik
                            },
                            cache: false,
                            success: function(respond) {
                                if (respond === '0') {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Guru berhasil dihapus !!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                    loadsetlistkaryawanlibur
                                        (); // Muat ulang tabel setelah menghapus karyawan
                                    loadkaryawanlibur
                                        (); // Muat ulang daftar karyawan libur
                                } else if (respond === '1') {
                                    Swal.fire({
                                        title: 'Oops!',
                                        text: 'Guru sudah ditambahkan !!',
                                        icon: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: respond,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    });
                }
            );
        }

        // Panggil fungsi untuk memuat tabel setlistkaryawanlibur saat halaman dimuat
        loadsetlistkaryawanlibur();

        // Tambahkan event listener ke tombol tambahkaryawan
        $(".tambahkaryawan").click(function(e) {
            e.preventDefault();
            var kode_libur = "{{ $kode_libur }}";
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: '/konfigurasi/harilibur/storekaryawanlibur',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_libur: kode_libur,
                    nik: nik
                },
                cache: false,
                success: function(respond) {
                    if (respond === '0') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Guru berhasil ditambahkan !!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        loadsetlistkaryawanlibur
                            (); // Muat ulang tabel setelah menambahkan karyawan
                        loadkaryawanlibur
                            (); // Muat ulang daftar karyawan libur
                    } else if (respond === '1') {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Guru sudah ditambahkan !!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: respond,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });
</script>
