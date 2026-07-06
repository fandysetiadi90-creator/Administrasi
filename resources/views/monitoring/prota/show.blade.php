@extends('layouts.adminlte')

@section('title', 'Detail Monitoring Prota')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Detail Program Tahunan (PROTA)
            </h3>

            <div class="card-tools">

                <a href="{{ route('monitoring.prota') }}"
                    class="btn btn-secondary btn-sm">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered mb-4">

                <tr>
                    <th width="250">Mata Pelajaran</th>
                    <td>
                        {{ $prota->administrasi->mapel->nama_mapel ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Kelas</th>
                    <td>
                        {{ $prota->administrasi->kelas->nama ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tahun Ajaran</th>
                    <td>
                        {{ $prota->administrasi->periode->tahun_ajaran ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status Verifikasi</th>
                    <td>

                        @if($prota->status_verifikasi == 'Menunggu')

                        <span class="badge badge-warning">
                            Menunggu
                        </span>

                        @elseif($prota->status_verifikasi == 'Disetujui')

                        <span class="badge badge-success">
                            Disetujui
                        </span>

                        @else

                        <span class="badge badge-danger">
                            Revisi
                        </span>

                        @endif

                    </td>
                </tr>

            </table>

            @if($prota->catatan_revisi)

            <div class="alert alert-danger">

                <strong>Catatan Revisi :</strong>

                <br>

                {{ $prota->catatan_revisi }}

            </div>

            @endif

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>

                        <tr>
                            <th width="50">No</th>
                            <th>Alur Tujuan Pembelajaran</th>
                            <th width="120">Jumlah</th>
                            <th width="100">Semester</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($prota->protaDetail as $detail)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $detail->alur_tujuan_pembelajaran }}
                            </td>

                            <td>
                                {{ $detail->alokasi_waktu }}
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
                                JUMLAH
                            </th>

                            <th>
                                {{ $prota->total_jp }} JP
                            </th>

                            <th></th>

                        </tr>

                        <tr>

                            <th colspan="2" class="text-right">
                                ALOKASI WAKTU PER MINGGU
                            </th>

                            <th>
                                {{ $prota->alokasi_per_minggu }} JP
                            </th>

                            <th></th>

                        </tr>

                        <tr>

                            <th colspan="2" class="text-right">
                                ALOKASI WAKTU PER TAHUN
                            </th>

                            <th>
                                {{ $prota->total_jp }} JP
                            </th>

                            <th></th>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

        @if($prota->status_verifikasi == 'Menunggu')

        <div class="card-footer">

            <form action="{{ route('monitoring.prota.verifikasi', $prota->id_prota) }}"
                method="POST"
                class="d-inline">

                @csrf
                @method('PUT')

                <button type="submit"
                    class="btn btn-success">

                    <i class="fas fa-check"></i>
                    Setujui

                </button>

            </form>

            <button
                class="btn btn-danger"
                data-toggle="modal"
                data-target="#modalRevisi">

                <i class="fas fa-times"></i>
                Revisi

            </button>

        </div>

        @endif

    </div>

</div>

<div class="modal fade"
    id="modalRevisi">

    <div class="modal-dialog">

        <form action="{{ route('monitoring.prota.revisi', $prota->id_prota) }}"
            method="POST">

            @csrf
            @method('PUT')  

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Catatan Revisi
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Catatan Revisi
                        </label>

                        <textarea
                            name="catatan_revisi"
                            rows="5"
                            class="form-control"
                            required></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                        class="btn btn-danger">

                        Kirim Revisi

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection