@extends('layouts.adminlte')

@section('title', 'Tambah Analisis CP')

@section('content')

<div class="container-fluid">

    <form action="{{ route('cp.store') }}"
        method="POST">

        @csrf

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">
                    Tambah Analisis CP
                </h3>
            </div>

            <div class="card-body">


                <div class="form-group">

                    <label>
                        Mata Pelajaran
                    </label>

                    <select
                        name="id_mapel"
                        class="form-control"
                        required>

                        <option value="">
                            Pilih Mata Pelajaran
                        </option>

                        @foreach($mapel as $item)

                        <option value="{{ $item->id_mapel }}">
                            {{ $item->nama_mapel }}
                        </option>

                        @endforeach

                    </select>

                </div>

                <hr>

                <div id="elemen-container">

                </div>

                <button
                    type="button"
                    id="btnTambahElemen"
                    class="btn btn-success">

                    <i class="fas fa-plus"></i>
                    Tambah Elemen

                </button>

                <hr>

                <div class="card card-outline card-success">

                    <div class="card-header">

                        <h3 class="card-title">

                            Ringkasan Analisis CP

                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <label>Total TP</label>

                                <input
                                    type="text"
                                    id="total_tp"
                                    class="form-control"
                                    value="0"
                                    readonly>

                            </div>

                            <div class="col-md-6">

                                <label>Total Alokasi Waktu</label>

                                <input
                                    type="text"
                                    id="total_jp"
                                    class="form-control"
                                    value="0 JP"
                                    readonly>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer">

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Simpan

                </button>

                <a href="{{ route('cp.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </div>

        </div>

    </form>

</div>

@endsection

@section('scripts')

<script>
    let elemenIndex = 0;

    // ==========================
    // TEMPLATE TP
    // ==========================

    function tpRow(elemenIndex) {
        return `
    
    <div class="tp-row border rounded p-3 mb-3 bg-light">

        <div class="row">

            <div class="col-md-2">

                <label>Semester</label>

                <select
                    name="semester[${elemenIndex}][]"
                    class="form-control"
                    required>

                    <option value="1">
                        Semester 1
                    </option>

                    <option value="2">
                        Semester 2
                    </option>

                </select>

            </div>

            <div class="col-md-3">

                <label>
                    Tujuan Pembelajaran
                </label>

                <textarea
                    name="tujuan_pembelajaran[${elemenIndex}][]"
                    class="form-control"
                    rows="3"
                    required></textarea>

            </div>

            <div class="col-md-5">

                <label>
                    Alur Tujuan Pembelajaran
                </label>

                <textarea
                    name="alur_tujuan_pembelajaran[${elemenIndex}][]"
                    class="form-control"
                    rows="3"
                    required></textarea>

            </div>

            <div class="col-md-2">

                <label>
                    Alokasi Waktu
                </label>

                <input
                    type="number"
                    min="1"
                    name="alokasi_waktu[${elemenIndex}][]"
                    class="form-control alokasi-waktu"
                    placeholder=""
                    required>

            </div>

        </div>

        <div class="mt-2 text-right">

            <button
                type="button"
                class="btn btn-danger btn-remove-tp">

                Hapus TP

            </button>

        </div>

    </div>

    `;
    }

    // ==========================
    // TEMPLATE ELEMEN
    // ==========================

    function elemenCard(index) {
        return `

    <div class="card card-outline card-primary mb-4 elemen-card">

        <div class="card-header">

            <h3 class="card-title">

                Elemen ${index + 1}

            </h3>

            <div class="card-tools">

                <button
                    type="button"
                    class="btn btn-danger btn-sm remove-elemen">

                    Hapus Elemen

                </button>

            </div>

        </div>

        <div class="card-body">

            <div class="form-group">

                <label>
                    Elemen
                </label>

                <input
                    type="text"
                    name="elemen[]"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

                <label>
                    Capaian Pembelajaran
                </label>

                <textarea
                    name="capaian_pembelajaran[]"
                    class="form-control"
                    rows="4"
                    required></textarea>

            </div>

            <hr>

            <h5>

                Tujuan Pembelajaran

            </h5>

            <div class="tp-container">

                ${tpRow(index)}

            </div>

            <button
                type="button"
                class="btn btn-info btnTambahTP"
                data-index="${index}">

                <i class="fas fa-plus"></i>
                Tambah TP

            </button>

        </div>

    </div>

    `;
    }

    function updateSummary() {
        let totalJP = 0;

        let totalTP =
            $('.tp-row').length;

        $('.alokasi-waktu').each(function() {

            let nilai =
                parseInt($(this).val());

            if (!isNaN(nilai)) {
                totalJP += nilai;
            }

        });

        $('#total_tp').val(totalTP);

        $('#total_jp').val(
            totalJP + ' JP'
        );
    }
    // ==========================
    // TAMBAH ELEMEN
    // ==========================

    $('#btnTambahElemen').on('click', function() {

        $('#elemen-container')
            .append(
                elemenCard(elemenIndex)
            );

        elemenIndex++;
        updateSummary();
    });

    // ==========================
    // TAMBAH TP
    // ==========================

    $(document).on(
        'click',
        '.btnTambahTP',
        function() {

            let index =
                $(this).data('index');

            $(this)
                .closest('.card-body')
                .find('.tp-container')
                .append(
                    tpRow(index)
                );
                updateSummary();

        }
    );

    $(document).on(
        'keyup change',
        '.alokasi-waktu',
        function() {

            updateSummary();

        }
    );

    // ==========================
    // HAPUS TP
    // ==========================

    $(document).on(
        'click',
        '.btn-remove-tp',
        function() {

            let total =
                $(this)
                .closest('.tp-container')
                .find('.tp-row')
                .length;

            if (total > 1) {
                $(this)
                    .closest('.tp-row')
                    .remove();
                    updateSummary();
            }

        }
    );

    // ==========================
    // HAPUS ELEMEN
    // ==========================

    $(document).on(
        'click',
        '.remove-elemen',
        function() {

            $(this)
                .closest('.elemen-card')
                .remove();
                updateSummary();
        }
    );

    // ==========================
    // AUTO LOAD
    // ==========================

    $(document).ready(function() {

        $('#btnTambahElemen').click();
        updateSummary();
    });
</script>

@endsection