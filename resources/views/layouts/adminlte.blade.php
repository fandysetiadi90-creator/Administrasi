<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
 
<head> 
    @include('layouts.partials.head') 
</head> 
 
<body class="hold-transition sidebar-mini layout-fixed"> 
    <div class="wrapper"> 
        <!-- Navbar --> 
        @include('layouts.partials.navbar') 
 
        <!-- Sidebar --> 
        @include('layouts.partials.sidebar') 
 
        <!-- Content Wrapper --> 
        <div class="content-wrapper"> 
            <!-- Content Header --> 
            <section class="content-header"> 
                <div class="container-fluid"> 
                    <div class="row mb-2"> 
                        <div class="col-sm-6"> 
                            <h1>@yield('title')</h1> 
                        </div> 
                        <div class="col-sm-6"> 
                            <ol class="breadcrumb float-sm-right"> 
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') 
                                }}">Home</a></li> 
                                <li class="breadcrumb-item active">@yield('title')</li> 
                            </ol> 
                        </div> 
                    </div> 
                </div> 
            </section> 
 
            <!-- Main content --> 
            <section class="content"> 
                <div class="container-fluid"> 
                    <!-- Alert Messages --> 
                    @if (session('success')) 
                        <div class="alert alert-success alert-dismissible fade show auto-hide-alert"> 
                            <button type="button" class="close" data-dismiss="alert">&times;</button> 
                            <i class="icon fas fa-check"></i> {{ session('success') }} 
                        </div> 
                    @endif 
 
                    @if (session('error')) 
                        <div class="alert alert-danger alert-dismissible"> 
                            <button type="button" class="close" data-dismiss="alert">&times;</button> 
                            <i class="icon fas fa-ban"></i> {{ session('error') }} 
                        </div> 
                    @endif 
 
                    @if ($errors->any()) 
                        <div class="alert alert-danger alert-dismissible"> 
                            <button type="button" class="close" data-dismiss="alert">&times;</button> 
                            <i class="icon fas fa-exclamation-triangle"></i> 
                            <ul class="mb-0"> 
                                @foreach ($errors->all() as $error) 
                                    <li>{{ $error }}</li> 
                                @endforeach 
                            </ul> 
                        </div> 
                    @endif 
 
                    <!-- Main Content --> 
                    @yield('content') 
                </div> 
            </section> 
        </div> 
 
        <!-- Footer --> 
        <footer class="main-footer"> 
            <div class="float-right d-none d-sm-block"> 
                <b>Version</b> 1.0.0 
            </div> 
            <strong>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</strong> 
        </footer> 
    </div> 
 
    @include('layouts.partials.footer') 

    @yield('scripts')
</body> 
 
</html> 