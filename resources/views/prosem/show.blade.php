@extends('layouts.adminlte')

@section('title', 'Program Semester')

@section('content')

<style>
    table.excel {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }

    table.excel th,
    table.excel td {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .atp-col {
        text-align: left;
        min-width: 250px;
    }

    .alokasi-col {
        min-width: 100px;
    }

    .color-block {
        height: 12px;
        border-radius: 3px;
    }
</style>

<div class="mb-3 no-print">

    @if($prosem->status_verifikasi == 'Revisi')

    <div class="alert alert-danger">

        <strong>Catatan Revisi:</strong>

        <br>

        {{ $prosem->catatan_revisi }}

    </div>

    @endif

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Program Semester (PROSEM)
            </h3>

            <div class="card-tools">

                <a href="{{ route('prosem.index') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                @if($prosem->status_verifikasi == 'Disetujui')
                <a href="{{ route('prosem.pdf', $prosem->id_prosem) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Unduh PDF
                </a>
                @endif

                @if($prosem->status_verifikasi != 'Disetujui')

                <a href="{{ route('prosem.edit', $prosem->id_prosem) }}"
                    class="btn btn-warning">

                    <i class="fas fa-edit"></i>
                    Edit

                </a>

                @endif

            </div>

        </div>

        <div class="card-body">

            <div class="text-center mb-3">
                <h5>PROGRAM SEMESTER</h5>
                <h6>{{ $prosem->prota->administrasi->mapel->nama_mapel ?? '-' }}</h6>
                <small>
                    Kelas: {{ $prosem->prota->administrasi->kelas->nama ?? '-' }} |
                    Semester: {{ $prosem->semester }}
                </small>
            </div>

            <div class="table-responsive">

                <table class="excel">

                    <thead>
                        <tr>
                            <th rowspan="2">NO</th>
                            <th rowspan="2">ALUR TUJUAN PEMBELAJARAN</th>
                            <th rowspan="2">ALOKASI</th>

                            @foreach($bulanList as $bulan => $jumlahMinggu)
                            <th colspan="{{ max($jumlahMinggu,1) }}">
                                {{ strtoupper($bulan) }}
                            </th>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach($bulanList as $bulan => $jumlahMinggu)
                            @for($i = 1; $i <= max($jumlahMinggu,1); $i++)
                                <th>{{ $i }}</th>
                                @endfor
                                @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($groupedDetail as $idProta => $details)

                        @php
                        $first = $details->first();
                        @endphp

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="atp-col text-left">
                                {{ $first->protaDetail->alur_tujuan_pembelajaran ?? '-' }}
                            </td>

                            <td class="alokasi-col">
                                {{ $first->hasil_alokasi ?? '-' }} x {{ $first->jp }} JP
                            </td>

                            @foreach($bulanList as $bulan => $jumlahMinggu)

                            @for($minggu = 1; $minggu <= max($jumlahMinggu,1); $minggu++)

                                @php
                                $cell=$details
                                ->where('bulan', $bulan)
                                ->where('minggu_ke', $minggu)
                                ->first();

                                $color = $colorMap[$bulan][$minggu] ?? null;
                                @endphp

                                <td>

                                    @if($cell)
                                    <div style="font-size:10px;">
                                        {{ $cell->tanggal ?? '' }}
                                    </div>
                                    @endif

                                    @if($color)
                                    <div class="color-block"
                                        style="background: {{ $color }}">
                                    </div>
                                    @endif

                                </td>

                                @endfor

                                @endforeach

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <hr>

            <h6>
                <strong>KETERANGAN KEGIATAN</strong>
            </h6>

            <div style="display:flex; flex-wrap:wrap; gap:15px;">

                @foreach($kegiatanLegend as $kegiatan)

                @php
                $warnaKey = strtolower($kegiatan->warna);

                $colorPalette = [
                'merah' => '#e74c3c',
                'kuning' => '#f1c40f',
                'hijau' => '#2ecc71',
                'biru' => '#3498db',
                'ungu' => '#9b59b6',
                ];

                $color = $colorPalette[$warnaKey] ?? '#ccc';
                @endphp

                <div style="display:flex; align-items:center; gap:8px;">

                    <div style="
                            width:15px;
                            height:15px;
                            background: {{ $color }};
                            border-radius:3px;
                        ">
                    </div>

                    <span>{{ $kegiatan->nama_kegiatan }}</span>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection