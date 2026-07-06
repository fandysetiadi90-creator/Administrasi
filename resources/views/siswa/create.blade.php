@extends('layouts.adminlte')

@section('title', 'Tambah Siswa')

@section('content')

@php
    $user = auth()->user();
@endphp

<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-plus mr-1"></i>
            Form Tambah Siswa
        </h3>
    </div>

    <form action="{{ route('siswa.store') }}" method="POST">
        @csrf

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5>
                        <i class="icon fas fa-ban"></i>
                        Terjadi Kesalahan
                    </h5>

                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info">
                <h5>
                    <i class="icon fas fa-info-circle"></i>
                    Informasi
                </h5>

                Data siswa akan otomatis masuk ke kelas:

                <strong>
                    {{ $kelas->nama ?? '-' }}
                </strong>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Siswa</label>

                        <input type="text"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}"
                               placeholder="Masukkan nama siswa">

                        @error('nama')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIS</label>

                        <input type="text"
                               name="nis"
                               class="form-control @error('nis') is-invalid @enderror"
                               value="{{ old('nis') }}"
                               placeholder="Masukkan NIS">

                        @error('nis')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat Lahir</label>

                        <input type="text"
                               name="tempat_lahir"
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               value="{{ old('tempat_lahir') }}"
                               placeholder="Masukkan tempat lahir">

                        @error('tempat_lahir')
                            <span class="invalid-feedback">
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>

                        <input type="date"
                               name="tgl_lahir"
                               class="form-control @error('tgl_lahir') is-invalid @enderror"
                               value="{{ old('tgl_lahir') }}">

                        @error('tgl_lahir')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Agama</label>

                        <select name="agama"
                                class="form-control @error('agama') is-invalid @enderror">

                            <option value="">-- Pilih Agama --</option>

                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>
                                Budha
                            </option>

                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>
                                Konghucu
                            </option>
                        </select>

                        @error('agama')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Alamat</label>

                        <textarea name="alamat"
                                  rows="4"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Masukkan alamat siswa">{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save mr-1"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection