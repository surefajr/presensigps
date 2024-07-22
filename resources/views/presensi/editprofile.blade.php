@extends('layouts.presensi')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="arrow-back-circle-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profil</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="scrollable-content">
        <form action="/presensi/{{ $guru->nuptk }}/updateprofile" method="POST" enctype="multipart/form-data"
            style="margin-top: 70px;">
            @csrf
            <div class="col">
                @php
                    $messagesuccess = Session::get('success');
                    $messageerror = Session::get('error');
                @endphp
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ $messagesuccess }}
                    </div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger">
                        {{ $messageerror }}
                    </div>
                @endif

                @error('foto')
                    <div class="alert alert-warning ">
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <div class="col">
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <span class="label-text" style="font-size: small;">NUPTK</span>
                            <input type="" class="form-control" value="{{ $guru->nuptk }}" name="nuptk"
                                placeholder="NUPTK" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <span class="label-text" style="font-size: small;">Username</span>
                                <input type="" class="form-control" value="{{ $guru->username }}" name="username"
                                    placeholder="username" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <span class="label-text" style="font-size: small;">Nama Lengkap</span>
                                <input type="text" class="form-control" value="{{ $guru->nama_lengkap }}"
                                    name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <span class="label-text" style="font-size: small;">No.HP</span>
                                <input type="text" class="form-control" value="{{ $guru->no_hp }}" name="no_hp"
                                    placeholder="No. HP" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <span class="label-text" style="font-size: small;">Masukkan Password Baru</span>
                                <input type="password" class="form-control" name="password" placeholder="Password Baru"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="custom-file-upload" id="fileUpload1">
                            <span class="label-text" style="font-size: small;">Ganti Foto Profil</span>
                            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                            <label for="fileuploadInput">
                                <span>
                                    <strong>
                                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                            aria-label="cloud upload outline"></ion-icon>
                                        <i>Tap to Upload</i>
                                    </strong>
                                </span>
                            </label>
                        </div>
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <ion-icon name="refresh-outline"></ion-icon>
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

<style>
    .scrollable-content {
        max-height: calc(100vh - 70px);
        /* Adjust 70px to the height of the header */
        overflow-y: auto;
    }
</style>
