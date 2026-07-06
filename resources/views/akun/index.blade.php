@extends('layouts.adminlte')
@section('title', 'Data Akun')

@section('content')

<div class="container-fluid">


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users-cog"></i>
                Data Akun
            </h3>

            <div class="card-tools">
                <a href="{{ route('akun.create') }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Akun
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>{{ $d->pengguna->email }}</td>

                        <td>{{ $d->pengguna->nama }}</td>

                        <td class="text-center">

                            <a href="{{ route('akun.edit', $d->id_akun) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-key"></i>
                            </a>

                            <form action="{{ route('akun.destroy', $d->id_akun) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
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
                        <td colspan="4" class="text-center">
                            Data akun belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection