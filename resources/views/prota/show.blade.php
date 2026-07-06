@extends('layouts.adminlte')

@section('title', 'Detail Prota')

@section('content')


<div class="mb-3 no-print">

    @if($prota->status_verifikasi == 'Revisi')

    <div class="alert alert-danger">

        <strong>Catatan Revisi:</strong>

        <br>

        {{ $prota->catatan_revisi }}

    </div>

    @endif

</div>

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                Program Tahunan (PROTA)
            </h3>

            <div class="card-tools">

                <a href="{{ route('prota.index') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                @if($prota->status_verifikasi == 'Disetujui')
                <a href="{{ route('prota.pdf', $prota->id_prota) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Unduh PDF
                </a>
                @endif

                @if($prota->status_verifikasi != 'Disetujui')

                <a href="{{ route('prota.edit', $prota->id_prota) }}"
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
                        {{ $prota->administrasi->pengguna->nama }}
                    </td>
                </tr>

                <tr>
                    <th>Mata Pelajaran</th>
                    <td>
                        {{ $prota->administrasi->mapel->nama_mapel }}
                    </td>
                </tr>

                <tr>
                    <th>Kelas</th>
                    <td>
                        {{ $prota->administrasi->kelas->nama }}
                    </td>
                </tr>

                <tr>
                    <th>Fase</th>
                    <td>
                        {{ $prota->administrasi->kelas->fase }}
                    </td>
                </tr>

                <tr>
                    <th>Tahun Ajaran</th>
                    <td>
                        {{ $prota->administrasi->periode->tahun_ajaran }}
                    </td>
                </tr>

                <tr>
                    <th>Status Verifikasi</th>
                    <td>

                        @if($prota->status_verifikasi == 'Disetujui')

                        <span class="badge badge-success">
                            Disetujui
                        </span>

                        @elseif($prota->status_verifikasi == 'Revisi')

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

</div>

<div class="card">

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="5%">No</th>

                    <th>
                        Alur Tujuan Pembelajaran
                    </th>

                    <th width="15%">
                        Jumlah JP
                    </th>

                    <th width="10%">
                        Semester
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($prota->protaDetail as $detail)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $detail->atpDetail->alur_tujuan_pembelajaran }}
                    </td>

                    <td>
                        {{ $detail->alokasi_waktu }}
                    </td>

                    <td>
                        {{ $detail->semester }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <hr>
        <div class="row mb-3">

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <i class="fas fa-calculator"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            Total JP
                        </span>

                        <span class="info-box-number">
                            {{ $prota->total_jp }} JP
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success">
                        <i class="fas fa-calendar-week"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            Alokasi Per Minggu
                        </span>

                        <span class="info-box-number">
                            {{ $prota->alokasi_per_minggu }} JP
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-warning">
                        <i class="fas fa-calendar-alt"></i>
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">
                            Alokasi Per Tahun
                        </span>

                        <span class="info-box-number">
                            {{ $prota->total_jp }} JP
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</div>
@endsection