@extends('layouts.adminlte')
@section('title', 'Tambah Pengguna')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus"></i>
                        Tambah Pengguna
                    </h3>
                </div>

                <form action="{{ route('pengguna.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text"
                                name="nama"
                                class="form-control"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Nomor Induk</label>
                            <input type="text"
                                name="nomor_induk"
                                class="form-control"
                                value="{{ old('nomor_induk') }}"
                                placeholder="Masukkan nomor induk">
                        </div>

                        <div class="form-group">
                            <label>Jabatan</label>
                            <select name="jabatan" class="form-control" required>
                                <option value="">-- Pilih Jabatan --</option>

                                <option value="Admin"
                                    {{ old('jabatan') == 'Admin' ? 'selected' : '' }}
                                    {{ $adminExists ? 'disabled' : '' }}>
                                    Admin
                                </option>

                                <option value="Kepala Sekolah"
                                    {{ old('jabatan') == 'Kepala Sekolah' ? 'selected' : '' }}
                                    {{ $kepsekExists ? 'disabled' : '' }}>
                                    Kepala Sekolah
                                </option>

                                <option value="Wali Kelas"
                                    {{ old('jabatan') == 'Wali Kelas' ? 'selected' : '' }}>
                                    Wali Kelas
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Upload Foto</label>

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
                                Format: JPG, JPEG, PNG (maks. 2 MB)
                            </small>

                            <div class="mt-3 text-center">
                                <img id="preview-image"
                                    src="https://via.placeholder.com/150x150?text=Preview"
                                    class="img-thumbnail"
                                    width="150"
                                    height="150"
                                    style="object-fit: cover;">
                            </div>

                        </div>


                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('pengguna.index') }}"
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

@section('scripts')

<script>
$(document).ready(function () {

    $('#poto').on('change', function () {

        const file = this.files[0];

        if (file) {

            // Tampilkan nama file
            $(this).next('.custom-file-label').html(file.name);

            // Preview gambar
            const reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
            };

            reader.readAsDataURL(file);
        }

    });

});
</script>

@endsection

