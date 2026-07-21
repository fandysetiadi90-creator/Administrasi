@extends('layouts.adminlte')
@section('title', 'Data Pengguna')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('pengguna.create') }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Foto</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>NIP</th>    
                        <th>Jabatan</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($d->poto)
                            <img src="{{ asset('storage/poto/' . $d->poto) }}"
                                class="img-circle elevation-2"
                                width="60"
                                height="60"
                                style="object-fit: cover;">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($d->nama) }}"
                                class="img-circle elevation-2"
                                width="60"
                                height="60">
                            @endif
                        </td>

                        <td>{{ $d->email }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->nomor_induk ?? '-' }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ $d->jabatan }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('pengguna.edit', $d->id_pengguna) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('pengguna.destroy', $d->id_pengguna) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

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
                        <td colspan="7" class="text-center">
                            Data pengguna belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection