@extends('layouts.adminlte')
@section('title', 'Edit Password')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key"></i>
                        Edit Password Akun
                    </h3>
                </div>

                <form action="{{ route('akun.update', $akun->id_akun) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Email Pengguna</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $akun->pengguna->email }}"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password baru"
                                required>

                            <small class="text-muted">
                                Kosongkan jika password tidak ingin diubah.
                            </small>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('akun.index') }}"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>

                        <button type="submit"
                            class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>
@endsection