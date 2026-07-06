@extends('layouts.adminlte')

@section('title', 'Data Mata Pelajaran')

@section('content')

<div class="container-fluid">

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-book"></i>
                Daftar Mata Pelajaran
            </h3>

            <div class="card-tools">
                <a href="{{ route('mapel.create') }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Mapel
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">

            <table id="tableMapel"
                class="table table-bordered table-hover table-striped">

                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Nama Mapel</th>
                        <th>Deskripsi</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mapel as $item)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>{{ $item->nama_mapel }}</strong>
                        </td>

                        <td>
                            {{ $item->deskripsi ?? '-' }}
                        </td>

                        <td class="text-center">

                            <a href="{{ route('mapel.edit', $item->id_mapel) }}"
                                class="btn btn-warning btn-sm"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('mapel.destroy', $item->id_mapel) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data mata pelajaran belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection