@extends('layouts.adminlte')

@section('title', 'Edit Periode')

@section('content')

<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6 float-left">

                <a href="{{ route('periode.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>

    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card card-outline card-warning">

            <div class="card-header">
                <h3 class="card-title">
                    Form Edit Periode
                </h3>
            </div>

            <form action="{{ route('periode.update', $periode->id_periode) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="form-group">

                        <label for="tahun_ajaran">
                            Tahun Ajaran
                        </label>

                        <input type="text"
                               name="tahun_ajaran"
                               id="tahun_ajaran"
                               class="form-control @error('tahun_ajaran') is-invalid @enderror"
                               value="{{ old('tahun_ajaran', $periode->tahun_ajaran) }}"
                               placeholder="Contoh: 2025/2026">

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
                                class="form-control @error('semester') is-invalid @enderror">

                            <option value="">
                                -- Pilih Semester --
                            </option>

                            <option value="Ganjil"
                                {{ old('semester', $periode->semester) == 'Ganjil' ? 'selected' : '' }}>

                                Ganjil

                            </option>

                            <option value="Genap"
                                {{ old('semester', $periode->semester) == 'Genap' ? 'selected' : '' }}>

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
                                class="form-control @error('status') is-invalid @enderror">

                            <option value="">
                                -- Pilih Status --
                            </option>

                            <option value="Aktif"
                                {{ old('status', $periode->status) == 'Aktif' ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="Nonaktif"
                                {{ old('status', $periode->status) == 'Nonaktif' ? 'selected' : '' }}>

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

                    <button type="submit"
                            class="btn btn-warning">

                        <i class="fas fa-save"></i>
                        Simpan Perubahan        

                    </button>

                </div>

            </form>

        </div>

    </div>
</section>

@endsection