@extends('layouts.adminlte')

@section('title', 'Detail Analisis CP')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Analisis CP
            </h3>

            <div class="card-tools">

                <a href="{{ route('cp.index') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                @if($cp->status_verifikasi == 'Disetujui')
                <a href="{{ route('cp.pdf', $cp->id_cp) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Unduh PDF
                </a>
                @endif

                @if($cp->status_verifikasi != 'Disetujui')

                <a href="{{ route('cp.edit', $cp->id_cp) }}"
                    class="btn btn-warning">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

                @endif

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

                        @php
                        $semesterFirstRow = !isset($printed[$detail->id_cp_detail][$tp->semester]);
                        $printed[$detail->id_cp_detail][$tp->semester] = true;
                        @endphp

                        @if($semesterFirstRow)
                            <td class="text-center" rowspan="{{ $detail->atpDetail->where('semester', $tp->semester)->count() }}">
                                Semester {{ $tp->semester }}
                            </td>
                        @endif

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

    <div class="row">

        <div class="col-md-6">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>{{ $totalTP }}</h3>

                    <p>Total Tujuan Pembelajaran</p>

                </div>

                <div class="icon">
                    <i class="fas fa-list"></i>
                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>{{ $totalJP }} JP</h3>

                    <p>Total Alokasi Waktu</p>

                </div>

                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>

            </div>

        </div>

    </div>

    @if($cp->status_verifikasi == 'Revisi'
    && $cp->catatan_revisi)

    <div class="card card-danger">

        <div class="card-header">

            <h3 class="card-title">

                Catatan Revisi

            </h3>

        </div>

        <div class="card-body">

            {!! nl2br(e($cp->catatan_revisi)) !!}

        </div>

    </div>

    @endif

</div>

@endsection