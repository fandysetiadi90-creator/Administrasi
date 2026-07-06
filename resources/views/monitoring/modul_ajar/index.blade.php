@extends('layouts.adminlte')

@section('title', 'Monitoring Modul Ajar')

@section('content')

<div class="container-fluid">

    {{-- ================================= --}}
    {{-- SUMMARY CARD --}}
    {{-- ================================= --}}
    <div class="row">

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $menunggu }}</h3>
                    <p>Menunggu Verifikasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $disetujui }}</h3>
                    <p>Disetujui</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $revisi }}</h3>
                    <p>Revisi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Data Modul Ajar</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Guru</th>
                        <th>Mapel</th>
                        <th>Kelas</th>
                        <th>Judul Modul</th>
                        <th>CP</th>
                        <th>TP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($modulAjar as $no => $m)
                    <tr>

                        <td>{{ $no + 1 }}</td>

                        <td>
                            {{ $m->administrasi->pengguna->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $m->administrasi->mapel->nama_mapel ?? '-' }}
                        </td>

                        <td>
                            {{ $m->administrasi->kelas->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $m->judul_modul }}
                        </td>

                        <td>
                            {{ $m->cpDetail->elemen ?? '-' }}
                        </td>

                        <td>
                            {{ $m->atpDetail->count() }} TP
                        </td>

                        <td>
                            @if($m->status_verifikasi == 'Menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($m->status_verifikasi == 'Disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Revisi</span>
                            @endif
                        </td>

\                        <td>
                            <a href="{{ route('monitoring.modul-ajar.show', $m->id_modul_ajar) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            Tidak ada data modul ajar
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection