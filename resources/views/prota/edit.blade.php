@extends('layouts.adminlte')

@section('title', 'Edit Program Tahunan')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">

            <h3 class="card-title">
                Edit Program Tahunan (Prota)
            </h3>

        </div>

        <form action="{{ route('prota.update', $prota->id_prota) }}"
              method="POST">

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

                        <strong>Catatan Revisi Kepala Sekolah:</strong>

                        <br>

                        {{ $prota->catatan_revisi }}

                    </div>

                @endif

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Mata Pelajaran</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $prota->administrasi->mapel->nama_mapel }}"
                                   readonly>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Kelas</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $prota->administrasi->kelas->nama }}"
                                   readonly>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Tahun Ajaran</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $prota->administrasi->periode->tahun_ajaran }}"
                                   readonly>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th width="10%">
                                    Kode TP
                                </th>

                                <th>
                                    Tujuan Pembelajaran
                                </th>

                                <th width="15%">
                                    Jumlah JP
                                </th>

                                <th width="15%">
                                    Semester
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($prota->details as $detail)

                            <tr>

                                <td>
                                    {{ $detail->atpDetail->kode_tp }}
                                </td>

                                <td>
                                    {{ $detail->atpDetail->tujuan_pembelajaran }}
                                </td>

                                <td>

                                    <input type="number"
                                           name="jumlah_jp[{{ $detail->id_prota_detail }}]"
                                           value="{{ old('jumlah_jp.' . $detail->id_prota_detail, $detail->jumlah_jp) }}"
                                           class="form-control"
                                           min="1"
                                           required>

                                </td>

                                <td>

                                    <select
                                        name="semester[{{ $detail->id_prota_detail }}]"
                                        class="form-control"
                                        required>

                                        <option value="1"
                                            {{ $detail->semester == 1 ? 'selected' : '' }}>
                                            Semester 1
                                        </option>

                                        <option value="2"
                                            {{ $detail->semester == 2 ? 'selected' : '' }}>
                                            Semester 2
                                        </option>

                                    </select>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>

                <a href="{{ route('prota.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection