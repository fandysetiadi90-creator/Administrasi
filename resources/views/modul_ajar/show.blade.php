@extends('layouts.adminlte')

@section('title','Detail Modul Ajar')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #000;
    }

    th, td {
        padding: 6px;
    }
</style>

<div class="mb-3 no-print">

    @if($modul->status_verifikasi == 'Revisi')

    <div class="alert alert-danger">

        <strong>Catatan Revisi:</strong>

        <br>

        {{ $modul->catatan_revisi }}

    </div>

    @endif

</div>
<div class="card">
    <div class="card-body">
        <div class="card-header">

            <div class="card-tools">

                <a href="{{ route('modul-ajar.index') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                @if($modul->status_verifikasi == 'Disetujui')
                <a href="{{ route('modul-ajar.pdf', $modul->id_modul_ajar) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Unduh PDF
                </a>
                @endif

                @if($modul->status_verifikasi != 'Disetujui')

                <a href="{{ route('modul-ajar.edit', $modul->id_modul_ajar) }}"
                    class="btn btn-warning">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

                @endif


            </div>
        </div>
        <div class="text-center mb-3">
            <h4>MODUL AJAR</h4>
            <h5>{{ $modul->judul_modul }}</h5>
            <hr>
        </div>
        

        <h6><b>1. Identitas Modul</b></h6>

        <table class="table table-bordered">
            <tr>
                <td width="200">Mapel</td>
                <td>{{ $modul->administrasi->mapel->nama_mapel ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $modul->administrasi->kelas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>{{ $modul->atpDetail->first()->semester ?? '-' }}</td>
            </tr>
        </table>

        <br>

        <h6><b>2. Desain Pembelajaran</b></h6>

        <div class="border p-3 mb-3">

            <p><b>Capaian Pembelajaran:</b></p>
            <p>
                {{ $modul->cpDetail->capaian_pembelajaran ?? '-' }}
            </p>

            <hr>

            <p><b>Tujuan Pembelajaran:</b></p>

            <ol>
                @forelse($modul->atpDetail as $tp)
                    <li>{{ $tp->tujuan_pembelajaran }}</li>
                @empty
                    <li>-</li>
                @endforelse
            </ol>

        </div>

        <br>

        <h6><b>3. Identifikasi</b></h6>
        <div class="border p-3">
            {!! $modul->identifikasi ?? '-' !!}
        </div>

        <br>

        <h6><b>4. Pengalaman Belajar</b></h6>
        <div class="border p-3">
            {!! $modul->pengalaman_belajar ?? '-' !!}
        </div>

        <br>

        <h6><b>5. Asesmen</b></h6>
        <div class="border p-3">
            {!! $modul->asesmen ?? '-' !!}
        </div>

    </div>
</div>

@endsection