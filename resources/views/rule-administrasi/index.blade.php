@extends('layouts.adminlte')

@section('title', 'Rule Administrasi')

@section('content')

<div class="container-fluid">

    <div class="card card-primary">

        <div class="card-header">

            <h3 class="card-title">

                Pengaturan Rule Administrasi

            </h3>

        </div>

        <form action="{{ route('rule-administrasi.update') }}"
              method="POST">

            @csrf

            <div class="card-body">

                <div class="alert alert-info">

                    <strong>Keterangan :</strong>

                    <ul class="mb-0">

                        <li>
                            Checkbox dicentang = Komponen Wajib
                        </li>

                        <li>
                            Checkbox tidak dicentang = Komponen Tidak Wajib
                        </li>

                    </ul>

                </div>

                <table class="table table-bordered table-striped">

                    <thead class="text-center">

                        <tr>

                            <th width="10%">
                                No
                            </th>

                            <th>
                                Komponen Administrasi
                            </th>

                            <th width="20%">
                                Status Wajib
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($rules as $index => $rule)

                        <tr>

                            <td class="text-center">

                                {{ $index + 1 }}

                            </td>

                            <td>

                                {{ $rule->komponen }}

                            </td>

                            <td class="text-center">

                                <input type="checkbox"
                                       name="status[]"
                                       value="{{ $rule->id_rule }}"
                                       {{ $rule->status == 'Wajib' ? 'checked' : '' }}>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3"
                                class="text-center">

                                Data rule belum tersedia.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save"></i>

                    Simpan Aturan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection