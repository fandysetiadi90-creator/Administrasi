@extends('layouts.adminlte')

@section('title','Modul Ajar')

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
<div class="card">
    <div class="card-body">
        <div class="card-tools">

                <a href="{{ route('monitoring.modul-ajar') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>
        <div class="text-center mb-3">
            <h4>MODUL AJAR</h4>
            <h5>{{ $modulAjar->judul_modul }}</h5>
            <hr>
        </div>

        <h6><b>1. Identitas Modul</b></h6>

        <table class="table table-bordered">
            <tr>
                <td width="200">Mapel</td>
                <td>{{ $modulAjar->administrasi->mapel->nama_mapel ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $modulAjar->administrasi->kelas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>{{ $modulAjar->atpDetail->first()->semester ?? '-' }}</td>
            </tr>
        </table>

        <br>

        <h6><b>2. Desain Pembelajaran</b></h6>

        <div class="border p-3 mb-3">

            <p><b>Capaian Pembelajaran:</b></p>
            <p>
                {{ $modulAjar->cpDetail->capaian_pembelajaran ?? '-' }}
            </p>

            <hr>

            <p><b>Tujuan Pembelajaran:</b></p>

            <ol>
                @forelse($modulAjar->atpDetail as $tp)
                    <li>{{ $tp->tujuan_pembelajaran }}</li>
                @empty
                    <li>-</li>
                @endforelse
            </ol>

        </div>

        <br>

        <h6><b>3. Identifikasi</b></h6>
        <div class="border p-3">
            {!! $modulAjar->identifikasi ?? '-' !!}
        </div>

        <br>

        <h6><b>4. Pengalaman Belajar</b></h6>
        <div class="border p-3">
            {!! $modulAjar->pengalaman_belajar ?? '-' !!}
        </div>

        <br>

        <h6><b>5. Asesmen</b></h6>
        <div class="border p-3">
            {!! $modulAjar->asesmen ?? '-' !!}
        </div>

        <br>
        @if($modulAjar->status_verifikasi == 'Menunggu')

        <div class="card-footer">

            <form action="{{ route('monitoring.modul-ajar.verifikasi', $modulAjar->id_modul_ajar) }}"
                method="POST"
                class="d-inline">

                @csrf
                @method('PUT')

                <button type="submit"
                    class="btn btn-success">

                    <i class="fas fa-check"></i>
                    Setujui

                </button>

            </form>

            <button
                class="btn btn-danger"
                data-toggle="modal"
                data-target="#modalRevisi">

                <i class="fas fa-times"></i>
                Revisi

            </button>

        </div>

        @endif
    </div>
</div>

<div class="modal fade"
    id="modalRevisi">

    <div class="modal-dialog">

        <form action="{{ route('monitoring.modul-ajar.revisi', $modulAjar->id_modul_ajar) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Catatan Revisi
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Catatan Revisi
                        </label>

                        <textarea
                            name="catatan_revisi"
                            rows="5"
                            class="form-control"
                            required></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                        class="btn btn-danger">

                        Kirim Revisi

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection