<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PROTA PDF</title>

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
            color: #000;
            margin-bottom: 60px;

        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .no-border td {
            border: none;
        }

        .table-detail th,
        .table-detail td {
            text-align: center;
        }

        .table-detail td.text-left {
            text-align: left;
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

    <h3>Detail Program Tahunan (PROTA)</h3>

    <table>

        <tr>
            <th width="250">Mata Pelajaran</th>
            <td>{{ $prota->administrasi->mapel->nama_mapel ?? '-' }}</td>
        </tr>

        <tr>
            <th>Kelas</th>
            <td>{{ $prota->administrasi->kelas->nama ?? '-' }}</td>
        </tr>

        <tr>
            <th>Tahun Ajaran</th>
            <td>{{ $prota->administrasi->periode->tahun_ajaran ?? '-' }}</td>
        </tr>

    </table>

    <br>

    <table class="table-detail">

        <thead>
            <tr>
                <th width="50">No</th>
                <th>Alur Tujuan Pembelajaran</th>
                <th width="120">Jumlah</th>
                <th width="100">Semester</th>
            </tr>
        </thead>

        <tbody>

            @foreach($prota->protaDetail as $detail)

            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>

                <td class="text-left">
                    {{ $detail->alur_tujuan_pembelajaran }}
                </td>

                <td class="text-center">
                    {{ $detail->alokasi_waktu }}
                </td>

                <td class="text-center">
                    {{ $detail->semester }}
                </td>
            </tr>

            @endforeach

        </tbody>

        <tfoot>

            <tr>
                <th colspan="2" class="text-right">JUMLAH</th>
                <th>{{ $prota->total_jp }} JP</th>
                <th></th>
            </tr>

            <tr>
                <th colspan="2" class="text-right">ALOKASI WAKTU PER MINGGU</th>
                <th>{{ $prota->alokasi_per_minggu }} JP</th>
                <th></th>
            </tr>

            <tr>
                <th colspan="2" class="text-right">ALOKASI WAKTU PER TAHUN</th>
                <th>{{ $prota->total_jp }} JP</th>
                <th></th>
            </tr>

        </tfoot>

    </table>

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