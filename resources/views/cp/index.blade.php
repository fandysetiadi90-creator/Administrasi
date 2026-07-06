@extends('layouts.adminlte')

@section('title', 'Analisis Capaian Pembelajaran')

@section('content')

<div class="container-fluid">

    <div class="card     card-primary">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-book-reader"></i>
                Analisis Capaian Pembelajaran
            </h3>

            <div class="card-tools">

                <a href="{{ route('cp.create') }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-plus"></i>
                    Tambah Analisis CP

                </a>

            </div>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover table-striped">

                <thead class="thead-light text-center">

                    <tr>
                        <th width="5%">No</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Periode</th>
                        <th width="10%">Elemen</th>
                        <th width="10%">TP / ATP</th>
                        <th width="12%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($cp as $item)

                    @php

                    $totalTp = 0;

                    foreach($item->detail as $detail){

                    $totalTp += $detail->atpDetail->count();

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

                            <br>

                            <small class="text-muted">
                                Fase {{ $item->administrasi->kelas->fase ?? '-' }}
                            </small>

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

                                {{ $item->detail->count() }}
                                Elemen

                            </span>

                        </td>

                        <td class="text-center">

                            <span class="badge badge-info">

                                {{ $totalTp }}
                                TP/ATP

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

                            <a href="{{ route('cp.show', $item->id_cp) }}"
                                class="btn btn-info btn-sm"
                                title="Detail">

                                <i class="fas fa-eye"></i>

                            </a>

                            @if($item->status_verifikasi != 'Disetujui')

                            <a href="{{ route('cp.edit', $item->id_cp) }}"
                                class="btn btn-warning btn-sm"
                                title="Edit">

                                <i class="fas fa-edit"></i>
                    
                            </a>

                            @endif

                            <form
                                action="{{ route('cp.destroy', $item->id_cp) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus Analisis CP ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Hapus">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9"
                            class="text-center text-muted">

                            Data Analisis CP belum tersedia.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection