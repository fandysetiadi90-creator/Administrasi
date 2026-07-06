@extends('layouts.adminlte')

@section('title', 'Buat Program Tahunan')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">
                Buat Program Tahunan (PROTA)
            </h3>
        </div>

        <form action="{{ route('prota.store') }}"
            method="POST">

            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label>
                        Administrasi
                        <span class="text-danger">*</span>
                    </label>

                    <select name="id_administrasi"
                        class="form-control @error('id_administrasi') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Administrasi --
                        </option>

                        @foreach($administrasi as $item)

                        <option value="{{ $item->id_administrasi }}"
                            {{ old('id_administrasi') == $item->id_administrasi ? 'selected' : '' }}>

                            {{ $item->mapel->nama_mapel ?? '-' }}
                            -
                            {{ $item->kelas->nama ?? '-' }}
                            -
                            {{ $item->periode->tahun_ajaran ?? '-' }}

                        </option>

                        @endforeach

                    </select>

                    @error('id_administrasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div id="preview-atp" style="display:none;">

                    <hr>

                    <h5>Data ATP Detail</h5>

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Alur Tujuan Pembelajaran</th>
                                    <th>Alokasi Waktu</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>

                            <tbody id="tbody-atp">

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-right">
                                        Total JP
                                    </th>
                                    <th id="total-jp">
                                        0 JP
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>

                </div>

                <div class="form-group">

                    <label>
                        Alokasi Waktu Per Minggu (JP)
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                        name="alokasi_per_minggu"
                        class="form-control @error('alokasi_per_minggu') is-invalid @enderror"
                        value="{{ old('alokasi_per_minggu', 6) }}"
                        min="1"
                        required>

                    <small class="text-muted">
                        Contoh: 6 JP per minggu
                    </small>

                    @error('alokasi_per_minggu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>
                        Alokasi Waktu Per Tahun (JP)
                    </label>

                    <input type="text"
                        id="alokasi_per_tahun"
                        class="form-control"
                        readonly
                        value="0 JP">

                    <small class="text-muted">
                        Otomatis dihitung dari total JP ATP Detail.
                    </small>

                </div>

                <div class="alert alert-info">

                    <strong>Informasi:</strong>

                    <ul class="mb-0">

                        <li>
                            Data ATP akan diambil otomatis berdasarkan Administrasi yang dipilih.
                        </li>

                        <li>
                            Total JP akan dihitung otomatis dari ATP Detail.
                        </li>

                        <li>
                            Perubahan alokasi waktu pada PROTA tidak akan mengubah data ATP Detail.
                        </li>

                    </ul>

                </div>

            </div>

            <div class="card-footer">

                <a href="{{ route('prota.index') }}"
                    class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

                <button type="submit"
                    class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Simpan Prota

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('select[name="id_administrasi"]').change(function() {

            let idAdministrasi = $(this).val();

            if (!idAdministrasi) {
                $('#preview-atp').hide();
                return;
            }

            $.ajax({
                url: '/prota/get-atp-detail/' + idAdministrasi,
                type: 'GET',
                success: function(response) {

                    let html = '';
                    let totalJP = 0;

                    response.forEach(function(item, index) {

                        let jp = parseInt(
                            item.alokasi_waktu.replace(/\D/g, '')
                        ) || 0;

                        totalJP += jp;

                        html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.alur_tujuan_pembelajaran}</td>
                            <td>
                                <input
                                   type="text"
                                   class="form-control alokasi-waktu"
                                   name="alokasi_waktu[${item.id_atp_detail}]"
                                   value="${item.alokasi_waktu}">   
                        </td>
                            <td>${item.semester}</td>
                        </tr>
                    `;
                    });

                    $('#tbody-atp').html(html);
                    hitungTotalJP();
                    $('#total-jp').html(totalJP + ' JP');
                    $('#alokasi_per_tahun').val(totalJP + ' JP');

                    $('#preview-atp').show();
                }
            });

        });

    });

    function hitungTotalJP() {
        let total = 0;

        $('.alokasi-waktu').each(function() {

            let angka = parseInt(
                $(this).val().replace(/\D/g, '')
            ) || 0;

            total += angka;
        });

        $('#total-jp').html(total + ' JP');
        $('#alokasi_per_tahun').val(total + ' JP');
    }

    $(document).on(
        'keyup change',
        '.alokasi-waktu',
        function() {
            hitungTotalJP();
        }
    );
</script>

@endsection