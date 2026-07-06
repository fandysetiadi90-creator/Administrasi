@extends('layouts.adminlte')

@section('title', 'Program Semester')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Data Program Semester
            </h3>

            <div class="card-tools">

                <a href="{{ route('prosem.create') }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-plus"></i>
                    Tambah

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                    id="datatable"
                    class="table table-bordered table-striped">

                    <thead>

                        <tr>
                            <th width="5%">No</th>
                            <th>Mata Pelajaran</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th> 
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($prosem as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->prota->administrasi->mapel->nama_mapel ?? '-' }}        
                            </td>

                            <td>
                                {{ $item->prota->administrasi->periode->tahun_ajaran ?? '-' }}  
                            </td>

                            <td>
                                {{ $item->semester ?? '-' }}
                            </td>

                            <td>    

                                @if($item->status_verifikasi == 'Disetujui')

                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                                @elseif($item->status_verifikasi == 'Revisi')

                                <span class="badge badge-danger">
                                    Revisi
                                </span>

                                @else

                                <span class="badge badge-warning">
                                    Menunggu
                                </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('prosem.show', $item->id_prosem) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                </a>

                                <a href="{{ route('prosem.edit', $item->id_prosem) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form
                                    action="{{ route('prosem.destroy', $item->id_prosem) }}"
                                    method="POST"
                                    style="display:inline-block">

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

                            <td colspan="6"
                                class="text-center">

                                Data belum tersedia

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

@section('scripts')

<script>
    $(function() {
        $('#datatable').DataTable();
    });
</script>

@endsection 
