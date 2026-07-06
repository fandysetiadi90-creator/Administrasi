<!DOCTYPE html>
<html>

<head>
    <title>Analisis CP</title>

    <style>
        @page {
            margin-top: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            margin-left: 3cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin-bottom: 60px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        thead {
            display: table-header-group;
        }

        .center {
            text-align: center;
        }

        /* CP SECTION */
        .cp-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .cp-box {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 10px;
            text-align: justify;
            line-height: 1.4;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>ANALISIS CAPAIAN PEMBELAJARAN</h2>
        <h3>{{ $kelas->nama }} | {{ $guru->nama }}</h3>
        <p>Tahun Ajaran: {{ $cp->administrasi->periode->tahun_ajaran }}</p>
    </div>

    @foreach($cp->detail as $detail)

    <div class="cp-section">

        <div class="cp-box">
            <div><b>Elemen:</b> {{ $detail->elemen }}</div>

            <div style="margin-top:5px;">
                <b>Capaian Pembelajaran:</b><br>
                {!! nl2br(e($detail->capaian_pembelajaran)) !!}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="10%">Semester</th>
                    <th width="40%">Tujuan Pembelajaran</th>
                    <th width="40%">Alur TP</th>
                    <th width="10%">JP</th>
                </tr>
            </thead>

            <tbody>

                @php
                $grouped = $detail->atpDetail->groupBy('semester');
                @endphp

                @foreach($grouped as $semester => $items)

                @php $first = true; @endphp

                @foreach($items as $tp)

                <tr>

                    @if($first)
                    <td rowspan="{{ $items->count() }}" class="center">
                        Semester {{ $semester }}
                    </td>
                    @php $first = false; @endphp
                    @endif

                    <td>
                        {!! nl2br(e($tp->tujuan_pembelajaran)) !!}
                    </td>

                    <td>
                        {!! nl2br(e($tp->alur_tujuan_pembelajaran)) !!}
                    </td>

                    <td class="center">
                        {{ $tp->alokasi_waktu }} JP
                    </td>

                </tr>

                @endforeach

                @endforeach

            </tbody>
        </table>

    </div>

    <br>

    @endforeach
    <br><br><br>

    <table style="width:100%; margin-top:40px; border:none;">
        <tr>
            <td style="text-align:center; border:none;">
                Mengetahui,<br>
                Kepala Sekolah<br><br><br><br>

                <b>{{ $kepalaSekolah->nama ?? '-' }}</b><br>
                NIP. {{ $kepalaSekolah->nomor_induk ?? '-' }}
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