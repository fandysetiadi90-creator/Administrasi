@extends('layouts.adminlte')

@section('title', 'Monitoring Program Tahunan')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Program Tahunan (PROTA)
            </h3>

        </div>

        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th width="50">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Total JP</th>
                            <th>JP / Minggu</th>
                            <th>Jumlah ATP</th>
                            <th>Status</th>
                            <th width="120">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($prota as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->administrasi->mapel->nama_mapel ?? '-' }}
                            </td>

                            <td>
                                {{ $item->administrasi->kelas->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item->administrasi->periode->tahun_ajaran ?? '-' }}
                            </td>

                            <td>
                                {{ $item->total_jp }} JP
                            </td>

                            <td>
                                {{ $item->alokasi_per_minggu }} JP
                            </td>

                            <td>
                                {{ $item->prota_detail_count }}
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

                                @else

                                <span class="badge badge-danger">
                                    Revisi
                                </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('monitoring.prota.show', $item->id_prota) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9"
                                class="text-center">

                                Belum ada data Prota

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