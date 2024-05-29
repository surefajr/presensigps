@extends('layouts.presensi')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="arrow-back-circle-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Riwayat Presensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="row" style="margin-top:70px">
                <div class="col-6">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Awal</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                            value="{{ date('Y-m-01') }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Akhir</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                            value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary w-100" id="getdata">Cari Data Izin</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2" style="position: fixed; width:100%; margin:auto; overflow-y:scroll; height:430px">
        <div class="col" id="showhistori">

        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#getdata").click(function(e) {
                var tanggal_mulai = $("#tanggal_mulai").val();
                var tanggal_selesai = $("#tanggal_selesai").val();
                $.ajax({
                    type: 'POST',
                    url: '/gethistori',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal_mulai: "{{ date('Y-m-01') }}",
                        tanggal_selesai: "{{ date('Y-m-d') }}"
                    },
                    cache: false,
                    success: function(respond) {
                        $("#showhistori").html(respond);
                    }
                });
            });
        });
    </script>
@endpush
