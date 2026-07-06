@extends('layouts.adminlte')

@php
$displayName = $currentUser->nama ?? $currentUser->name ?? 'User';
$registeredAt = $currentUser?->created_at ? $currentUser->created_at->format('d F Y H:i') : '-';
$accountStatus = $currentUser?->akun ? 'Sudah terhubung dengan akun login' : 'Belum memiliki akun login';
$accountBadgeClass = $currentUser?->akun ? 'badge-success' : 'badge-warning';
@endphp

@section('title', 'Dashboard')

@section('content')

@php
$jabatan = auth()->user()->jabatan;
@endphp

@if($jabatan == 'Admin')
<div class="content-header px-0 pt-0">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <div class="mt-2 mt-md-0">
                <a href="{{ route('pengguna.index') }}" class="btn btn-success">
                    <i class="fas fa-users mr-1"></i> Kelola Pengguna
                </a>
                <a href="{{ route('akun.index') }}" class="btn btn-outline-primary ml-2">
                    <i class="fas fa-id-card mr-1"></i> Kelola Akun
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('pengguna.index') }}" class="small-box-footer">
                Buka daftar pengguna <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $usersWithAccount }}</h3>
                <p>Pengguna Sudah Punya Akun</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
            <a href="{{ route('akun.index') }}" class="small-box-footer">
                Buka daftar akun <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $usersWithoutAccount }}</h3>
                <p>Pengguna Belum Punya Akun</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <a href="{{ route('pengguna.index') }}" class="small-box-footer">
                Tinjau pengguna tanpa akun <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalAccounts }}</h3>
                <p>Total Akun Login</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card"></i>
            </div>
            <a href="{{ route('akun.index') }}" class="small-box-footer">
                Kelola akun login <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle mr-1"></i>
                    Profil Pengguna Login
                </h3>

                <a href="{{ route('pengguna.edit', $currentUser->id_pengguna) }}"
                    class="btn btn-warning btn-sm float-right">
                    <i class="fas fa-edit"></i>
                    Edit Pengguna
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="35%">Nama</th>
                                <td>{{ $displayName }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $currentUser->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Induk</th>
                                <td>{{ $currentUser->nomor_induk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $currentUser->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td><span class="badge {{ $accountBadgeClass }}">{{ $accountStatus }}</span></td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-4 text-center d-flex flex-column justify-content-center">
                        <div class="mb-3">
                            @if($currentUser->poto)
                            <img src="{{ asset('storage/poto/' . $currentUser->poto) }}"
                                alt="Foto Profil"
                                class="rounded-circle elevation-2"
                                style="width:110px; height:110px; object-fit:cover;">
                            @else
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success elevation-2"
                                style="width: 110px; height: 110px;">
                                <i class="fas fa-user text-white" style="font-size: 42px;"></i>
                            </span>
                            @endif
                        </div>
                        <h4 class="mb-1">{{ $displayName }}</h4>
                        <p class="text-muted mb-2">{{ $currentUser->jabatan ?? 'Jabatan belum diisi' }}</p>
                        <span class="badge badge-light border px-3 py-2">{{ $currentUser->email ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($jabatan == 'Admin')
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Ringkasan Sistem
                </h3>
            </div>
            <div class="card-body">
                <div class="info-box bg-light">
                    <span class="info-box-icon bg-success"><i class="fas fa-percentage"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Cakupan Akun</span>
                        <span class="info-box-number">{{ $accountCoverage }}%</span>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ $accountCoverage }}%"></div>
                        </div>
                        <span class="progress-description">
                            {{ $usersWithAccount }} dari {{ $totalUsers }} pengguna sudah memiliki akun
                        </span>
                    </div>
                </div>

                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> Informasi</h5>
                    Pengguna baru hari ini: <strong>{{ $newUsersToday }}</strong>
                </div>

                <div class="card card-body bg-light mb-0">
                    <h6 class="font-weight-bold mb-3">Akses Cepat</h6>
                    <a href="{{ route('pengguna.index') }}" class="btn btn-outline-success btn-block mb-2">
                        <i class="fas fa-users mr-1"></i> Buka Data Pengguna
                    </a>
                    <a href="{{ route('akun.index') }}" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-id-card mr-1"></i> Buka Data Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@if($jabatan == 'Admin')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus mr-1 text-success"></i>
                    Pengguna Terbaru
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor Induk</th>
                                <th>Status Akun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestUsers as $pengguna)
                            <tr>
                                <td>{{ $pengguna->nama }}</td>
                                <td>{{ $pengguna->nomor_induk }}</td>
                                <td>
                                    @if ($pengguna->akun)
                                    <span class="badge badge-success">Sudah punya akun</span>
                                    @else
                                    <span class="badge badge-warning">Belum punya akun</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('pengguna.index') }}" class="btn btn-sm btn-success">
                    Lihat semua pengguna
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-clock mr-1 text-warning"></i>
                    Pengguna Yang Belum Memiliki Akun
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usersPendingAccount as $pengguna)
                            <tr>
                                <td>{{ $pengguna->nama }}</td>
                                <td>{{ $pengguna->email }}</td>
                                <td>{{ $pengguna->jabatan }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Semua pengguna sudah memiliki akun.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('akun.create') }}" class="btn btn-sm btn-primary">
                    Buat akun baru
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-id-card mr-1 text-primary"></i>
                    Akun Login Terbaru
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Nomor Induk</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestAccounts as $akun)
                            <tr>
                                <td>{{ $akun->pengguna->nama ?? '-' }}</td>
                                <td>{{ $akun->pengguna->email ?? '-' }}</td>
                                <td>{{ $akun->pengguna->nomor_induk ?? '-' }}</td>
                                <td>{{ $akun->created_at ? $akun->created_at->format('d M Y H:i') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada akun login yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection