@extends('layouts.adminlte')

@section('title', 'Data Siswa')

@section('content')

<div class="content-header">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

            <div>
                <p class="text-muted mb-0">
                    Kelas :
                    <strong>{{ $kelas->nama ?? '-' }}</strong>
                </p>
            </div>

            <div class="mt-2 mt-md-0">

                <a href="{{ route('siswa.create', $kelas->id_kelas) }}"
                    class="btn btn-success">

                    <i class="fas fa-plus-circle"></i>
                    Tambah Siswa
                </a>

            </div>
        </div>

        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-excel text-success"></i>
                    Import Data Siswa
                </h3>
            </div>

            <div class="card-body">

                <form action="{{ route('siswa.import', $kelas->id_kelas) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <div class="col-md-10">
                            <div class="form-group mb-md-0">
                                <input type="file"
                                    name="file_excel"
                                    class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit"
                                class="btn btn-success btn-block">

                                <i class="fas fa-upload"></i>
                                Import
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table"></i>
                    List Siswa
                </h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="table-siswa"
                        class="table table-bordered table-striped">

                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>Tempat lahir</th>
                                <th>Tanggal lahir</th>
                                <th>Agama</th>
                                <th>Alamat</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($siswa as $item)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item->nama }}
                                </td>

                                <td>
                                    {{ $item->nis }}
                                </td>

                                <td>
                                    {{ $item->tempat_lahir }}
                                </td>

                                <td>
                                    {{ $item->tgl_lahir }}
                                </td>

                                <td>
                                    {{ $item->agama }}
                                </td>

                                <td>
                                    {{ $item->alamat }}
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('siswa.edit', $item->id_siswa) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('siswa.destroy', $item->id_siswa) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data siswa ini?')">

                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center text-muted">

                                    Belum ada data siswa.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection