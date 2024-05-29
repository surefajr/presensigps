@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Hari Libur
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
                            {{-- untuk naro @role --}}
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahHarilibur">
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
                                    {{--  <form action="/karyawan" method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                        class="form-control" placeholder="Nama Karyawan"
                                                        value="{{ Request::input('nama_karyawan') }}">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Libur</th>
                                                <th>Tanggal Libur</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($harilibur as $d)
                                                <tr>
                                                    <td>{{ $loop->iteration + $harilibur->firstItem() - 1 }}</td>
                                                    <td>{{ $d->kode_libur }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($d->tanggal_libur)) }}</td>
                                                    <td>{{ $d->keterangan }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div>
                                                                <a href="#" class="edit btn btn-info btn-sm"
                                                                    kode_libur="{{ $d->kode_libur }}">
                                                                    Edit
                                                                </a>
                                                                <a href="/konfigurasi/harilibur/{{ $d->kode_libur }}/setkaryawanlibur"
                                                                    class="btn btn-success btn-sm ml-2">
                                                                    + Guru Libur
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <form
                                                                    action="/konfigurasi/harilibur/{{ $d->kode_libur }}/delete"
                                                                    method="POST" style="margin-left:5px;">
                                                                    @csrf
                                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                                        Hapus
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $harilibur->links('vendor.pagination.5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create --}}
    <div class="modal modal-blur fade" id="modal-createlibur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadcreatelibur">

                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="modal modal-blur fade" id="modal-editlibur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditlibur">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#btnTambahHarilibur").click(function() {
                $("#modal-createlibur").modal("show");
                $("#loadcreatelibur").load("/konfigurasi/harilibur/create");
            });

            $(".edit").click(function() {
                var kode_libur = $(this).attr('kode_libur');
                $.ajax({
                    type: 'POST',
                    url: '/konfigurasi/harilibur/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_libur: kode_libur
                    },
                    success: function(respond) {
                        $("#loadeditlibur").html(respond);
                    }
                });
                $("#modal-editlibur").modal("show");
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
