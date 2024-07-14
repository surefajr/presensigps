<form action="" method="POST" id="formKoreksipresensi">
    @csrf
    <input type="hidden" name="nuptk" value="{{ $guru->nuptk }}">
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <table class="table">
        <tr>
            <td>NUPTK</td>
            <td>{{ $guru->nuptk }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $guru->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Tanggal Presensi</td>
            <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
        </tr>
    </table>
    <div class="row mb-2">
        <div class="col-12">
            <div class="input-icon ">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-play">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 7v5l2 2" />
                        <path d="M17 22l5 -3l-5 -3z" />
                        <path d="M13.017 20.943a9 9 0 1 1 7.831 -7.292" />
                    </svg>
                </span>
                <input type="text" id="jam_in" class="form-control" placeholder="Jam Masuk" name="jam_in">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="input-icon ">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                        <path d="M12 7v5l2 2" />
                        <path d="M17 17v5" />
                        <path d="M21 17v5" />
                    </svg>
                </span>
                <input type="text" id="jam_out" class="form-control" placeholder="Jam Pulang" name="jam_out">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="form-group">
                <select name="kode_jam_kerja" id="kode_jam_kerja" class="form-control">
                    <option value="">Pilih Jam Kerja</option>
                    @foreach ($jamkerja as $d)
                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Pilih Status Presensi</option>                   
                        <option value="h">Hadir</option>
                        <option value="a">Alpa</option>                    
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#Koreksipresensi").submit(function() {
            // var jam_in = $("jam_in").val();
            //  var jam_out = $("jam_out").val();
            var kode_jam_kerja = $("kode_jam_kerja").val();
            var status = $("status").val();
            if (kode_jam_kerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam kerja Harus diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#kode_jam_kerja").focus();
                });
                return false;
            } else if (status == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Status Harus diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#status").focus();
                });
                return false;
            }
        });
    });
</script>
