@extends('layouts.adminlte')

@section('title', 'Edit Program Tahunan')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">
                Edit Program Tahunan (PROTA)
            </h3>
        </div>

        <form action="{{ route('prota.update', $prota->id_prota) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="card-body">

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if($prota->status_verifikasi == 'Revisi')
                <div class="alert alert-warning">
                    <strong>Catatan Revisi Kepala Sekolah</strong>
                    <br>
                    {{ $prota->catatan_revisi }}
                </div>
                @endif

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $prota->administrasi->mapel->nama_mapel }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $prota->administrasi->kelas->nama }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ $prota->administrasi->periode->tahun_ajaran }}"
                                readonly>
                        </div>
                    </div>

                </div>

                <div class="form-group">

                    <label>
                        Alokasi Waktu Per Minggu (JP)
                    </label>

                    <input
                        type="number"
                        name="alokasi_per_minggu"
                        class="form-control"
                        min="1"
                        value="{{ old('alokasi_per_minggu', $prota->alokasi_per_minggu) }}"
                        required>

                </div>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th width="5%">No</th>
                                <th>Alur Tujuan Pembelajaran</th>
                                <th width="20%">Alokasi Waktu</th>
                                <th width="15%">Semester</th>
                            </tr>

                        </thead>

                        <tbody>

                            @php
                            $totalJP = 0;
                            @endphp

                            @foreach($prota->protaDetail as $detail)

                            @php
                            $jp = (int) preg_replace('/[^0-9]/', '', $detail->alokasi_waktu);
                            $totalJP += $jp;
                            @endphp

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $detail->alur_tujuan_pembelajaran }}
                                </td>

                                <td>

                                    <input
                                        type="text"
                                        name="alokasi_waktu[{{ $detail->id_prota_detail }}]"
                                        class="form-control alokasi-waktu"
                                        value="{{ old('alokasi_waktu.'.$detail->id_prota_detail, $detail->alokasi_waktu) }}"
                                        required>

                                </td>

                                <td>
                                    {{ $detail->semester }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <th colspan="2" class="text-right">
                                    Total JP
                                </th>

                                <th id="total-jp">
                                    {{ $totalJP }} JP
                                </th>

                                <th></th>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

            <div class="card-footer">

                <a href="{{ route('prota.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>
    function hitungTotalJP() {

        let total = 0;

        $('.alokasi-waktu').each(function() {

            let angka = parseInt($(this).val().replace(/\D/g, '')) || 0;

            total += angka;

        });

        $('#total-jp').html(total + ' JP');

    }

    $(document).on('keyup change', '.alokasi-waktu', function() {

        hitungTotalJP();

    });
</script>

@endsection