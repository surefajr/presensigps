@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Jam Kerja
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahJK">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                        Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Jam Kerja</th>
                                                    <th>Nama Jam Kerja</th>
                                                    <th>Awal Jam Masuk</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Akhir Jam Masuk</th>
                                                    <th>Awal Istirahat</th>
                                                    <th>Akhir Istirahat</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Total Jam</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jam_kerja as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->kode_jam_kerja }}</td>
                                                        <td>{{ $d->nama_jam_kerja }}</td>
                                                        <td>{{ $d->awal_jam_masuk }}</td>
                                                        <td>{{ $d->jam_masuk }}</td>
                                                        <td>{{ $d->akhir_jam_masuk }}</td>
                                                        <td>{{ $d->awal_istirahat }}</td>
                                                        <td>{{ $d->akhir_istirahat }}</td>
                                                        <td>{{ $d->jam_pulang }}</td>
                                                        <td class="text-center">{{ $d->total_jam }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="#" class="edit btn btn-info btn-sm"
                                                                    kode_jam_kerja="{{ $d->kode_jam_kerja }}">
                                                                    Edit
                                                                </a>
                                                                <form action="/konfigurasi/{{ $d->kode_jam_kerja }}/delete"
                                                                    method="POST" style="margin-left:5px;">
                                                                    @csrf
                                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                                        Hapus
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-inputjk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Jam Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/konfigurasi/storejamkerja" method="POST" id="frmJK">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-number-12-small">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 10l2 -2v8" />
                                            <path
                                                d="M13 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3" />
                                        </svg>
                                    </span>
                                    
                                    <input type="text" maxlength="6" id="kode_jam_kerja" class="form-control"
                                        placeholder="Kode Jam Kerja" name="kode_jam_kerja" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 12h6" />
                                            <path d="M9 16h6" />
                                        </svg>
                                    </span>
                                    <input type="text" maxlength="22" id="nama_jam_kerja" class="form-control"
                                        placeholder="Nama Jam Kerja" name="nama_jam_kerja" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-up">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436" />
                                            <path d="M19 22v-6" />
                                            <path d="M22 19l-3 -3l-3 3" />
                                            <path d="M12 7v5l2.5 2.5" />
                                        </svg>
                                    </span>
                                    <input type="text" id="awal_jam_masuk" class="form-control"
                                        placeholder="Awal Jam Masuk" name="awal_jam_masuk" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" />
                                            <path d="M12 7v5l3 3" />
                                            <path d="M15 19l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <input type="text" id="jam_masuk" class="form-control" placeholder="Jam Masuk"
                                        name="jam_masuk" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                                            <path d="M12 7v5l2 2" />
                                            <path d="M17 17v5" />
                                            <path d="M21 17v5" />
                                        </svg>
                                    </span>
                                    <input type="text" id="akhir_jam_masuk" class="form-control"
                                        placeholder="Akhir Jam Masuk" name="akhir_jam_masuk" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_istirahat" id="status_istirahat" class="form-select">
                                        <option value="">Istirahat</option>
                                        <option value="1">Ada</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row setjamistirahat">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                                            <path d="M12 7v5l2 2" />
                                            <path d="M17 17v5" />
                                            <path d="M21 17v5" />
                                        </svg>
                                    </span>
                                    <input type="text" id="awal_istirahat" class="form-control"
                                        placeholder="Awal istirahat" name="awal_istirahat" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row setjamistirahat">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                                            <path d="M12 7v5l2 2" />
                                            <path d="M17 17v5" />
                                            <path d="M21 17v5" />
                                        </svg>
                                    </span>
                                    <input type="text" id="akhir_istirahat" class="form-control"
                                        placeholder="Akhir istirahat" name="akhir_istirahat" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-down">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" />
                                            <path d="M12 7v5l3 3" />
                                            <path d="M19 16v6" />
                                            <path d="M22 19l-3 3l-3 -3" />
                                        </svg>
                                    </span>
                                    <input type="text" id="jam_pulang" class="form-control" placeholder="Jam Pulang"
                                        name="jam_pulang" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-down">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" />
                                            <path d="M12 7v5l3 3" />
                                            <path d="M19 16v6" />
                                            <path d="M22 19l-3 3l-3 -3" />
                                        </svg>
                                    </span>
                                    <input type="text" id="total_jam" class="form-control" placeholder="Total Jam"
                                        name="total_jam" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 ">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal modal-blur fade" id="modal-editjk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Jam Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditjk">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {

            function showsetjamistirahat() {
                var status_istirahat = $("#status_istirahat").val();
                if (status_istirahat == "1") {
                    $(".setjamistirahat").show();
                } else {
                    $(".setjamistirahat").hide();
                }
            }
            $("#status_istirahat").change(function() {
                showsetjamistirahat();
            });
            showsetjamistirahat();


            $("#awal_jam_masuk, #jam_masuk, #akhir_jam_masuk, #jam_pulang, #awal_istirahat, #akhir_istirahat").mask(
                "00:00");

            $("#btnTambahJK").click(function() {
                $("#modal-inputjk").modal("show");
            });

            $("#frmJK").submit(function() {
                var kode_jam_kerja = $("#kode_jam_kerja").val();
                var nama_jam_kerja = $("#nama_jam_kerja").val();
                var awal_jam_masuk = $("#awal_jam_masuk").val();
                var jam_masuk = $("#jam_masuk").val();
                var akhir_jam_masuk = $("#akhir_jam_masuk").val();
                var awal_istirahat = $("#awal_istirahat").val();
                var akhir_istirahat = $("#akhir_istirahat").val();
                var status_istirahat = $("#status_istirahat").val();
                var jam_pulang = $("#jam_pulang").val();
                var total_jam = $("#total_jam").val();
                if (kode_jam_kerja == "") {

                    Swal.fire({
                        title: 'Warning!',
                        text: 'Kode Jam Kerja Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#kode_jam_kerja").focus();
                    });

                    return false;
                } else if (nama_jam_kerja == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama jam kerja Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nama_jam_kerja").focus();
                    });
                    return false;
                } else if (awal_jam_masuk == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Awal jam masuk Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#awal_jam_masuk").focus();
                    });
                    return false;
                } else if (jam_masuk == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jam Masuk Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_masuk").focus();
                    });
                    return false;
                } else if (akhir_jam_masuk == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Akhir Jam Masuk Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#akhir_jam_masuk").focus();
                    });
                    return false;
                } else if (status_istirahat === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Status Istirahat Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#status_istirahat").focus();
                    });
                    return false;
                } else if (awal_istirahat == "" && status_istirahat == "1") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Awal Jam Istirahat Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#awal_istirahat").focus();
                    });
                    return false;
                } else if (akhir_istirahat == "" && status_istirahat == "1") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Akhir Jam Istirahat Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#akhir_istirahat").focus();
                    });
                    return false;
                } else if (jam_pulang == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jam Pulang Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#jam_pulang").focus();
                    });
                    return false;
                } else if (total_jam == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Total Jam Harus di isi !!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#total_jam").focus();
                    });
                    return false;
                }
            });

            $(".edit").click(function() {
                var kode_jam_kerja = $(this).attr('kode_jam_kerja');
                $.ajax({
                    type: 'POST',
                    url: '/konfigurasi/editjamkerja',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_jam_kerja: kode_jam_kerja
                    },
                    success: function(respond) {
                        $("#loadeditjk").html(respond);
                    }
                });
                $("#modal-editjk").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apa Anda Yakin?",
                    text: "Data akan terhapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus Saja!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Hapus!",
                            text: "Data sudah di hapus.",
                            icon: "success"
                        });
                    }
                });
            });
        });
    </script>
@endpush
