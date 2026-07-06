@extends('layouts.adminlte')

@section('title', 'Tambah Akun Pengguna')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus"></i>
                        Tambah Akun
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('akun.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="id_pengguna">
                                <strong>Pilih Pengguna</strong>
                            </label>

                            <select name="id_pengguna"
                                id="id_pengguna"
                                class="form-control"
                                required>
                                <option value="">-- Pilih Pengguna --</option>

                                @foreach($pengguna as $p)
                                <option value="{{ $p->id_pengguna }}"
                                    {{ old('id_pengguna') == $p->id_pengguna ? 'selected' : '' }}>
                                    {{ $p->nama }} - {{ $p->email }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <strong>Password</strong>
                            </label>

                            <input type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                autocomplete="new-password"
                                required>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('akun.index') }}"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                            <button type="submit"
                                class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection