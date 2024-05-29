@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Edit Setting Jam Kerja
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <td>NIK</td>
                            <td>{{ $karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <td>Nama Guru</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <form action="/konfigurasi/updatesetjamkerja" method="POST">
                        @csrf
                        <input type="hidden" name="nik" value="{{ $karyawan->nik }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($setjamkerja as $s)
                                    <tr>
                                        <td>{{ $s->hari }}
                                            <input type="hidden" name="hari[]" value="{{ $s->hari }}">
                                        </td>
                                        <td>
                                            <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                <option value="">Pilih Jam Kerja</option>
                                                @foreach ($jamkerja as $d)
                                                    <option {{ $d->kode_jam_kerja == $s->kode_jam_kerja ? 'selected' : '' }}
                                                        value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                </svg>
                            </span>
                            Update
                        </button>
                    </form>
                </div>
                <div class="col-7">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="7">Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode </th>
                                <th>Nama JK</th>
                                <th>Awal Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $d)
                                <tr>
                                    <td>{{ $d->kode_jam_kerja }}</td>
                                    <td>{{ $d->nama_jam_kerja }}</td>
                                    <td>{{ $d->awal_jam_masuk }}</td>
                                    <td>{{ $d->jam_masuk }}</td>
                                    <td>{{ $d->akhir_jam_masuk }}</td>
                                    <td>{{ $d->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
