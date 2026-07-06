@extends('layouts.adminlte')

@section('title', 'Edit Program Semester')

@section('content')

@php
$bulanList = [
'Juli','Agustus','September','Oktober','November','Desember',
'Januari','Februari','Maret','April','Mei','Juni'
];
@endphp

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title">Edit Prosem</h3>
        </div>

        <form action="{{ route('prosem.update', $prosem->id_prosem) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">

                    <label>Prota</label>

                    <select name="id_prota" class="form-control" required>
                        @foreach ($prota as $item)
                        <option value="{{ $item->id_prota }}"
                            {{ $prosem->id_prota == $item->id_prota ? 'selected' : '' }}>
                            {{ $item->administrasi->mapel->nama_mapel ?? '-' }}
                            -
                            {{ $item->administrasi->kelas->nama ?? '-' }}
                            -
                            {{ $item->administrasi->periode->tahun_ajaran ?? '-' }}
                        </option>
                        @endforeach
                    </select>

                    <br>

                    <input type="text"
                        class="form-control"
                        value="Semester {{ $prosem->semester }}"
                        readonly>

                </div>

                <hr>

                <h5>Detail Prosem</h5>

                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ATP</th>
                                <th>Alokasi Waktu</th>
                                <th>Bulan</th>
                                <th>Minggu Ke</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($prosem->prosemDetail as $index => $item)

                            <tr>

                                <td>
                                    {{ $item->protaDetail->alur_tujuan_pembelajaran ?? '-' }}

                                    <input type="hidden"
                                        name="detail[{{ $index }}][id_prosem_detail]"
                                        value="{{ $item->id_prosem_detail }}">
                                </td>

                                <td>
                                    {{ $item->alokasi_waktu }}
                                </td>

                                <td>
                                    <select name="detail[{{ $index }}][bulan]" class="form-control" required>
                                        @foreach ($bulanList as $bulan)
                                        <option value="{{ $bulan }}"
                                            {{ $item->bulan == $bulan ? 'selected' : '' }}>
                                            {{ $bulan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number"
                                        name="detail[{{ $index }}][minggu_ke]"
                                        class="form-control"
                                        value="{{ $item->minggu_ke }}"
                                        min="1"
                                        max="5"
                                        required>
                                </td>

                                <td>
                                    <input type="text"
                                        name="detail[{{ $index }}][tanggal]"
                                        class="form-control"
                                        value="{{ $item->tanggal }}">
                                </td>

                            </tr>

                            @endforeach

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

                            @foreach ($prosem->kegiatan as $i => $k)

                            <tr>

                                <td>
                                    <input type="hidden"
                                        name="kegiatan[{{ $i }}][id_kegiatan]"
                                        value="{{ $k->id_kegiatan }}">

                                    <input type="text"
                                        name="kegiatan[{{ $i }}][nama_kegiatan]"
                                        class="form-control"
                                        value="{{ $k->nama_kegiatan }}"
                                        required>
                                </td>

                                <td>
                                    <select name="kegiatan[{{ $i }}][bulan]" class="form-control">
                                        @foreach ($bulanList as $bulan)
                                        <option value="{{ $bulan }}"
                                            {{ $k->bulan == $bulan ? 'selected' : '' }}>
                                            {{ $bulan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number"
                                        name="kegiatan[{{ $i }}][minggu_ke]"
                                        class="form-control"
                                        value="{{ $k->minggu_ke }}">
                                </td>

                                <td>
                                    <select name="kegiatan[{{ $i }}][warna]" class="form-control">
                                        <option value="merah" {{ $k->warna == 'merah' ? 'selected' : '' }}>Merah</option>
                                        <option value="kuning" {{ $k->warna == 'kuning' ? 'selected' : '' }}>Kuning</option>
                                        <option value="hijau" {{ $k->warna == 'hijau' ? 'selected' : '' }}>Hijau</option>
                                        <option value="biru" {{ $k->warna == 'biru' ? 'selected' : '' }}>Biru</option>
                                        <option value="ungu" {{ $k->warna == 'ungu' ? 'selected' : '' }}>Ungu</option>
                                    </select>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger btn-sm hapus">
                                        Hapus
                                    </button>
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="card-footer">

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('prosem.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')
<script>
    $(function() {

        let kegiatanIndex = $('#tbody-kegiatan tr').length;

        $('#btnTambahKegiatan').on('click', function() {

            $('#tbody-kegiatan').append(`
        <tr>

            <td>
                <input type="text"
                    name="kegiatan[${kegiatanIndex}][nama_kegiatan]"
                    class="form-control"
                    required>
            </td>

            <td>
                <select name="kegiatan[${kegiatanIndex}][bulan]" class="form-control">
                    @foreach ($bulanList as $bulan)
                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="number"
                    name="kegiatan[${kegiatanIndex}][minggu_ke]"
                    class="form-control">
            </td>

            <td>
                <select name="kegiatan[${kegiatanIndex}][warna]" class="form-control">
                    <option value="merah">Merah</option>
                    <option value="kuning">Kuning</option>
                    <option value="hijau">Hijau</option>
                    <option value="biru">Biru</option>
                    <option value="ungu">Ungu</option>
                </select>
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm hapus">
                    Hapus
                </button>
            </td>

        </tr>
        `);

            kegiatanIndex++;
        });

        $(document).on('click', '.hapus', function() {
            $(this).closest('tr').remove();
            kegiatanIndex = $('#tbody-kegiatan tr').length;
        });

    });
</script>
@endsection