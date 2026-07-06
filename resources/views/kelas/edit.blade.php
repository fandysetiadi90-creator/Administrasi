@extends('layouts.adminlte')
@section('title', 'Edit Kelas')

@section('content')


<form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="margin-bottom:20px;">

        <label>Wali Kelas</label>
        <br><br>

        <div style="display:flex; align-items:center; gap:15px; margin-bottom:10px;">

            @if($kelas->pengguna && $kelas->pengguna->poto)
                <img src="{{ asset('storage/poto/' . $kelas->pengguna->poto) }}"
                     width="70"
                     height="70"
                     style="border-radius:50%; object-fit:cover;">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($kelas->pengguna->nama ?? 'User') }}"
                     width="70"
                     height="70"
                     style="border-radius:50%;">
            @endif

            <div>
                <strong>{{ $kelas->pengguna->nama ?? '-' }}</strong>
                <br>
                <small>{{ $kelas->pengguna->jabatan ?? '-' }}</small>
            </div>

        </div>

        <select name="id_pengguna"
                style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"
                required>

            <option value="">-- Pilih Wali Kelas --</option>

            @foreach($pengguna as $p)
                <option value="{{ $p->id_pengguna }}"
                    {{ old('id_pengguna', $kelas->id_pengguna) == $p->id_pengguna ? 'selected' : '' }}>

                    {{ $p->nama }}

                </option>
            @endforeach

        </select>

    </div>

    <div style="margin-bottom:20px;">

        <label>Nama Kelas</label>
        <br><br>

        <input type="text"
               name="nama"
               value="{{ old('nama', $kelas->nama) }}"
               placeholder="Masukkan nama kelas"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"
               required>

    </div>

    <div style="margin-bottom:20px;">

        <label>Fase</label>
        <br><br>

        <input type="text"
               name="fase"
               value="{{ old('fase', $kelas->fase) }}"
               placeholder="Masukkan fase kelas"
               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;"
               required>

    </div>
    <div style="margin-bottom:20px;">

        <label>Deskripsi</label>
        <br><br>

        <textarea name="deskripsi"
                  rows="5"
                  placeholder="Masukkan deskripsi kelas"
                  style="width:100%; padding:10px; border:1px solid #ccc; border-radius:5px;">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>

    </div>

    <button type="submit"
            style="padding:10px 15px; background:green; color:white; border:none; border-radius:5px;">
        <i class="fas fa-save"></i>
        Simpan Perubahan                
    </button>



    <a href="{{ route('kelas.index') }}"
       style="padding:10px 15px; background:gray; color:white; text-decoration:none; border-radius:5px;">
       <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

</form>

@endsection