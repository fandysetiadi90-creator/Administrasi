@extends('layouts.adminlte')

@section('title', 'Data Periode')

@section('content')

<div class="container-fluid">

    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-calendar-alt"></i>
                Data Periode
            </h3>

            <div class="card-tools">
                <a href="{{ route('periode.create') }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Periode
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover table-striped">

                <thead class="thead-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($periode as $item)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>{{ $item->tahun_ajaran }}</strong>
                        </td>

                        <td class="text-center">
                            @if($item->semester == 'Ganjil')
                            <span class="badge badge-info">
                                Ganjil
                            </span>
                            @else
                            <span class="badge badge-warning">
                                Genap
                            </span>
                            @endif
                        </td>

                        <td class="text-center">

                            @if($item->status == 'Aktif')
                            <span class="badge badge-success">
                                Aktif
                            </span>
                            @else
                            <span class="badge badge-secondary">
                                Nonaktif
                            </span>
                            @endif

                        </td>

                        <td class="text-center">

                            <a href="{{ route('periode.edit', $item->id_periode) }}"
                                class="btn btn-warning btn-sm"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('periode.destroy', $item->id_periode) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data periode ini?')">

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
                        <td colspan="5"
                            class="text-center text-muted">
                            Data periode belum tersedia.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection