@extends('layouts.adminlte')

@section('title', 'Jurnal Mengajar')    

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Data Jurnal Mengajar    
        </h3>

        <form action="{{ route('jurnal-harian.pdf') }}" method="GET" class="form-inline mb-3">

            <div class="form-group mr-2">
                <select name="id_periode" class="form-control" required>
                    <option value="">-- Pilih Tahun Ajaran (Periode) --</option>

                    @foreach($periode as $p)
                        <option value="{{ $p->id_periode }}">
                            {{ $p->tahun_ajaran }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </button>

        </form>

        <div class="card-tools">

            <a href="{{ route('jurnal-harian.create') }}"
                class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
           
        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table id="datatable"
                class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Minggu</th>
                        <th>ATP</th>
                        <th>Materi</th>
                        <th>Penilaian</th>
                        <th>Tanggal</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($jurnalHarian as $j)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            Minggu {{ $j->minggu }}
                        </td>

                        <td>
                            {{ $j->atpDetail->alur_tujuan_pembelajaran ?? '-' }}
                        </td>

                        <td>
                            {{ $j->atpDetail->cpDetail->elemen ?? '-' }}
                        </td>

                        <td>
                            {{ $j->penilaian ?? '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>

                            <a href="{{ route('jurnal-harian.edit', $j->id_jurnal_harian) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form
                                action="{{ route('jurnal-harian.destroy', $j->id_jurnal_harian) }}"
                                method="POST"
                                style="display:inline-block">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>
    $(function() {

        $('#datatable').DataTable({
            responsive: true,
            autoWidth: false,
        });

    });
</script>

@endsection