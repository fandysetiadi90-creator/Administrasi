@extends('layouts.adminlte')

@section('title', 'Tambah Jurnal Mengajar')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Tambah Jurnal Mengajar</h3>
    </div>

    <form action="{{ route('jurnal-harian.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Mapel</label>

                <select id="id_administrasi" name="id_administrasi" class="form-control" required>
                    <option value="">-- Pilih Mapel --</option>

                    @foreach($administrasi as $adm)
                        <option value="{{ $adm->id_administrasi }}">
                            {{ $adm->mapel->nama_mapel }} - {{ $adm->kelas->nama }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div class="form-group">
                <label>Materi</label>

                <select id="id_cp_detail" name="id_cp_detail" class="form-control" required>
                    <option value="">-- Pilih Materi --</option>
                </select>
            </div>


            <div class="form-group">
                <label>Alur Tujuan Pembelajaran (ATP)</label>

                <select id="id_atp_detail" name="id_atp_detail" class="form-control" required>
                    <option value="">-- Pilih ATP --</option>
                </select>
            </div>


            <div class="form-group">
                <label>Minggu</label>
                <input type="number" name="minggu" class="form-control" required>
            </div>


            <div class="form-group">
                <label>Penilaian</label>
                <textarea name="penilaian" class="form-control" placeholder="Observasi" rows="3"></textarea>
            </div>


            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('jurnal-harian.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

@endsection


@section('scripts')
<script>

$(document).ready(function () {

    let urlCp = "{{ url('/get-cp') }}";
    let urlAtp = "{{ url('/get-atp') }}";


    $('#id_administrasi').on('change', function () {

        let id = $(this).val();

        $('#id_cp_detail').html('<option>Loading...</option>');
        $('#id_atp_detail').html('<option value="">-- Pilih ATP --</option>');

        if (!id) {
            $('#id_cp_detail').html('<option value="">-- Pilih Elemen --</option>');
            return;
        }

        $.get(urlCp + '/' + id, function (data) {

            let html = '<option value="">-- Pilih Elemen --</option>';

            data.forEach(function (item) {
                html += `
                    <option value="${item.id_cp_detail}">
                        ${item.elemen}
                    </option>
                `;
            });

            $('#id_cp_detail').html(html);
        });

    });


    $('#id_cp_detail').on('change', function () {

        let id = $(this).val();

        $('#id_atp_detail').html('<option>Loading...</option>');

        if (!id) {
            $('#id_atp_detail').html('<option value="">-- Pilih ATP --</option>');
            return;
        }

        $.get(urlAtp + '/' + id, function (data) {

            let html = '<option value="">-- Pilih ATP --</option>';

            data.forEach(function (item) {
                html += `
                    <option value="${item.id_atp_detail}">
                        ${item.alur_tujuan_pembelajaran}
                    </option>
                `;
            });

            $('#id_atp_detail').html(html);
        });

    });

});

</script>
@endsection