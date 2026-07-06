@extends('layouts.adminlte')

@section('title', 'Tambah Periode')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-plus"></i>
                        Form Tambah Periode
                    </h3>
                </div>

                <form action="{{ route('periode.store') }}"
                    method="POST">

                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label for="tahun_ajaran">
                                Tahun Ajaran
                            </label>

                            <input type="text"
                                name="tahun_ajaran"
                                id="tahun_ajaran"
                                class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                value="{{ old('tahun_ajaran') }}"
                                placeholder="Contoh: 2025/2026"
                                required>

                            <small class="text-muted">
                                Format: YYYY/YYYY
                            </small>

                            @error('tahun_ajaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="semester">
                                Semester
                            </label>

                            <select name="semester"
                                id="semester"
                                class="form-control @error('semester') is-invalid @enderror"
                                required>

                                <option value="">
                                    -- Pilih Semester --
                                </option>

                                <option value="Ganjil"
                                    {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>
                                    Ganjil
                                </option>

                                <option value="Genap"
                                    {{ old('semester') == 'Genap' ? 'selected' : '' }}>
                                    Genap
                                </option>

                            </select>

                            @error('semester')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">
                                Status
                            </label>

                            <select name="status"
                                id="status"
                                class="form-control @error('status') is-invalid @enderror"
                                required>

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="Aktif"
                                    {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="Nonaktif"
                                    {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>

                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer text-right">

                        <a href="{{ route('periode.index') }}"
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