@extends('layouts.adminlte')
@section('title', 'Detail Kelas')

@section('content')

<h2>Detail Data Kelas</h2>

<br>

<div style="
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    max-width:700px;
">

    <!-- FOTO -->
    <div style="text-align:center; margin-bottom:20px;">

        @if($kelas->pengguna && $kelas->pengguna->poto)
            <img src="{{ asset('storage/poto/' . $kelas->pengguna->poto) }}"
                 width="120"
                 height="120"
                 style="border-radius:50%; object-fit:cover; border:3px solid #ddd;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($kelas->pengguna->nama ?? 'User') }}"
                 width="120"
                 height="120"
                 style="border-radius:50%;">
        @endif

    </div>

    <!-- DETAIL -->
    <table cellpadding="10" cellspacing="0" style="width:100%;">

        <tr>
            <th align="left" width="200">Nama Kelas</th>
            <td>: {{ $kelas->nama }}</td>
        </tr>

        <tr>
            <th align="left">Deskripsi</th>
            <td>: {{ $kelas->deskripsi ?? '-' }}</td>
        </tr>

        <tr>
            <th align="left">Wali Kelas</th>
            <td>: {{ $kelas->pengguna->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th align="left">Jabatan</th>
            <td>: {{ $kelas->pengguna->jabatan ?? '-' }}</td>
        </tr>

        <tr>
            <th align="left">Email</th>
            <td>: {{ $kelas->pengguna->email ?? '-' }}</td>
        </tr>
        <tr>
            <th align="left">Fase</th>
            <td>: {{ $kelas->fase ?? '-' }}</td>
        </tr>
        <tr>
            <th align="left">Nomor Induk</th>
            <td>: {{ $kelas->pengguna->nomor_induk ?? '-' }}</td>
        </tr>

    </table>

    <br>

    <a href="{{ route('kelas.index') }}"
       style="padding:10px 15px; background:gray; color:white; text-decoration:none; border-radius:5px;">
       Kembali
    </a>

    <a href="{{ route('kelas.edit', $kelas->id_kelas) }}"
       style="padding:10px 15px; background:blue; color:white; text-decoration:none; border-radius:5px;">
       Edit
    </a>

</div>

@endsection