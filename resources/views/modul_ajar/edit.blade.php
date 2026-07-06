@extends('layouts.adminlte')

@section('title','Edit Modul Ajar')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Edit Modul Ajar</h3>
        <div class="card-tools">

            <a href="{{ route('prota.index') }}"
                class="btn btn-secondary btn-sm">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

            @if($modul->status_verifikasi == 'Disetujui')
            <a href="#" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
            @endif

        </div>
    </div>

    <form action="{{ route('modul-ajar.update', $modul->id_modul_ajar) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Mapel</label>

                <select id="id_administrasi"
                    name="id_administrasi"
                    class="form-control">

                    @foreach($administrasi as $a)
                    <option value="{{ $a->id_administrasi }}"
                        {{ $modul->id_administrasi == $a->id_administrasi ? 'selected' : '' }}>
                        {{ $a->mapel->nama_mapel }} - {{ $a->kelas->nama }}
                    </option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Elemen</label>

                <select id="id_cp_detail"
                    name="id_cp_detail"
                    class="form-control">

                    <option value="{{ $modul->id_cp_detail }}">
                        {{ $modul->cpDetail->elemen ?? 'Pilih Elemen' }}
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Capaian Pembelajaran</label>

                <textarea id="cp"
                    class="form-control"
                    readonly>{{ $modul->cpDetail->capaian_pembelajaran ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label>Semester</label>

                <select id="semester"
                    name="semester"
                    class="form-control">

                    <option value="1" {{ $modul->semester == 1 ? 'selected' : '' }}>
                        Semester 1
                    </option>

                    <option value="2" {{ $modul->semester == 2 ? 'selected' : '' }}>
                        Semester 2
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Tujuan Pembelajaran</label>

                <div id="tp-container">

                    @foreach($tpList ?? [] as $item)
                    <div class="form-check">
                        <input type="checkbox"
                            class="form-check-input"
                            name="id_atp_detail[]"
                            value="{{ $item->id_atp_detail }}"
                            {{ $modul->atpDetail->contains($item->id_atp_detail) ? 'checked' : '' }}>

                        <label class="form-check-label">
                            {{ $item->tujuan_pembelajaran }}
                        </label>
                    </div>
                    @endforeach

                </div>
            </div>

            <div class="form-group">
                <label>Judul Modul</label>

                <input type="text"
                    name="judul_modul"
                    class="form-control"
                    value="{{ $modul->judul_modul }}">
            </div>

            <div class="form-group">
                <label>Identifikasi</label>
                <textarea id="identifikasi"
                    name="identifikasi">{{ $modul->identifikasi }}</textarea>
            </div>

            <div class="form-group">
                <label>Desain Pembelajaran</label>
                <textarea id="desain_pembelajaran"
                    name="desain_pembelajaran">{{ $modul->desain_pembelajaran }}</textarea>
            </div>

            <div class="form-group">
                <label>Pengalaman Belajar</label>
                <textarea id="pengalaman_belajar"
                    name="pengalaman_belajar">{{ $modul->pengalaman_belajar }}</textarea>
            </div>

            <div class="form-group">
                <label>Asesmen</label>
                <textarea id="asesmen"
                    name="asesmen">{{ $modul->asesmen }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-primary">
                Update
            </button>
        </div>

    </form>

</div>

@endsection

@section('scripts')

<script>
    $('#id_administrasi').change(function() {

        let id = $(this).val();

        $('#id_cp_detail').html('');

        $.get('/modul-ajar/cp-detail/' + id, function(data) {

            let html = '<option value="">Pilih Elemen</option>';

            data.forEach(function(item) {
                html += `
                <option value="${item.id_cp_detail}"
                        data-cp="${item.capaian_pembelajaran}">
                    ${item.elemen}
                </option>
            `;
            });

            $('#id_cp_detail').html(html);
        });
    });

    $('#id_cp_detail').change(function() {

        let cp = $(this).find(':selected').data('cp');

        $('#cp').val(cp);

        loadTP();
    });

    $('#semester').change(function() {
        loadTP();
    });

    function loadTP() {
        let cp = $('#id_cp_detail').val();
        let semester = $('#semester').val();

        if (!cp || !semester) return;

        $.get('/modul-ajar/tp/' + cp + '/' + semester, function(data) {

            let html = '';

            data.forEach(function(item) {

                html += `
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="id_atp_detail[]"
                           value="${item.id_atp_detail}">
                    <label class="form-check-label">
                        ${item.tujuan_pembelajaran}
                    </label>
                </div>
            `;
            });

            $('#tp-container').html(html);
        });
    }

    document.addEventListener("DOMContentLoaded", function() {

        function MyUploadAdapter(loader) {

            this.loader = loader;
        }

        MyUploadAdapter.prototype.upload = function() {

            return this.loader.file.then(file => {

                return new Promise((resolve, reject) => {

                    let data = new FormData();

                    data.append('upload', file);

                    fetch("{{ route('ckeditor.upload') }}", {

                            method: "POST",
                            credentials: "same-origin",

                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },

                            body: data
                        })

                        .then(response => response.json())
                        .then(result => {

                            resolve({
                                default: result.url
                            });

                        })
                        .catch(error => reject(error));

                });

            });
        };

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository')
                .createUploadAdapter = (loader) => {
                    return new MyUploadAdapter(loader);
                };
        }

        function initEditor(id) {

            let el = document.querySelector(id);

            if (!el) return;

            ClassicEditor
                .create(el, {
                    extraPlugins: [MyCustomUploadAdapterPlugin]
                })
                .catch(error => console.error(error));
        }

        initEditor('#identifikasi');
        initEditor('#desain_pembelajaran');
        initEditor('#pengalaman_belajar');
        initEditor('#asesmen');

    });
</script>

@endsection