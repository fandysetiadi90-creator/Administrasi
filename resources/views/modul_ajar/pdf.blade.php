```blade
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>

    @page{
        margin:18mm;
    }

    body{
        font-family:"Times New Roman";
        font-size:12px;
        line-height:1.6;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-bottom:15px;
    }

    table td,
    table th{
        border:1px solid black;
        padding:6px;
        vertical-align:top;
    }

    .section-title{
        background:#d9d9d9;
        border:1px solid black;
        padding:8px;
        margin-top:20px;
        font-weight:bold;
    }

    .content{
        width:100%;
        overflow:hidden;
    }

    .content table{
        width:100%!important;
        table-layout:fixed;
        border-collapse:collapse!important;
    }

    .content table td,
    .content table th{
        border:1px solid black!important;
        padding:5px;
        word-wrap:break-word;
    }

    .content img{
        max-width:450px!important;
        height:auto!important;
        display:block;
        margin:auto;
    }

    .content div{
        width:100%;
    }

    .content p{
        margin:5px 0;
    }

    .content ul,
    .content ol{
        margin-top:5px;
    }

    tr{
        page-break-inside:avoid;
    }

    img{
        page-break-inside:avoid;
    }

    </style>

</head>

    <body>

        <div class="cover">

            <img src="{{ public_path('assets/img/logo-sukamulya.png') }}" class="logo">

            <h1>MODUL AJAR</h1>
            <h2>KURIKULUM MERDEKA</h2>

            <br><br>

            <h3>SD NEGERI SUKAMULYA</h3>

            <br><br>

            <table>

                <tr>
                    <td width="35%">Judul Modul</td>
                    <td>{{ $modul->judul_modul }}</td>
                </tr>

                <tr>
                    <td>Mata Pelajaran</td>
                    <td>{{ $modul->administrasi->mapel->nama_mapel ?? '-' }}</td>
                </tr>

                <tr>
                    <td>Kelas</td>
                    <td>{{ $modul->administrasi->kelas->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <td>Semester</td>
                    <td>{{ $modul->atpDetail->first()->semester ?? '-' }}</td>
                </tr>

            </table>

        </div>

        <div class="section-title">
            IDENTITAS MODUL
        </div>

        <table>

            <tr>
                <td width="35%">Judul Modul</td>
                <td>{{ $modul->judul_modul }}</td>
            </tr>

            <tr>
                <td>Mata Pelajaran</td>
                <td>{{ $modul->administrasi->mapel->nama_mapel ?? '-' }}</td>
            </tr>

            <tr>
                <td>Kelas</td>
                <td>{{ $modul->administrasi->kelas->nama ?? '-' }}</td>
            </tr>

            <tr>
                <td>Semester</td>
                <td>{{ $modul->atpDetail->first()->semester ?? '-' }}</td>
            </tr>

        </table>

        <div class="section-title">
            DESAIN PEMBELAJARAN
        </div>

        <h4>Capaian Pembelajaran</h4>

        <p>
            {{ $modul->cpDetail->capaian_pembelajaran ?? '-' }}
        </p>

        <h4>Tujuan Pembelajaran</h4>

        <ol>
            @forelse($modul->atpDetail as $tp)
                <li>{{ $tp->tujuan_pembelajaran }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ol>

        <div class="section-title">
            IDENTIFIKASI
        </div>

        <div class="content">
            {!! str_replace(asset('storage'),public_path('storage'),$modul->identifikasi) !!}
        </div>

        <div class="section-title">
            PENGALAMAN BELAJAR
        </div>

        <div class="content">
            {!! str_replace(asset('storage'), public_path('storage'), $modul->pengalaman_belajar) !!}
        </div>

        <div class="section-title">
            ASESMEN
        </div>

        <div class="content">
            {!! str_replace(asset('storage'), public_path('storage'), $modul->asesmen) !!}
        </div>

    </body>

</html>
