<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        body {

            font-family: Times New Roman;

            font-size: 12px;

        }

        h2 {

            text-align: center;

            margin-bottom: 5px;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        table,
        th,
        td {

            border: 1px solid black;

        }

        th {

            background: #dddddd;

        }

        th,
        td {

            padding: 6px;

        }

        .text-center {

            text-align: center;

        }
    </style>

</head>

<body>

    <h2>

        LAPORAN HASIL EVALUASI ADMINISTRASI KURIKULUM MERDEKA

    </h2>

    <p>

        Tanggal Cetak :

        {{ date('d-m-Y') }}

    </p>

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Guru</th>

                <th>Mata Pelajaran</th>

                <th>Kelas</th>

                <th>Tahun Ajaran</th>

                <th>Status</th>

                <th>Persentase</th>

                <th>Belum Lengkap</th>

            </tr>

        </thead>

        <tbody>

            @foreach($hasil as $index=>$row)

            <tr>

                <td class="text-center">

                    {{ $index+1 }}

                </td>

                <td>

                    {{ $row['administrasi']->pengguna->nama }}

                </td>

                <td>

                    {{ $row['administrasi']->mapel->nama_mapel }}

                </td>

                <td>

                    {{ $row['administrasi']->kelas->nama }}

                </td>

                <td>

                    {{ $row['administrasi']->periode->tahun_ajaran }}

                </td>

                <td class="text-center">

                    {{ $row['status'] }}

                </td>

                <td class="text-center">

                    {{ $row['persentase'] }} %

                </td>

                <td>

                    @if(count($row['belum_lengkap'])>0)

                    {{ implode(', ', $row['belum_lengkap']) }}

                    @else

                    -

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>