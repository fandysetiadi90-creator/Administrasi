@extends('layouts.adminlte')

@section('title', 'Edit Siswa')

@section('content')

<div class="content-header">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <i class="fas fa-user-edit text-warning"></i>
                Edit Data Siswa
            </h4>

            <a href="{{ route('siswa.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <div class="card card-warning card-outline">

            <div class="card-header">
                <h3 class="card-title">
                    Form Edit Siswa
                </h3>
            </div>

            <form action="{{ route('siswa.update', $siswa->id_siswa) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Nama Siswa</label>

                                <input type="text"
                                    name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $siswa->nama) }}"
                                    required>

                                @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIS</label>

                                <input type="text"
                                    name="nis"
                                    class="form-control @error('nis') is-invalid @enderror"
                                    value="{{ old('nis', $siswa->nis) }}"
                                    required>

                                @error('nis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Tempat Lahir</label>

                                <input type="text"
                                    name="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                    required>

                                @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Tanggal Lahir</label>

                                <input type="date"
                                    name="tgl_lahir"
                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                    value="{{ old('tgl_lahir', $siswa->tgl_lahir) }}"
                                    required>

                                @error('tgl_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIK</label>

                                <input type="text"
                                    name="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik', $siswa->nik) }}"
                                    required>

                                @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Agama</label>

                                <select name="agama"
                                    class="form-control @error('agama') is-invalid @enderror"
                                    required>

                                    <option value="">-- Pilih Agama --</option>

                                    @foreach([
                                        'Islam',
                                        'Kristen',
                                        'Katolik',
                                        'Hindu',
                                        'Budha',
                                        'Konghucu'
                                    ] as $agama)

                                    <option value="{{ $agama }}"
                                        {{ old('agama', $siswa->agama) == $agama ? 'selected' : '' }}>

                                        {{ $agama }}

                                    </option>

                                    @endforeach

                                </select>

                                @error('agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <label>Alamat</label>

                        <textarea name="alamat"
                            rows="4"
                            class="form-control @error('alamat') is-invalid @enderror"
                            required>{{ old('alamat', $siswa->alamat) }}</textarea>

                        @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">

                    <button type="reset"
                        class="btn btn-secondary">

                        <i class="fas fa-redo"></i>
                        Reset
                    </button>

                    <button type="submit"
                        class="btn btn-warning">

                        <i class="fas fa-save"></i>
                        Simpan Perubahan    
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection