@extends('layouts.adminlte')

@section('title', 'Edit Mata Pelajaran')

@section('content')

<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <a href="{{ route('mapel.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>

    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card card-outline card-warning">

            <div class="card-header">
                <h3 class="card-title">Form Edit Mata Pelajaran</h3>
            </div>

            <form action="{{ route('mapel.update', $mapel->id_mapel) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="form-group">
                        <label for="nama_mapel">
                            Nama Mata Pelajaran
                        </label>

                        <input type="text"
                               name="nama_mapel"
                               id="nama_mapel"
                               class="form-control @error('nama_mapel') is-invalid @enderror"
                               value="{{ old('nama_mapel', $mapel->nama_mapel) }}"
                               placeholder="Contoh: Matematika">

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
                                  placeholder="Masukkan deskripsi mapel">{{ old('deskripsi', $mapel->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Simpan Perubahan                
                    </button>

                </div>

            </form>

        </div>

    </div>
</section>

@endsection