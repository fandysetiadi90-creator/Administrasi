<!DOCTYPE html>
<html>
<head>
    <title>Jurnal Harian</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
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

    <h3>Jurnal Mengajar Pembelajaran</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Elemen (CP)</th>
                <th>ATP</th>
                <th>Minggu</th>
                <th>Tanggal</th>
                <th>Penilaian</th>
            </tr>
        </thead>

        <tbody>
            @foreach($jurnal as $j)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $j->administrasi->mapel->nama_mapel ?? '-' }}</td>

                <td>{{ $j->administrasi->kelas->nama ?? '-' }}</td>

                <td>{{ $j->cpDetail->elemen ?? '-' }}</td>

                <td>{{ $j->atpDetail->alur_tujuan_pembelajaran ?? '-' }}</td>

                <td>{{ $j->minggu }}</td>

                <td>{{ $j->tanggal }}</td>

                <td>{{ $j->penilaian }}</td>

            </tr>
            @endforeach
        </tbody>

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