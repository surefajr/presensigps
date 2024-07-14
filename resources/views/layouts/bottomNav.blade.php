<!-- App Bottom Menu -->
<style>
    .item .col p {
        margin-top: 8px;
        /* Atur jarak antara ikon dan teks */
        text-align: center;
        /* Pusatkan teks */
        font-size: 14px;
        /* Ukuran font */
        color: #333;
        /* Warna teks */
    }
</style>


<div class="appBottomMenu">

    <a href="/dashboard" class="item{{ request()->is('dashboard') ? 'active ' : '' }}">
        <div class="col">
            <ion-icon name="home-outline" size="large"></ion-icon>
            <strong>Beranda</strong>
        </div>
    </a>
    <a href="/presensi/histori" class="item {{ request()->is('presensi/histori') ? 'active ' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>History</strong>
        </div>
    </a>
    <a href="/presensi/create" class="item {{ request()->is('presensi/create') ? 'active ' : '' }}">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
            <p>Absen</p>
        </div>
    </a>

    <a href="/presensi/izin" class="item {{ request()->is('presensi/izin') ? 'active ' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar outline"></ion-icon>
            <strong>Pengajuan Izin</strong>
        </div>
    </a>
    <a href="/editprofile" class="item {{ request()->is('editprofile') ? 'active ' : '' }}">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
