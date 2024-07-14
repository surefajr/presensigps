<div class="row mt-2 ">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NUPTK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="loadsetlistgurulibur"></tbody>
        </table>
    </div>
</div>

<script>
    $(function() {
        function loadsetlistgurulibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadsetlistgurulibur").load('/konfigurasi/harilibur/' + kode_libur +
                '/getsetlistgurulibur');
        }

        loadsetlistgurulibur();
    });
</script>
