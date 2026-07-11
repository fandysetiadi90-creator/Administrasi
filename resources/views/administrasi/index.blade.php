@extends('layouts.adminlte')

@section('title', 'Data Administrasi')

@section('content')

<div class="container-fluid">

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">
                Monitoring Administrasi Kurikulum
            </h3>

            <a href="{{ route('administrasi.pdf') }}"
                class="btn btn-danger mb-3 float-right">

                <i class="fas fa-file-pdf"></i>

                Unduh PDF

            </a>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table id="tabel-administrasi"
                    class="table table-bordered table-striped">

                    <thead class="text-center">

                        <tr>

                            <th width="5%">No</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Periode</th>
                            <th>Terpenuhi</th>
                            <th>Persentase</th>
                            <th>Status</th>
                            <th>Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($hasil as $item)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item['administrasi']->kelas->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $item['administrasi']->mapel->nama_mapel ?? '-' }}
                            </td>

                            <td>
                                {{ $item['administrasi']->periode->tahun_ajaran ?? '-' }}
                            </td>

                            <td class="text-center">

                                {{ $item['jumlah_terpenuhi'] }}
                                /
                                {{ $item['jumlah_wajib'] }}

                            </td>

                            <td class="text-center">

                                @if($item['persentase'] == 100)

                                    <span class="badge badge-success">
                                        {{ $item['persentase'] }}%
                                    </span>

                                @elseif($item['persentase'] >= 50)

                                    <span class="badge badge-warning">
                                        {{ $item['persentase'] }}%
                                    </span>

                                @else

                                    <span class="badge badge-danger">
                                        {{ $item['persentase'] }}%
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

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

                            <td>

                                @if(count($item['belum_lengkap']) > 0)

                                    <strong>
                                        Belum Lengkap:
                                    </strong>

                                    <ul class="mb-0 mt-1">

                                        @foreach($item['belum_lengkap'] as $komponen)

                                            <li>
                                                {{ $komponen }}
                                            </li>

                                        @endforeach

                                    </ul>

                                @else

                                    <span class="text-success">

                                        Semua administrasi telah lengkap

                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8"
                                class="text-center text-muted">

                                Data administrasi belum tersedia

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

$(document).ready(function() {

    $('#tabel-administrasi').DataTable({
        responsive: true,
        autoWidth: false
    });

});

</script>

@endsection