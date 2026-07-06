@extends('layouts.adminlte')

@section('title','Tambah Modul Ajar')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            Tambah Modul Ajar
        </h3>
    </div>

    <form action="{{ route('modul-ajar.store') }}"
        method="POST" enctype="multipart/form-data">>
        
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Mapel</label>

                <select
                    id="id_administrasi"
                    name="id_administrasi"
                    class="form-control">

                    <option value="">
                        Pilih Mapel
                    </option>

                    @foreach($administrasi as $a)

                    <option value="{{ $a->id_administrasi }}">

                        {{ $a->mapel->nama_mapel }}
                        -
                        {{ $a->kelas->nama }}

                    </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Elemen</label>

                <select
                    id="id_cp_detail"
                    name="id_cp_detail"
                    class="form-control">

                    <option>
                        Pilih Elemen
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Capaian Pembelajaran</label>

                <textarea
                    id="cp"
                    class="form-control"
                    readonly></textarea>
            </div>

            <div class="form-group">
                <label>Semester</label>

                <select
                    id="semester"
                    class="form-control">

                    <option value="">
                        Pilih Semester
                    </option>

                    <option value="1">
                        Semester 1
                    </option>

                    <option value="2">
                        Semester 2
                    </option>

                </select>
            </div>

            <div class="form-group">

                <label>
                    Tujuan Pembelajaran
                </label>

                <div id="tp-container">

                </div>

            </div>

            <div class="form-group">

                <label>
                    Judul Modul
                </label>

                <input
                    type="text"
                    name="judul_modul"
                    class="form-control">

            </div>

            <div class="form-group">
                <label>Identifikasi</label>

                <textarea
                    id="identifikasi"
                    name="identifikasi"></textarea>
            </div>

            <div class="form-group">
                <label>Desain Pembelajaran</label>

                <textarea
                    id="desain_pembelajaran"
                    name="desain_pembelajaran"></textarea>
            </div>

            <div class="form-group">
                <label>Pengalaman Belajar</label>

                <textarea
                    id="pengalaman_belajar"
                    name="pengalaman_belajar"></textarea>
            </div>

            <div class="form-group">
                <label>Asesmen</label>

                <textarea
                    id="asesmen"
                    name="asesmen"></textarea>
            </div>

        </div>

        <div class="card-footer">

            <button
                class="btn btn-primary">

                Simpan

            </button>

        </div>

    </form>

</div>

@endsection

@section('scripts')

<script>

$('#id_administrasi').change(function(){

    let id = $(this).val();

    $('#id_cp_detail').html('');

    $.get('/modul-ajar/cp-detail/' + id, function(data){

        let html = '<option value="">Pilih Elemen</option>';

        data.forEach(function(item){
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

$('#id_cp_detail').change(function(){

    let cp = $(this).find(':selected').data('cp');

    $('#cp').val(cp);

    loadTP();
});

$('#semester').change(function(){
    loadTP();
});

function loadTP()
{
    let cp = $('#id_cp_detail').val();
    let semester = $('#semester').val();

    if(!cp || !semester) return;

    $.get('/modul-ajar/tp/' + cp + '/' + semester, function(data){

        let html = '';

        data.forEach(function(item){
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

document.addEventListener("DOMContentLoaded", function () {

    function MyUploadAdapter(loader) {

        this.loader = loader;
    }

    MyUploadAdapter.prototype.upload = function () {

        return this.loader.file.then(file => {

            return new Promise((resolve, reject) => {

                let data = new FormData();

                data.append('upload', file);

                fetch("{{ route('ckeditor.upload') }}", {

                    method: "POST",

                    credentials: "same-origin",

                    headers: {
                        'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    },

                    body: data

                })

                .then(response => response.json())

                .then(result => {

                    resolve({
                        default: result.url
                    });

                })

                .catch(error => {

                    reject(error);

                });

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
                extraPlugins: [
                    MyCustomUploadAdapterPlugin
                ]
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