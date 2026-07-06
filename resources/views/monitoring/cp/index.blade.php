@extends('layouts.adminlte')

@section('title', 'Monitoring Analisis CP')

@section('content')

<div class="container-fluid">

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-clipboard-check"></i>
                Monitoring Analisis CP

            </h3>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-striped">

                    <thead class="text-center">

                        <tr>

                            <th width="5%">No</th>
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Fase</th>
                            <th>Mata Pelajaran</th>
                            <th>Periode</th>
                            <th width="10%">Elemen</th>
                            <th width="10%">TP</th>
                            <th width="12%">Total JP</th>
                            <th width="12%">Status</th>
                            <th width="8%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($cp as $item)

                        @php

                        $jumlahElemen = $item->detail->count();

                        $jumlahTP = 0;

                        $totalJP = 0;

                        foreach($item->detail as $detail){

                        $jumlahTP += $detail->atpDetail->count();

                        foreach($detail->atpDetail as $tp){

                        $totalJP += (int) filter_var(
                        $tp->alokasi_waktu,
                        FILTER_SANITIZE_NUMBER_INT
                        );
                        }
                        }

                        @endphp

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->administrasi->pengguna->nama ?? '-' }}
                            </td>

                            <td class="text-center">

                                <span class="badge badge-primary">

                                    {{ $item->administrasi->kelas->nama ?? '-' }}

                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge badge-info">

                                    {{ $item->administrasi->kelas->fase ?? '-' }}

                                </span>

                            </td>

                            <td>

                                {{ $item->administrasi->mapel->nama_mapel ?? '-' }}

                            </td>

                            <td>

                                {{ $item->administrasi->periode->tahun_ajaran ?? '-' }}

                                <br>

                                <small class="text-muted">

                                    Semester
                                    {{ $item->administrasi->periode->semester ?? '-' }}

                                </small>

                            </td>

                            <td class="text-center">

                                <span class="badge badge-success">

                                    {{ $jumlahElemen }}

                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge badge-info">

                                    {{ $jumlahTP }}

                                </span>

                            </td>

                            <td class="text-center">

                                <span class="badge badge-secondary">

                                    {{ $totalJP }} JP

                                </span>

                            </td>

                            <td class="text-center">

                                @if($item->status_verifikasi == 'Menunggu')

                                <span class="badge badge-warning">
                                    Menunggu
                                </span>

                                @elseif($item->status_verifikasi == 'Disetujui')

                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                                @elseif($item->status_verifikasi == 'Revisi')

                                <span class="badge badge-danger">
                                    Revisi
                                </span>

                                @else

                                <span class="badge badge-secondary">
                                    -
                                </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <a href="{{ route('monitoring.cp.show', $item->id_cp) }}"
                                    class="btn btn-info btn-sm"
                                    title="Detail">

                                    <i class="fas fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="11"
                                class="text-center text-muted">

                                Belum ada data Analisis CP.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection