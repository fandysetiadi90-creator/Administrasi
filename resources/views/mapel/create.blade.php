@extends('layouts.adminlte')

@section('title', 'Tambah Mata Pelajaran')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book-medical"></i>
                        Form Tambah Mata Pelajaran
                    </h3>
                </div>

                <form action="{{ route('mapel.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label for="nama_mapel">
                                Nama Mata Pelajaran
                            </label>

                            <input type="text"
                                name="nama_mapel"
                                id="nama_mapel"
                                class="form-control @error('nama_mapel') is-invalid @enderror"
                                value="{{ old('nama_mapel') }}"
                                placeholder="Contoh: Matematika"
                                required>

                            @error('nama_mapel')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                id="deskripsi"
                                rows="4"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Masukkan deskripsi mata pelajaran (opsional)">{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('mapel.index') }}"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>

                        <button type="submit"
                            class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</div>

@endsection