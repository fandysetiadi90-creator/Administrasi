<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', config('app.name', 'Laravel'))</title>

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

<!-- Font Awesome (versi stabil untuk AdminLTE 3) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Bootstrap 4 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- AdminLTE -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

<style>
    body {
        overflow: hidden;
    }

    .content-wrapper {
        height: 100vh;
        overflow-y: auto;
        padding-bottom: 60px;
        height: calc(100vh - 57px);
    }

    .main-footer {
        position: fixed;
        bottom: 0;
        width: calc(100% - 250px);
        margin-left: 250px;
        z-index: 1030;
    }

    .sidebar-collapse .main-footer {
        margin-left: 0;
        width: 100%;
    }

    body.dark-mode {
        background: #121212 !important;
        color: white;
    }

    body.dark-mode .card {
        background: #1f1f1f;
        color: white;
    }

    body.dark-mode .login-card-body {
        background: #1f1f1f;
        color: white;
    }

    body.dark-mode .form-control {
        background: #2b2b2b;
        color: white;
        border-color: #444;
    }

    body.dark-mode .form-control::placeholder {
        color: #bbb;
    }

    body.dark-mode .input-group-text {
        background: #2b2b2b;
        color: white;
        border-color: #444;
    }

    body.dark-mode .login-logo a,
    body.dark-mode .login-logo {
        color: white !important;
    }

    .theme-toggle-wrapper {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 9999;
    }
</style>

@stack('css')