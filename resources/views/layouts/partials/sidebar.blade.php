@php
    $jabatan = Auth::user()->jabatan;
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}"
       class="brand-link text-center">

        <img src="{{ asset('assets/img/logo-sukamulya.png') }}"
             alt="Logo Sekolah"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">

        <span class="brand-text font-weight-light">
            SDN Sukamulya
        </span>

    </a>

    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-tachometer-alt"></i>

                        <p>Dashboard</p>

                    </a>

                </li>
                
                @if($jabatan == 'Admin' || $jabatan == 'Wali Kelas')

                <li class="nav-item has-treeview
                    {{ request()->routeIs('akun.*')
                        || request()->routeIs('pengguna.*')
                        || request()->routeIs('kelas.*')
                        || request()->routeIs('siswa.*')
                        || request()->routeIs('mapel.*')
                        || request()->routeIs('periode.*')
                        ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ request()->routeIs('akun.*')
                            || request()->routeIs('pengguna.*')
                            || request()->routeIs('kelas.*')
                            || request()->routeIs('siswa.*')
                            || request()->routeIs('mapel.*')
                            || request()->routeIs('periode.*')
                            ? 'active' : '' }}">

                        <i class="nav-icon fas fa-database"></i>

                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        @if($jabatan == 'Admin')

                        <li class="nav-item">

                            <a href="{{ route('akun.index') }}"
                               class="nav-link {{ request()->routeIs('akun.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Kelola Akun</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('pengguna.index') }}"
                               class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Pengguna</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('periode.index') }}"
                               class="nav-link {{ request()->routeIs('periode.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Periode</p>

                            </a>

                        </li>
                        <li class="nav-item">

                            <a href="{{ route('kelas.index') }}"
                               class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Kelas</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('mapel.index') }}"
                               class="nav-link {{ request()->routeIs('mapel.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Mata Pelajaran</p>

                            </a>

                        </li>
                        @endif

                        @if($jabatan == 'Wali Kelas')
                        <li class="nav-item">

                            <a href="{{ route('siswa.index') }}"
                               class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Siswa</p>

                            </a>

                        </li>
                        @endif
                    </ul>

                </li>
                @endif
                @if($jabatan == 'Wali Kelas')

                <li class="nav-item has-treeview
                    {{ request()->routeIs('administrasi.*')
                        || request()->routeIs('cp.*')
                        ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ request()->routeIs('administrasi.*')
                            || request()->routeIs('cp.*')
                            ? 'active' : '' }}">

                        <i class="nav-icon fas fa-book"></i>

                        <p>
                            Administrasi Kurikulum
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('administrasi.index') }}"
                               class="nav-link {{ request()->routeIs('administrasi.index') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Data Administrasi</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('cp.index') }}"
                               class="nav-link {{ request()->routeIs('cp.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Analisis CP</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('prota.index') }}"
                               class="nav-link {{ request()->routeIs('prota.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Program Tahunan</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('prosem.index') }}"
                               class="nav-link {{ request()->routeIs('prosem.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Program Semester</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('modul-ajar.index') }}"
                               class="nav-link {{ request()->routeIs('modul-ajar.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Modul Ajar</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('jurnal-harian.index') }}"
                               class="nav-link {{ request()->routeIs('modul-ajar.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Jurnal Mengajar</p>

                            </a>

                        </li>

                    </ul>

                </li>

                @endif

                @if($jabatan == 'Kepala Sekolah')

                <li class="nav-item has-treeview
                    {{ request()->routeIs('monitoring.*') ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-chart-line"></i>

                        <p>
                            Monitoring Kepsek
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('monitoring.kelengkapan') }}"
                               class="nav-link {{ request()->routeIs('monitoring.kelengkapan') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>kelengkapan Administrasi</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('monitoring.cp') }}"
                               class="nav-link {{ request()->routeIs('monitoring.cp') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Analisis CP</p>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="{{ route('monitoring.prota') }}"
                               class="nav-link {{ request()->routeIs('monitoring.prota') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Program Tahunan</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('monitoring.prosem') }}"
                               class="nav-link {{ request()->routeIs('monitoring.prosem') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Program Semester</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('monitoring.modul-ajar') }}"
                               class="nav-link {{ request()->routeIs('monitoring.modul-ajar') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Modul Ajar</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('rule-administrasi.index') }}"
                            class="nav-link {{ request()->routeIs('rule-administrasi.*') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Rule Administrasi</p>

                            </a>

                        </li>


                    </ul>

                </li>

                @endif

            </ul>

        </nav>

    </div>

</aside>