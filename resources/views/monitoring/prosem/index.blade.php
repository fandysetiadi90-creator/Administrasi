@extends('layouts.adminlte')

@section('title', 'Monitoring Prosem')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Monitoring Program Semester (PROSEM)
            </h3>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th width="50">No</th>

                            <th>Mata Pelajaran</th>

                            <th>Kelas</th>

                            <th>Tahun Ajaran</th>

                            <th width="100">Semester</th>

                            <th width="100">Detail</th>

                            <th width="120">Status</th>

                            <th width="120">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($prosem as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->prota->administrasi->mapel->nama_mapel ?? '-' }}
                            </td>

                            <td>
                                {{ $item->prota->administrasi->kelas->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->prota->administrasi->periode->tahun_ajaran ?? '-' }}
                            </td>

                            <td>
                                Semester {{ $item->semester }}
                            </td>

                            <td class="text-center">
                                {{ $item->jumlah_prota_detail }}
                            </td>

                            <td>

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

                            <td>

                                <a href="{{ route('monitoring.prosem.show', $item->id_prosem) }}"
                                    class="btn btn-info btn-sm">    
                                    <i class="fas fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center">
                                Data PROSEM belum tersedia
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