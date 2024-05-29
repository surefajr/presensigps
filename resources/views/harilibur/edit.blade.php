<form action="/konfigurasi/harilibur/{{ $harilibur->kode_libur }}/update" method="POST" id="frmeditHarilibur">
    @csrf
    <div class="row">
        <div class="col-12">
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
                <input type="text" id="kode_libur" value="{{ $harilibur->kode_libur }}" class="form-control"
                    placeholder="Auto" name="kode_libur" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M11 15h1" />
                        <path d="M12 15v3" />
                    </svg>
                </span>
                <input type="text" id="tanggal_libur" value="{{ $harilibur->tanggal_libur }}" class="form-control"
                    placeholder="Tanggal Libur" name="tanggal_libur" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-note">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M13 20l7 -7" />
                        <path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" />
                    </svg>
                </span>
                <input type="text" id="keterangan" value="{{ $harilibur->keterangan }}" class="form-control"
                    placeholder="Keterangan" name="keterangan" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row mt-2 ">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                    </svg>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
        $("#tanggal_libur").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $("#frmeditHarilibur").submit(function(e) {
            var tanggal_libur = $("#tanggal_libur").val();
            var keterangan = $("#keterangan").val();


            if (tanggal_libur == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Tanggal Libur Harus diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#tanggal_libur").focus();
                });

                return false;
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Keterangan Harus diisi !!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#keterangan").focus();
                });

                return false;
            }
        });
    });
</script>
