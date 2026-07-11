<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            width: 100%;
            margin-bottom: 15px;
        }

        .header img {
            width: 70px;
            float: left;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2,
        .header-text h3,
        .header-text p {
            margin: 0;
        }

        hr {
            border: 1px solid #000;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .tanggal {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background: #d9d9d9;
            text-align: center;
            padding: 6px;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .small {
            font-size: 10px;
        }
    </style>

</head>

<body>

    <div class="header">

        <img src="{{ public_path('assets/img/logo-sukamulya.png') }}">

        <div class="header-text">

            <h2>PEMERINTAH KABUPATEN BANDUNG</h2>

            <h3>SD NEGERI SUKAMULYA</h3>

            <p>
                Laporan Monitoring Kelengkapan Administrasi Kurikulum Merdeka
            </p>

        </div>

    </div>

    <hr>

    <div class="judul">

        LAPORAN MONITORING KELENGKAPAN ADMINISTRASI

    </div>

    <p class="tanggal">

        <strong>Tanggal Cetak :</strong>

        {{ date('d F Y') }}

    </p>

    <table>

        <thead>

            <tr>

                <th width="5%">No</th>

                <th width="18%">Guru</th>

                <th width="15%">Mata Pelajaran</th>

                <th width="10%">Kelas</th>

                <th width="12%">Tahun Ajaran</th>

                <th width="10%">Terpenuhi</th>

                <th width="10%">Persentase</th>

                <th width="10%">Status</th>

                <th>Komponen Belum Lengkap</th>

            </tr>

        </thead>

        <tbody>

            @forelse($hasil as $index => $item)

            <tr>

                <td class="center">

                    {{ $index + 1 }}

                </td>

                <td>

                    {{ $item['administrasi']->pengguna->nama }}

                </td>

                <td>

                    {{ $item['administrasi']->mapel->nama_mapel }}

                </td>

                <td class="center">

                    {{ $item['administrasi']->kelas->nama }}

                </td>

                <td class="center">

                    {{ $item['administrasi']->periode->tahun_ajaran }}

                </td>

                <td class="center">

                    {{ $item['jumlah_terpenuhi'] }}
                    /
                    {{ $item['jumlah_wajib'] }}

                </td>

                <td class="center">

                    {{ $item['persentase'] }}%

                </td>

                <td class="center">

                    {{ $item['status'] }}

                </td>

                <td class="small">

                    @if(count($item['belum_lengkap']) > 0)

                        <ul style="margin:0; padding-left:15px;">

                            @foreach($item['belum_lengkap'] as $komponen)

                                <li>{{ $komponen }}</li>

                            @endforeach

                        </ul>

                    @else

                        -

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="center">

                    Tidak ada data.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    <br><br>

    <table style="border:none; width:100%;">

        <tr style="border:none;">

            <td style="border:none; width:65%;"></td>

            <td style="border:none; text-align:center;">

                Bandung,

                {{ date('d F Y') }}

                <br><br><br><br><br>

                <strong>Kepala Sekolah</strong>

            </td>

        </tr>

    </table>

</body>

</html>