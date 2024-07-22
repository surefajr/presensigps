<form action="/cuti/{{ $cuti->kode_cuti }}/update" method="POST" id="frmCuti">
    @csrf
    <div class="row">
        <div class="col-12">
            <label for="kode_cuti" class="form-label">Kode Cuti</label>
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
                <input type="text" value="{{ $cuti->kode_cuti }}" id="kode_cuti" class="form-control"
                    placeholder="Kode Cuti" name="kode_cuti" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="nama_cuti" class="form-label">Nama Cuti</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 12h3v4h-3z" />
                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                        <path d="M14 16h2" />
                        <path d="M14 12h4" />
                    </svg>
                </span>
                <input type="text" value="{{ $cuti->nama_cuti }}" id="nama_cuti" value="" class="form-control"
                    name="nama_cuti" placeholder="Nama Cuti" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="jumlah_hari" class="form-label">Jumlah Hari</label>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M8 14v4" />
                        <path d="M12 14v4" />
                        <path d="M16 14v4" />
                    </svg>
                </span>
                <input type="text" value="{{ $cuti->jml_hari }}" id="jml_hari" value="" class="form-control"
                    name="jml_hari" placeholder="Jumlah Hari" autocomplete="off">
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
