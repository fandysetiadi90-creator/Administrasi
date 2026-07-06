@extends('layouts.adminlte')

@section('title', 'Program Semester')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">
                Tambah Prosem
            </h3>
        </div>

        <form action="{{ route('prosem.store') }}"
            method="POST">

            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label>Prota</label>

                    <select name="id_prota"
                        id="id_prota"
                        class="form-control"
                        required>

                        <option value="">
                            -- Pilih Prota --
                        </option>

                        @foreach ($prota as $item)
                        <option value="{{ $item->id_prota }}"
                            {{ old('id_prota') == $item->id_prota ? 'selected' : '' }}>

                            {{ $item->administrasi->mapel->nama_mapel ?? '-' }}
                            -
                            {{ $item->administrasi->kelas->nama ?? '-' }}
                            -
                            {{ $item->administrasi->periode->tahun_ajaran ?? '-' }}
                        </option>
                        @endforeach

                    </select>

                    <br>

                    <select
                        name="semester"
                        id="semester"
                        class="form-control"
                        required>

                        <option value="">
                            Pilih Prota Terlebih Dahulu
                        </option>

                    </select>
                </div>

                <hr>

                <h5>Detail Prosem</h5>

                <div class="table-responsive">

                    <table class="table table-bordered"
                        id="table-detail">

                        <thead>

                            <tr>
                                <th>ATP</th>
                                <th>Alokasi Waktu</th>
                                <th>Bulan</th>
                                <th>Minggu Ke</th>
                                <th>Tanggal</th>
                            </tr>

                        </thead>

                        <tbody id="tbody-prosem">

                        </tbody>

                    </table>

                </div>

                <hr>

                <h5>Kegiatan Semester</h5>

                <button type="button"
                    class="btn btn-success mb-2"
                    id="btnTambahKegiatan">

                    Tambah Kegiatan

                </button>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Bulan</th>
                                <th>Minggu</th>
                                <th>Warna</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody id="tbody-kegiatan">

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer">

                <button type="submit"
                    class="btn btn-primary">

                    Simpan

                </button>

                <a href="{{ route('prosem.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>
    const semesterTerpakai = @json($semesterTerpakai);

    $('#id_prota').change(function() {

        $('#tbody-prosem').html('');
        $('#semester').html(
            '<option value="">Pilih Semester</option>'
        );
        let idProta = $(this).val();

        let semesterDipakai = semesterTerpakai
            .filter(item => item.id_prota == idProta)
            .map(item => parseInt(item.semester));

        let html = '<option value="">Pilih Semester</option>';

        if (!semesterDipakai.includes(1)) {
            html += '<option value="1">Semester 1</option>';
        }

        if (!semesterDipakai.includes(2)) {
            html += '<option value="2">Semester 2</option>';
        }

        if (semesterDipakai.includes(1) &&
            semesterDipakai.includes(2)) {

            html = `
            <option value="">
                Semua semester sudah dibuat
            </option>
        `;
        }

        $('#semester').html(html);

    });
    $('#id_prota, #semester').change(function() {

        let idProta = $('#id_prota').val();
        let semester = $('#semester').val();

        if (idProta == '' || semester == '') return;

        $.ajax({
            url: '/prosem/prota-detail/' + idProta,
            type: 'GET',
            data: {
                semester: semester
            },
            success: function(response) {
                renderTable(response);
            }
        });

    });

    function renderTable(response) {

        let html = '';

        response.forEach(function(item, index) {
            if (!item.id_prota_detail) return;
            html += `
        <tr>

            <td>
                ${item.alur_tujuan_pembelajaran ?? '-'}
                <input type="hidden"
                    name="detail[${index}][id_prota_detail]"
                    value="${item.id_prota_detail ?? ''}" required>
            </td>

            <td>
                ${item.hasil_alokasi ?? '-'}
            </td>

            <td>
                <select name="detail[${index}][bulan]" class="form-control" required>
                     <option value="">Pilih Bulan</option>

                    <option value="Juli" ${item.bulan == 'Juli' ? 'selected' : ''}>Juli</option>
                    <option value="Agustus" ${item.bulan == 'Agustus' ? 'selected' : ''}>Agustus</option>
                    <option value="September" ${item.bulan == 'September' ? 'selected' : ''}>September</option>
                    <option value="Oktober" ${item.bulan == 'Oktober' ? 'selected' : ''}>Oktober</option>
                    <option value="November" ${item.bulan == 'November' ? 'selected' : ''}>November</option>
                    <option value="Desember" ${item.bulan == 'Desember' ? 'selected' : ''}>Desember</option>
                    <option value="Januari" ${item.bulan == 'Januari' ? 'selected' : ''}>Januari</option>
                    <option value="Februari" ${item.bulan == 'Februari' ? 'selected' : ''}>Februari</option>
                    <option value="Maret" ${item.bulan == 'Maret' ? 'selected' : ''}>Maret</option>
                    <option value="April" ${item.bulan == 'April' ? 'selected' : ''}>April</option>
                    <option value="Mei" ${item.bulan == 'Mei' ? 'selected' : ''}>Mei</option>
                    <option value="Juni" ${item.bulan == 'Juni' ? 'selected' : ''}>Juni</option>    
                </select>
            </td>

            <td>
                <input type="number"
                    name="detail[${index}][minggu_ke]"
                    class="form-control"
                    min="1"
                    max="5"
                    value="${item.minggu_ke ?? ''}"
                    required>
            </td>

            <td>
                <input type="text"
                    name="detail[${index}][tanggal]"
                    class="form-control"
                    value="${item.tanggal ?? ''}"
                    placeholder="21,24"
                    required>
            </td>

        </tr>
        `;
        });

        $('#table-detail tbody').html(html);
    }

    let kegiatanIndex = 0;

    $('#btnTambahKegiatan').click(function() {

        let html = `
        <tr>

            <td>

                <input
                    type="text"
                    name="kegiatan[${kegiatanIndex}][nama_kegiatan]"
                    class="form-control"    
                    required>

            </td>

            <td>

                <select
                    name="kegiatan[${kegiatanIndex}][bulan]"
                    class="form-control"
                    required>

                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                </select>
            </td>

            <td>

                <input
                    type="number"
                    name="kegiatan[${kegiatanIndex}][minggu_ke]"
                    class="form-control"
                    min="1"
                    max="5"
                    required>   

            </td>

            <td>

                <select
                    name="kegiatan[${kegiatanIndex}][warna]"
                    class="form-control"
                    required>

                    <option value="">-- Pilih Warna --</option>

                    <option value="merah">🔴 Merah</option>
                    <option value="kuning">🟡 Kuning</option>
                    <option value="hijau">🟢 Hijau</option>
                    <option value="biru">🔵 Biru</option>
                    <option value="ungu">🟣 Ungu</option>   

                    </select>

            </td>

            <td>

                <button
                    type="button"
                    class="btn btn-danger btn-sm hapus">

                    Hapus

                </button>

            </td>

        </tr>   
    `;

        $('#tbody-kegiatan').append(html);

        kegiatanIndex++;

    });

    $(document).on('click', '.hapus', function() {
        $(this).closest('tr').remove(); 
    });
</script>

@endsection