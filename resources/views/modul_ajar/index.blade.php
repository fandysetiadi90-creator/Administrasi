@extends('layouts.adminlte')

@section('title', 'Modul Ajar')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Data Modul Ajar
        </h3>

        <div class="card-tools">
            <a href="{{ route('modul-ajar.create') }}"
               class="btn btn-primary btn-sm">

                Tambah Modul Ajar
            </a>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Modul</th>
                    <th>Mapel</th>
                    <th>Kelas</th>
                    <th>Elemen</th>
                    <th>Jumlah TP</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($modulAjar as $item)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->judul_modul }}
                    </td>

                    <td>
                        {{ $item->administrasi->mapel->nama_mapel ?? '-' }}
                    </td>

                    <td>
                        {{ $item->administrasi->kelas->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $item->cpDetail->elemen ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->atpDetail->count() }}
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

                        <a href="{{ route('modul-ajar.show', $item->id_modul_ajar) }}"
                           class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>  
                        </a>

                        <a href="{{ route('modul-ajar.edit', $item->id_modul_ajar) }}"
                           class="btn btn-warning btn-sm">
                           <i class="fas fa-edit"></i>

                        </a>

                        <form
                            action="{{ route('modul-ajar.destroy', $item->id_modul_ajar) }}"
                            method="POST"
                            style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" class="text-center">
                        Belum ada data Modul Ajar
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection