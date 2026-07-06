<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 10px;
            margin-top: 3cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8px;
        }

        .header {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .header h3,
        .header h4,
        .header p {
            margin: 2px;
        }

        table.prosem {
            width: 100%;
            border-collapse: collapse;
        }

        table.prosem th,
        table.prosem td {
            border: 1px solid #000;
            padding: 2px;
            font-size: 10px;
            vertical-align: middle;
        }

        table.prosem th {
            text-align: center;
            font-weight: bold;
        }

        .no-col {
            width: 25px;
            text-align: center;
        }

        .atp-col {
            width: 450px;
            text-align: left;
        }

        .alokasi-col {
            width: 70px;
            text-align: center;
        }

        .minggu-col {
            width: 18px;
            height: 28px;
            padding: 0;
            text-align: center;
            vertical-align: top;
        }

        .tanggal {
            font-size: 6px;
            line-height: 1;
            margin-top: 1px;
            margin-bottom: 1px;
        }

        .warna {
            width: 8px;
            height: 10px;
            margin: 1px auto;
            border-radius: 2px;
        }

        .legend {
            margin-top: 15px;
        }

        .legend-title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .legend-item {
            display: inline-block;
            margin-right: 12px;
            margin-bottom: 5px;
        }

        .legend-box {
            width: 10px;
            height: 10px;
            display: inline-block;
            margin-right: 4px;
            border-radius: 2px;
        }

        .text-left {
            text-align: left;
        }

        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .signature-table td {
            border: none;
            text-align: center;
            vertical-align: top;
            font-size: 12px; 
            line-height: 1.5;
        }

        .signature-name {
            font-size: 12px;
            font-weight: bold;
        }

        .signature-nip {
            font-size: 11px;
        }

        .signature-space {
            height: 60px; /* ruang tanda tangan */
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">

        <h3>PROGRAM SEMESTER</h3>

        <h4>
            {{ $prosem->prota->administrasi->mapel->nama_mapel ?? '-' }}
        </h4>

        <p>
            Kelas:
            {{ $prosem->prota->administrasi->kelas->nama ?? '-' }}
            |
            Semester:
            {{ $prosem->semester }}
        </p>

    </div>

    <table class="prosem">

        <thead>

            <tr>

                <th rowspan="2" class="no-col">
                    NO
                </th>

                <th rowspan="2" class="atp-col">
                    ALUR TUJUAN PEMBELAJARAN
                </th>

                <th rowspan="2" class="alokasi-col">
                    ALOKASI
                </th>

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

                <td class="no-col">
                    {{ $loop->iteration }}
                </td>

                <td class="atp-col text-left">

                    {{ $first->protaDetail->alur_tujuan_pembelajaran ?? '-' }}

                </td>

                <td class="alokasi-col">

                    {{ $first->hasil_alokasi }}
                    x
                    {{ $first->jp }}
                    JP

                </td>

                @foreach($bulanList as $bulan => $jumlahMinggu)

                    @for($minggu = 1; $minggu <= max($jumlahMinggu,1); $minggu++)

                        @php

                            $cell = $grid[$idProta][$bulan][$minggu] ?? null;

                            $colors = $colorMap[$bulan][$minggu] ?? [];

                        @endphp

                        <td class="minggu-col">

                            @if($cell)

                                <div class="tanggal">
                                    {{ $cell->tanggal }}
                                </div>

                            @endif

                            @foreach($colors as $item)

                                <div class="warna"
                                    style="background: {{ $item['warna'] }};">
                                </div>

                            @endforeach

                        </td>

                    @endfor

                @endforeach

            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="legend">

        <div class="legend-title">
            KETERANGAN KEGIATAN
        </div>

        @foreach($kegiatanLegend as $kegiatan)

            @php

                $warnaKey = strtolower($kegiatan->warna);

                $palette = [
                    'merah' => '#e74c3c',
                    'kuning' => '#f1c40f',
                    'hijau' => '#2ecc71',
                    'biru' => '#3498db',
                    'ungu' => '#9b59b6'
                ];

                $warna = $palette[$warnaKey] ?? '#cccccc';

            @endphp

            <div class="legend-item">

                <span class="legend-box"
                    style="background: {{ $warna }};">
                </span>

                {{ $kegiatan->nama_kegiatan }}

            </div>

        @endforeach

    </div>

    <br><br><br>

    <table class="signature-table">
        <tr>
            <td style="text-align:center; border:none;">
                Mengetahui,<br>
                Kepala Sekolah<br><br><br><br>

                <b>{{ $kepalaSekolah?->nama ?? '-' }}</b><br>
                NIP. {{ $kepalaSekolah?->nomor_induk ?? '-' }}
            </td>

            <td style="text-align:center; border:none;">
                Kutawaringin, {{ $bulan }}<br>
                Guru Kelas {{ $kelas->nama }}<br><br><br><br>

                <b>{{ $guru->nama ?? '-' }}</b><br>
                NIP. {{ $guru->nomor_induk ?? '-' }}
            </td>
        </tr>
    </table>
    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem administrasi pembelajaran.
    </div>

</body>

</html>