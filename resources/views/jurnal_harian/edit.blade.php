@extends('layouts.adminlte')

@section('title', 'Edit Jurnal Mengajar')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Edit Jurnal Mengajar</h3>
    </div>

    <form action="{{ route('jurnal-harian.update', $jurnal->id_jurnal_harian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Mapel</label>

                <select id="id_administrasi" name="id_administrasi" class="form-control" required>

                    @foreach($administrasi as $adm)
                        <option value="{{ $adm->id_administrasi }}"
                            {{ $jurnal->id_administrasi == $adm->id_administrasi ? 'selected' : '' }}>

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
                <input type="number" name="minggu" class="form-control"
                       value="{{ $jurnal->minggu }}" required>
            </div>


            <div class="form-group">
                <label>Penilaian</label>
                <textarea name="penilaian" class="form-control" rows="3">{{ $jurnal->penilaian }}</textarea>
            </div>


            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                       value="{{ $jurnal->tanggal }}" required>
            </div>

        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                Update
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

    let selectedCp = "{{ $jurnal->id_cp_detail }}";
    let selectedAtp = "{{ $jurnal->id_atp_detail }}";


    function loadCp(admId) {

        if (!admId) return;

        $.get(urlCp + '/' + admId, function (data) {

            let html = '<option value="">-- Pilih Elemen --</option>';

            data.forEach(function (item) {

                html += `
                    <option value="${item.id_cp_detail}"
                        ${item.id_cp_detail == selectedCp ? 'selected' : ''}>
                        ${item.elemen}
                    </option>
                `;
            });

            $('#id_cp_detail').html(html);

            // auto load ATP setelah CP siap
            if (selectedCp) {
                loadAtp(selectedCp);
            }
        });
    }

    function loadAtp(cpId) {

        if (!cpId) return;

        $.get(urlAtp + '/' + cpId, function (data) {

            let html = '<option value="">-- Pilih ATP --</option>';

            data.forEach(function (item) {

                html += `
                    <option value="${item.id_atp_detail}"
                        ${item.id_atp_detail == selectedAtp ? 'selected' : ''}>
                        ${item.alur_tujuan_pembelajaran}
                    </option>
                `;
            });

            $('#id_atp_detail').html(html);
        });
    }


    let initialAdm = $('#id_administrasi').val();
    loadCp(initialAdm);


    $('#id_administrasi').on('change', function () {

        let id = $(this).val();

        $('#id_cp_detail').html('<option>Loading...</option>');
        $('#id_atp_detail').html('<option value="">-- Pilih ATP --</option>');

        loadCp(id);
    });


    $('#id_cp_detail').on('change', function () {

        let id = $(this).val();
        loadAtp(id);
    });

});

</script>
@endsection