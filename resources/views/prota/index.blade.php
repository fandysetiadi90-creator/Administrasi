@extends('layouts.adminlte')

@section('title', 'Program Tahunan')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Data Program Tahunan (PROTA)
            </h3>

            <div class="card-tools">

                <a href="{{ route('prota.create') }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-plus"></i>
                    Buat Prota

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table id="datatable"
                    class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th width="50">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Tahun Ajaran</th>
                            <th>Total JP</th>
                            <th>JP / Minggu</th>
                            <th>Status</th>
                            <th width="220">Aksi</th>
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
                                {{ $item->administrasi->periode->tahun_ajaran ?? '-' }}   
                            </td>

                            <td>
                                {{ $item->total_jp }} JP
                            </td>

                            <td>
                                {{ $item->alokasi_per_minggu }} JP
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

                                <a href="{{ route('prota.show', $item->id_prota) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                </a>

                                @if($item->status_verifikasi != 'Disetujui')
                                <a href="{{ route('prota.edit', $item->id_prota) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>
                                @endif

                                <form action="{{ route('prota.destroy', $item->id_prota) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus data Prota?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7"
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