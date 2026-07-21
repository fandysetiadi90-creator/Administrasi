@extends('layouts.adminlte')
@section('title', 'Edit Pengguna')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i>
                        Edit Pengguna
                    </h3>
                </div>

                <form action="{{ route('pengguna.update', $pengguna->id_pengguna) }}"
                    method="POST"
                    enctype="multipart/form-data">

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
                            <label>Email</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $pengguna->email) }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text"
                                name="nama"
                                class="form-control"
                                value="{{ old('nama', $pengguna->nama) }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text"
                                name="nomor_induk"
                                oninput="this.value=this.value.replace(/[^0-9-]/g,'')"
                                class="form-control"
                                value="{{ old('nomor_induk', $pengguna->nomor_induk) }}"
                                placeholder="Masukkan nomor induk">
                        </div>

                        @if(auth()->user()->jabatan == 'Admin')
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="jabatan" class="form-control" required>

                                <option value="Admin"
                                    {{ old('jabatan', $pengguna->jabatan) == 'Admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="Kepala Sekolah"
                                    {{ old('jabatan', $pengguna->jabatan) == 'Kepala Sekolah' ? 'selected' : '' }}>
                                    Kepala Sekolah
                                </option>

                                <option value="Wali Kelas"
                                    {{ old('jabatan', $pengguna->jabatan) == 'Wali Kelas' ? 'selected' : '' }}>
                                    Wali Kelas
                                </option>

                            </select>
                        </div>
                        @else
                            <input type="hidden" name="jabatan" value="{{ $pengguna->jabatan }}">
                        @endif

                        <div class="form-group text-center">
                            <label>Foto Saat Ini</label>
                            <br>

                            <img id="preview-image"
                                src="{{ $pengguna->poto 
                                        ? asset('storage/poto/' . $pengguna->poto) 
                                        : 'https://via.placeholder.com/150?text=Preview' }}"    
                                class="img-circle elevation-2"
                                width="150"
                                height="150"
                                style="object-fit: cover; border: 2px solid #ddd;">

                        </div>


                        <div class="form-group">
                            <label>Ganti Foto</label>

                            <div class="custom-file">
                                <input type="file"
                                    name="poto"
                                    class="custom-file-input"
                                    id="poto"
                                    accept="image/*">

                                <label class="custom-file-label" for="poto">
                                    Pilih file...
                                </label>
                            </div>

                            <small class="text-muted">
                                Kosongkan jika tidak ingin mengganti foto.
                            </small>

                        </div>


                    </div>

                    <div class="card-footer text-right">
                        @if(auth()->user()->jabatan == 'Admin')
                            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        @endif

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

@section('scripts')

<script>
    $(document).ready(function() {

        $('#poto').on('change', function() {

            const file = this.files[0];

            if (file) {

                // Tampilkan nama file
                $(this).next('.custom-file-label').html(file.name);

                // Preview gambar
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                };

                reader.readAsDataURL(file);
            }

        });

    });
</script>

@endsection