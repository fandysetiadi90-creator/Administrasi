@extends('layouts.adminlte')

@section('title', 'Monitoring Kelengkapan Administrasi')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">

            <h3 class="card-title">
                Monitoring Kelengkapan Administrasi
            </h3>

        </div>

        <div class="card-body">

            <table id="tabel-monitoring"
                class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th width="5%">No</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Terpenuhi</th>
                        <th>Persentase</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($hasil as $index => $item)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            {{ $item['administrasi']->pengguna->nama }}
                        </td>

                        <td>
                            {{ $item['administrasi']->mapel->nama_mapel }}
                        </td>

                        <td>
                            {{ $item['administrasi']->kelas->nama }}
                        </td>

                        <td>
                            {{ $item['administrasi']->periode->tahun_ajaran }}
                        </td>

                        <td>

                            {{ $item['jumlah_terpenuhi'] }}
                            /
                            {{ $item['jumlah_wajib'] }}

                        </td>

                        <td>

                            <span class="badge badge-info">

                                {{ $item['persentase'] }}%

                            </span>

                        </td>

                        <td>

                            @if($item['status'] == 'Lengkap')

                                <span class="badge badge-success">

                                    Lengkap

                                </span>

                            @else

                                <span class="badge badge-danger">

                                    Tidak Lengkap

                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="text-center">

                            Data belum tersedia

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>
$(document).ready(function() {

    $('#tabel-monitoring').DataTable({
        responsive: true,
        autoWidth: false
    });

});
</script>

@endsection