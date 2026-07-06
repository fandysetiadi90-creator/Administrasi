@extends('layouts.adminlte')

@section('title', 'Edit Analisis CP')

@section('content')

<div class="container-fluid">

    <form action="{{ route('cp.update', $cp->id_cp) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">
                    Edit Analisis CP
                </h3>
            </div>

            <div class="card-body">


                <div class="form-group">

                    <label>
                        Mata Pelajaran
                    </label>

                    <select name="id_mapel"
                        class="form-control"
                        required>

                        @foreach($mapel as $item)

                        <option
                            value="{{ $item->id_mapel }}"
                            {{ $cp->administrasi->id_mapel == $item->id_mapel ? 'selected' : '' }}>

                            {{ $item->nama_mapel }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <hr>

                <div id="elemen-container">

                    @foreach($cp->detail as $index => $detail)

                    <div class="card card-success elemen-card mb-4">

                        <div class="card-header">

                            <h3 class="card-title">
                                Elemen {{ $loop->iteration }}
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

                                <label>Elemen</label>

                                <input
                                    type="text"
                                    name="elemen[]"
                                    class="form-control"
                                    value="{{ $detail->elemen }}"
                                    required>

                            </div>

                            <div class="form-group">

                                <label>
                                    Capaian Pembelajaran
                                </label>

                                <textarea
                                    name="capaian_pembelajaran[]"
                                    rows="5"
                                    class="form-control"
                                    required>{{ $detail->capaian_pembelajaran }}</textarea>

                            </div>

                            <hr>

                            <div class="tp-container">

                                @foreach($detail->atpDetail as $tp)

                                <div class="tp-row border rounded p-3 mb-3 bg-light">

                                    <div class="row">

                                        <div class="col-md-2">

                                            <label>Semester</label>

                                            <select
                                                name="semester[{{ $index }}][]"
                                                class="form-control">

                                                <option
                                                    value="1"
                                                    {{ $tp->semester == 1 ? 'selected' : '' }}>
                                                    Semester 1
                                                </option>

                                                <option
                                                    value="2"
                                                    {{ $tp->semester == 2 ? 'selected' : '' }}>
                                                    Semester 2
                                                </option>

                                            </select>

                                        </div>

                                        <div class="col-md-2">

                                            <label>
                                                Alokasi Waktu
                                            </label>

                                            <input
                                                type="number"
                                                min="1"
                                                class="form-control jp-input"
                                                value="{{ (int)$tp->alokasi_waktu }}"
                                                name="alokasi_waktu[{{ $index }}][]">

                                        </div>

                                        <div class="col-md-8">

                                            <label>
                                                Tujuan Pembelajaran
                                            </label>

                                            <textarea
                                                name="tujuan_pembelajaran[{{ $index }}][]"
                                                rows="3"
                                                class="form-control">{{ $tp->tujuan_pembelajaran }}</textarea>

                                        </div>

                                    </div>

                                    <div class="form-group mt-3">

                                        <label>
                                            Alur Tujuan Pembelajaran
                                        </label>

                                        <textarea
                                            name="alur_tujuan_pembelajaran[{{ $index }}][]"
                                            rows="4"
                                            class="form-control">{{ $tp->alur_tujuan_pembelajaran }}</textarea>

                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-remove-tp">

                                        Hapus TP

                                    </button>

                                </div>

                                @endforeach

                            </div>

                            <button
                                type="button"
                                class="btn btn-info btnTambahTP"
                                data-index="{{ $index }}">

                                + Tambah TP

                            </button>

                        </div>

                    </div>

                    @endforeach

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
    let elemenIndex = {{ $cp->detail->count() }}; 

    function tpRow(index) 
    {
        return `
        <div class="tp-row border rounded p-3 mb-3 bg-light">

        <div class="row">

            <div class="col-md-2">

                <label>Semester</label>

                <select
                    name="semester[${index}][]"
                    class="form-control">

                    <option value="1">
                        Semester 1
                    </option>

                    <option value="2">
                        Semester 2
                    </option>

                </select>

            </div>

            <div class="col-md-2">

                <label>Alokasi Waktu</label>

                <input
                    type="number"
                    min="1"
                    name="alokasi_waktu[${index}][]"
                    class="form-control jp-input"
                    required>

            </div>

            <div class="col-md-8">

                <label>Tujuan Pembelajaran</label>

                <textarea
                    name="tujuan_pembelajaran[${index}][]"
                    rows="3"
                    class="form-control"
                    required></textarea>

            </div>

        </div>

        <div class="form-group mt-3">

            <label>
                Alur Tujuan Pembelajaran
            </label>

            <textarea
                name="alur_tujuan_pembelajaran[${index}][]"
                rows="4"
                class="form-control"
                required></textarea>

        </div>

        <button
            type="button"
            class="btn btn-danger btn-remove-tp">

            Hapus TP

        </button>

        </div>
        `;
    }

    function elemenCard(index)
    {
        return `
        <div class="card card-success elemen-card mb-4">

        <div class="card-header">

            <h3 class="card-title">
                Elemen Baru
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

                <label>Elemen</label>

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
                    rows="5"
                    class="form-control"
                    required></textarea>

            </div>

            <hr>

            <div class="tp-container">

                ${tpRow(index)}

            </div>

            <button
                type="button"
                class="btn btn-info btnTambahTP"
                data-index="${index}">

                + Tambah TP

            </button>

        </div>

        </div>
        `;
    }

    function hitungRingkasan()
    {
        let totalTp = $('.tp-row').length;

        let totalJp = 0;

        $('.jp-input').each(function(){

        totalJp +=
            parseInt($(this).val()) || 0;
        });

        $('#total_tp').val(totalTp);

        $('#total_jp').val(
            totalJp + ' JP'
        );  
    }

    $(document).on(
        'keyup change',
        '.jp-input',
        hitungRingkasan 
    );

    $(document).ready(function(){

        hitungRingkasan();

    });

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
        hitungRingkasan();
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
            hitungRingkasan();

        }
    );

    $(document).on(
        'keyup change',
        '.alokasi-waktu',
        function() {

            updateSummary();
            hitungRingkasan();

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
                hitungRingkasan();
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
            hitungRingkasan();
        }
    );

    // ==========================
    // AUTO LOAD
    // ==========================

    $(document).ready(function() {
        hitungRingkasan();
    });
</script>

@endsection