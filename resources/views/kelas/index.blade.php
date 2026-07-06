@extends('layouts.adminlte')
@section('title', 'Data Kelas')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('kelas.create') }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Kelas
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Foto</th>
                        <th>Nama Kelas</th>
                        <th>Fase</th>
                        <th>Wali Kelas</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kelas as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($k->pengguna && $k->pengguna->poto)
                            <img src="{{ asset('storage/poto/' . $k->pengguna->poto) }}"
                                class="img-circle elevation-2"
                                width="60"
                                height="60"
                                style="object-fit: cover;">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($k->pengguna->nama ?? 'User') }}"
                                class="img-circle elevation-2"
                                width="60"
                                height="60">
                            @endif
                        </td>

                        <td>
                            <strong>{{ $k->nama }}</strong>
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ $k->fase ?? '-' }}
                            </span>
                        </td>

                        <td>
                            {{ $k->pengguna->nama ?? '-' }}
                        </td>

                        <td>

                            <a href="{{ route('kelas.edit', $k->id_kelas) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('kelas.destroy', $k->id_kelas) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data kelas ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Data kelas belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        @if(method_exists($kelas, 'links'))
        <div class="card-footer clearfix">
            {{ $kelas->links() }}
        </div>
        @endif

    </div>

</div>

@endsection