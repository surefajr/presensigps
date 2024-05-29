@extends('layouts.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: aqua !important;
        }

        #keterangan {
            height: 8rem !important;
        }
    </style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="arrow-back-circle-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:70px">
        <div class="col">
            <form method="POST" action="/izincuti/store" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" id="tgl_izin_dari" name="tgl_izin_dari" class="form-control datepicker"
                        autocomplete="off" placeholder="Dari Tanggal">
                </div>
                <div class="form-group">
                    <input type="text" id="tgl_izin_sampai" name="tgl_izin_sampai" class="form-control datepicker"
                        autocomplete="off" placeholder="Sampai Tanggal">
                </div>
                <div class="form-group">
                    <input type="hidden" id="jml_hari" name="jml_hari" class="form-control " placeholder="Jumlah Hari"
                        autocomplete="off" readonly>
                    <p id="infojmlhari"></p>
                </div>
                <div class="form-group">
                    <select name="kode_cuti" id="kode_cuti" class="form-control selectmaterialize">
                        <option value="">Pilih Kategori Cuti</option>
                        @foreach ($mastercuti as $c)
                            <option value="{{ $c->kode_cuti }}">{{ $c->nama_cuti }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="max_cuti" id="max_cuti" name="max_cuti" class="form-control"
                        placeholder="Sisa Cuti" readonly autocomplete="off">
                    <p id="infocuti"></p>
                </div>
                <div class="form-group">
                    <input type="text" name="keterangan" id="keterangan" name="keterangan" class="form-control"
                        placeholder="Keterangan" autocomplete="off">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({


                format: "yyyy-mm-dd"
            });

            function loadjumlahhari() {
                var dari = $("#tgl_izin_dari").val();
                var sampai = $("#tgl_izin_sampai").val();
                var date1 = new Date(dari);
                var date2 = new Date(sampai);

                var Difference_In_Time = date2.getTime() - date1.getTime();
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                if (dari == "" || sampai == "") {
                    var jmlhari = 0;
                } else {
                    var jmlhari = Difference_In_Days + 1;
                }

                $("#jml_hari").val(jmlhari);
                $("#infojmlhari").html(
                    "<b>Jumlah Hari Cuti Yang di ambil adalah :  " + jmlhari +
                    " Hari</b>");

            }
            $("#tgl_izin_dari,#tgl_izin_sampai").change(function(e) {
                loadjumlahhari();
            });






            //$("#tgl_izin").change(function(e) {
            //    var tgl_izin = $(this).val();
            //    $.ajax({
            //        type: 'POST',
            //        url: '/presensi/cekpengajuanizin',
            //        data: {
            //            _token: "{{ csrf_token() }}",
            //            tgl_izin: tgl_izin
            //        },
            //        cache: false,
            //        success: function(respond) {
            //            if (respond == 1) {
            //                Swal.fire({
            //                    title: 'Oops!',
            //                    text: 'Anda Sudah Melakukan Pengajuan Pada Tanggal Tersebut',
            //                    icon: 'warning',
            //                }).then((result) => {
            //                    $("#tgl_izin").val("");
            //                });
            //            }
            //        }
            //    });
            //});

            $("#frmizin").submit(function() {
                var tgl_izin_dari = $("#tgl_izin_dari").val();
                var tgl_izin_sampai = $("#tgl_izin_sampai").val();
                var jml_hari = $("#jml_hari").val();
                var max_cuti = $("#max_cuti").val();
                var keterangan = $("#keterangan").val();
                var kode_cuti = $("#kode_cuti").val();
                if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Cuti harus di isi',
                        icon: 'warning',
                    });
                    return false;
                } else if (kode_cuti == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Kategori Cuti harus di isi',
                        icon: 'warning',
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan Cuti harus di isi',
                        icon: 'warning',
                    });
                    return false;
                }else if (parseInt(jml_hari) > parseInt(max_cuti)) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Jumlah hari cuti tidak boleh melebihi '+ max_cuti + " Hari",
                        icon: 'warning',
                    });
                    return false;
                }
            });

            $("#kode_cuti").change(function(e) {
                var kode_cuti = $(this).val();
                var tgl_izin_dari = $("#tgl_izin_dari").val();
                if (tgl_izin_dari == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Cuti harus di isi',
                        icon: 'warning',
                    });
                    $("#kode_cuti").val("");
                } else {
                    $.ajax({
                        url: 'izincuti/getmaxcuti',
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            kode_cuti: kode_cuti,
                            tgl_izin_dari: tgl_izin_dari
                        },
                        cache: false,
                        success: function(respond) {
                            $("#max_cuti").val(respond);
                            $("#infocuti").html(
                                "<b>Jumlah Cuti Yang tersisa adalah :  " + respond +
                                " Hari</b>");
                        }
                    });
                }

            });
        });
    </script>
@endpush
