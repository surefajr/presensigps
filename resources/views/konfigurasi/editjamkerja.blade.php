<form action="/konfigurasi/updatejamkerja" method="POST" id="frmJK_edit">
    @csrf
    <div class="row">
        <div class="col-12">
            <label for="kode_jam_kerja" class="form-label">Kode Jam Kerja</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-number-12-small">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 10l2 -2v8" />
                        <path d="M13 8h3a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 0 -1 1v2a1 1 0 0 0 1 1h3" />
                    </svg>
                </span>

                <input type="text" id="kode_jam_kerja_edit" value="{{ $jamkerja->kode_jam_kerja }}"
                    class="form-control" placeholder="Kode Jam Kerja" name="kode_jam_kerja">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="nama_jam_kerja" class="form-label">Nama Jam Kerja</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                        <path d="M9 12h6" />
                        <path d="M9 16h6" />
                    </svg>
                </span>
                <input type="text" id="nama_jam_kerja_edit" value="{{ $jamkerja->nama_jam_kerja }}"
                    class="form-control" placeholder="Nama Jam Kerja" name="nama_jam_kerja">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="awal_jam_masuk" class="form-label">Awal Jam Masuk</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436" />
                        <path d="M19 22v-6" />
                        <path d="M22 19l-3 -3l-3 3" />
                        <path d="M12 7v5l2.5 2.5" />
                    </svg>
                </span>
                <input type="text" id="awal_jam_masuk_edit" value="{{ $jamkerja->awal_jam_masuk }}"
                    class="form-control" placeholder="Awal Jam Masuk" name="awal_jam_masuk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" />
                        <path d="M12 7v5l3 3" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </span>
                <input type="text" id="jam_masuk_edit" value="{{ $jamkerja->jam_masuk }}" class="form-control"
                    placeholder="Jam Masuk" name="jam_masuk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="akhir_jam_masuk" class="form-label">Akhir Jam Masuk</label>
            <div class="input-icon mb-3">
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
                <input type="text" id="akhir_jam_masuk_edit" value="{{ $jamkerja->akhir_jam_masuk }}"
                    class="form-control" placeholder="Akhir Jam Masuk" name="akhir_jam_masuk">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <label for="status_istirahat" class="form-label">Status Istirahat</label>
            <div class="form-group">
                <select name="status_istirahat" id="status_istirahat_edit" class="form-select">
                    <option value="">Pilih Status Istirahat</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row editsetjamistirahat">
        <div class="col-12">
            <label for="awal_istirahat" class="form-label">Awal Istirahat</label>
            <div class="input-icon mb-3">
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
                <input type="text" id="awal_istirahat_edit" class="form-control" placeholder="Awal istirahat"
                    name="awal_istirahat" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row editsetjamistirahat">
        <div class="col-12">
            <label for="akhir_istirahat" class="form-label">Akhir Istirahat</label>
            <div class="input-icon mb-3">
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
                <input type="text" id="akhir_istirahat_edit" class="form-control" placeholder="Akhir istirahat"
                    name="akhir_istirahat" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="jam_pulang" class="form-label">Jam Pulang</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-down">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" />
                        <path d="M12 7v5l3 3" />
                        <path d="M19 16v6" />
                        <path d="M22 19l-3 3l-3 -3" />
                    </svg>
                </span>
                <input type="text" id="jam_pulang_edit" value="
                {{ $jamkerja->jam_pulang }}"
                    class="form-control" placeholder="Jam Pulang" name="jam_pulang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="total_jam" class="form-label">Total Jam Kerja</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-down">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.984 12.535a9 9 0 1 0 -8.431 8.448" />
                        <path d="M12 7v5l3 3" />
                        <path d="M19 16v6" />
                        <path d="M22 19l-3 3l-3 -3" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->total_jam }}" id="total_jam_edit" class="form-control"
                    placeholder="Total Jam" name="total_jam" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row mt-2 ">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 14l11 -11" />
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                    </svg>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {

        function showsetjamistirahat() {
            var status_istirahat = $("#status_istirahat_edit").val();
            if (status_istirahat == "1") {
                $(".editsetjamistirahat").show();
            } else {
                $(".editsetjamistirahat").hide();
            }
        }
        $("#status_istirahat_edit").change(function() {
            showsetjamistirahat();
        });
        showsetjamistirahat();


        $("#awal_jam_masuk_edit, #jam_masuk_edit, #akhir_jam_masuk_edit, #jam_pulang_edit, #awal_istirahat_edit, #akhir_istirahat_edit")
            .mask(
                "00:00");

        $("#frmJK_edit").submit(function() {
            var kode_jam_kerja = $("#kode_jam_kerja_edit").val();
            var nama_jam_kerja = $("#nama_jam_kerja_edit").val();
            var awal_jam_masuk = $("#awal_jam_masuk_edit").val();
            var jam_masuk = $("#jam_masuk_edit").val();
            var akhir_jam_masuk = $("#akhir_jam_masuk_edit").val();
            var awal_istirahat = $("#awal_istirahat_edit").val();
            var akhir_istirahat = $("#akhir_istirahat_edit").val();
            var status_istirahat = $("#status_istirahat_edit").val();
            var jam_pulang = $("#jam_pulang_edit").val();
            var total_jam = $("#total_jam_edit").val();

            if (kode_jam_kerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Kode Jam Kerja Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#kode_jam_kerja_edit").focus();
                });

                return false;
            } else if (nama_jam_kerja == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama jam kerja Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#nama_jam_kerja_edit").focus();
                });
                return false;
            } else if (awal_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Awal jam masuk Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#awal_jam_masuk_edit").focus();
                });
                return false;
            } else if (jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Masuk Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jam_masuk_edit").focus();
                });
                return false;
            } else if (akhir_jam_masuk == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Akhir Jam Masuk Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#akhir_jam_masuk_edit").focus();
                });
                return false;
            } else if (status_istirahat === "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Status Istirahat Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#status_istirahat_edit").focus();
                });
                return false;
            } else if (awal_istirahat == "" && status_istirahat == "1") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Awal Jam Istirahat Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#awal_istirahat_edit").focus();
                });
                return false;
            } else if (akhir_istirahat == "" && status_istirahat == "1") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Akhir Jam Istirahat Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#akhir_istirahat_edit").focus();
                });
                return false;
            } else if (jam_pulang == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Pulang Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jam_pulang_edit").focus();
                });
                return false;
            } else if (total_jam == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Total Jam Harus di isi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#total_jam_edit").focus();
                });
                return false;
            }
        });
    });
</script>
