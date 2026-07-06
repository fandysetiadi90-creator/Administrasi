@extends('layouts.adminlte')

@section('title', 'Detail Analisis CP')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Detail Analisis CP
            </h3>

            <div class="card-tools">

                <a href="{{ route('monitoring.cp') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="20%">Guru</th>
                    <td>
                        {{ $cp->administrasi->pengguna->nama }}
                    </td>
                </tr>

                <tr>
                    <th>Mata Pelajaran</th>
                    <td>
                        {{ $cp->administrasi->mapel->nama_mapel }}
                    </td>
                </tr>

                <tr>
                    <th>Kelas</th>
                    <td>
                        {{ $cp->administrasi->kelas->nama }}
                    </td>
                </tr>

                <tr>
                    <th>Fase</th>
                    <td>
                        {{ $cp->administrasi->kelas->fase }}
                    </td>
                </tr>

                <tr>
                    <th>Tahun Ajaran</th>
                    <td>
                        {{ $cp->administrasi->periode->tahun_ajaran }}
                    </td>
                </tr>

                <tr>
                    <th>Status Verifikasi</th>
                    <td>

                        @if($cp->status_verifikasi == 'Disetujui')

                        <span class="badge badge-success">
                            Disetujui
                        </span>

                        @elseif($cp->status_verifikasi == 'Revisi')

                        <span class="badge badge-danger">
                            Revisi
                        </span>

                        @else

                        <span class="badge badge-warning">
                            Menunggu
                        </span>

                        @endif

                    </td>
                </tr>

            </table>

            @if($cp->catatan_revisi)

            <div class="alert alert-danger">

                <strong>Catatan Revisi :</strong>

                <br>

                {{ $cp->catatan_revisi }}

            </div>

            @endif

        </div>

    </div>

    <div class="card card-success">

        <div class="card-header">

            <h3 class="card-title">
                Analisis Capaian Pembelajaran
            </h3>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-sm">

                <thead class="text-center bg-light">

                    <tr>

                        <th width="15%">
                            Elemen
                        </th>

                        <th width="25%">
                            Capaian Pembelajaran
                        </th>

                        <th width="8%">
                            Semester
                        </th>

                        <th width="20%">
                            Tujuan Pembelajaran
                        </th>

                        <th width="22%">
                            Alur Tujuan Pembelajaran
                        </th>

                        <th width="10%">
                            Alokasi Waktu
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @php
                    $totalTP = 0;
                    $totalJP = 0;
                    @endphp

                    @foreach($cp->detail as $detail)

                    @php

                    $jumlahBaris = $detail->atpDetail->count();

                    $firstRow = true;

                    @endphp

                    @foreach($detail->atpDetail as $tp)

                    @php

                    $totalTP++;

                    $jp = (int) filter_var(
                    $tp->alokasi_waktu,
                    FILTER_SANITIZE_NUMBER_INT
                    );

                    $totalJP += $jp;

                    @endphp

                    <tr>

                        @if($firstRow)

                        <td rowspan="{{ $jumlahBaris }}"
                            style="vertical-align: top;">

                            {{ $detail->elemen }}

                        </td>

                        <td rowspan="{{ $jumlahBaris }}"
                            style="vertical-align: top;">

                            {!! nl2br(e($detail->capaian_pembelajaran)) !!}

                        </td>

                        @php
                        $firstRow = false;
                        @endphp

                        @endif

                        <td class="text-center">

                            Semester {{ $tp->semester }}

                        </td>

                        <td>

                            {!! nl2br(e($tp->tujuan_pembelajaran)) !!}

                        </td>

                        <td>

                            {!! nl2br(e($tp->alur_tujuan_pembelajaran)) !!}

                        </td>

                        <td class="text-center">

                            {{ $tp->alokasi_waktu . ' JP' }}

                        </td>

                    </tr>

                    @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    @if($cp->status_verifikasi == 'Menunggu')

    <div class="card-footer">

        <form action="{{ route('monitoring.cp.approve', $cp->id_cp) }}"
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

<div class="modal fade"
    id="modalRevisi">

    <div class="modal-dialog">

        <form action="{{ route('monitoring.cp.revisi', $cp->id_cp) }}"  
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