@extends('layouts.adminlte')
@section('title', 'Tambah Kelas')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-success">

                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Wali Kelas</label>

                            <select name="id_pengguna"
                                class="form-control"
                                required>
                                <option value="">
                                    -- Pilih Wali Kelas --
                                </option>

                                @foreach($pengguna as $p)
                                <option value="{{ $p->id_pengguna }}"
                                    {{ old('id_pengguna') == $p->id_pengguna ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Kelas</label>

                            <input type="text"
                                name="nama"
                                class="form-control"
                                value="{{ old('nama') }}"
                                placeholder="1A"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Fase</label>
                            <input type="text"
                                name="fase"
                                class="form-control"
                                value="{{ old('fase') }}"
                                placeholder="A"
                                required>

                            
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>

                            <textarea name="deskripsi"
                                rows="4"
                                class="form-control"
                                placeholder="Opsional">{{ old('deskripsi') }}</textarea>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('kelas.index') }}"
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