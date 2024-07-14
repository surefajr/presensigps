@foreach ($guru as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nuptk }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->jabatan }}</td>
        <td>
            @if (!empty($d->ceknuptk))
                <a href="#" class="btn btn-danger btn-sm batalkanlibur" nuptk="{{ $d->nuptk }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </a>
            @else
                <a href="#" class="btn btn-success btn-sm tambahguru" nuptk="{{ $d->nuptk }}">
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
        // Fungsi untuk memuat daftar guru libur
        function loadgurulibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadgurulibur").load('/konfigurasi/harilibur/' + kode_libur + '/getgurulibur');
        }

        // Fungsi untuk memuat daftar guru libur dan setelah itu menambahkan event listener ke tombol batalkanlibur
        function loadsetlistgurulibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadsetlistgurulibur").load('/konfigurasi/harilibur/' + kode_libur +
                '/getsetlistgurulibur',
                function() {
                    // Setelah konten dimuat, tambahkan event listener ke tombol batalkanlibur
                    $(".batalkanlibur").click(function(e) {
                        e.preventDefault();
                        var kode_libur = "{{ $kode_libur }}";
                        var nuptk = $(this).attr('nuptk');
                        $.ajax({
                            type: 'POST',
                            url: '/konfigurasi/harilibur/batalkanliburguru',
                            data: {
                                _token: "{{ csrf_token() }}",
                                kode_libur: kode_libur,
                                nuptk: nuptk
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
                                    loadsetlistgurulibur
                                        (); // Muat ulang tabel setelah menghapus guru
                                    loadgurulibur
                                        (); // Muat ulang daftar guru libur
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

        // Panggil fungsi untuk memuat tabel setlistgurulibur saat halaman dimuat
        loadsetlistgurulibur();

        // Tambahkan event listener ke tombol tambahguru
        $(".tambahguru").click(function(e) {
            e.preventDefault();
            var kode_libur = "{{ $kode_libur }}";
            var nuptk = $(this).attr('nuptk');
            $.ajax({
                type: 'POST',
                url: '/konfigurasi/harilibur/storegurulibur',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_libur: kode_libur,
                    nuptk: nuptk
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
                        loadsetlistgurulibur
                            (); // Muat ulang tabel setelah menambahkan guru
                        loadgurulibur
                            (); // Muat ulang daftar guru libur
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
