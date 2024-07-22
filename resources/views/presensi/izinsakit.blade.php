@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Pengajuan Izin
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
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
                    <form action="/presensi/izinsakit" method="GET" autocomplete="off">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                            <path d="M15 19l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ Request('dari') }}" id="dari" class="form-control"
                                        placeholder="Dari" name="dari">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-pause">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                            <path d="M17 17v5" />
                                            <path d="M21 17v5" />
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ Request('sampai') }}" id="sampai"
                                        class="form-control" placeholder="Sampai" name="sampai">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ Request('nuptk') }}" id="nuptk" class="form-control"
                                        placeholder="NUPTK" name="nuptk">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                            <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                            <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                            <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ Request('nama_lengkap') }}" id="nama_lengkap"
                                        class="form-control" placeholder="Nama" name="nama_lengkap">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="">Pilih Status</option>
                                        <option value="0"{{ Request('status_approved') === '0' ? ' selected' : '' }}>
                                            Pending</option>
                                        <option value="1"{{ Request('status_approved') == 1 ? ' selected' : '' }}>
                                            DiSetujui</option>
                                        <option value="2"{{ Request('status_approved') == 2 ? ' selected' : '' }}>
                                            DiTolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                    </form>



                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Izin</th>
                                        <th>Tanggal</th>
                                        <th>NUPTK</th>
                                        <th>Nama Guru</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Dokumen</th>
                                        <th>Keterangan</th>
                                        <th>Status Approved</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_izin }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tgl_izin_dari)) }} s/d
                                                {{ date('d-m-Y', strtotime($d->tgl_izin_sampai)) }}</td>
                                            <td>{{ $d->nuptk }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jabatan }}</td>
                                            <td>
                                                @if ($d->status == 'i')
                                                    Izin
                                                @elseif($d->status == 's')
                                                    Sakit
                                                @elseif($d->status == 'c')
                                                    Cuti
                                                @elseif($d->status == 'l')
                                                    LIBUR
                                                @else
                                                    Status Tidak Diketahui
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($d->doc_sid))
                                                    @php
                                                        $path = Storage::url('uploads/sid/' . $d->doc_sid);
                                                    @endphp
                                                    <a href="{{ url($path) }}" target="_blank">
                                                        {{ $d->doc_sid }}
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M9 15l6 -6" />
                                                            <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                                            <path
                                                                d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                                        </svg>
                                                    </a>
                                                @endif

                                            </td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>
                                                @if ($d->status_approved == 1)
                                                    <span class="badge bg-success" style="color: white;">DiSetujui</span>
                                                @elseif ($d->status_approved == 2)
                                                    <span class="badge bg-danger" style="color: white;">DiTolak</span>
                                                @else
                                                    <span class="badge bg-warning" style="color: white;">Pending</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($d->status_approved == 0)
                                                    <a href="#" class="btn btn-sm btn-primary approve"
                                                        kode_izin="{{ $d->kode_izin }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                            <path d="M11 13l9 -9" />
                                                            <path d="M15 4h5v5" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="/presensi/{{ $d->kode_izin }}/batalkanizinsakit"
                                                        class="btn btn-sm btn-danger ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M18 6l-12 12" />
                                                            <path d="M6 6l12 12" />
                                                        </svg>
                                                        Batalkan
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $izinsakit->links('vendor.pagination.5') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approved Izin </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/presensi/approveizinsakit" method="POST">
                                @csrf
                                <input type="hidden" id="kode_izin_form" name="kode_izin_form">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="status_approved" id="status_approved" class="form-select ">
                                                <option value="1">Di Setujui</option>
                                                <option value="2">Di Tolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                                                </svg>
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @push('myscript')
            <script>
                $(function() {
                    $(".approve").click(function(e) {
                        e.preventDefault();
                        var kode_izin = $(this).attr("kode_izin");
                        $("#kode_izin_form").val(kode_izin);
                        $("#modal-izinsakit").modal("show");
                    });


                    $("#dari,#sampai").datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        format: 'yyyy-mm-dd'
                    });
                });
            </script>
        @endpush
