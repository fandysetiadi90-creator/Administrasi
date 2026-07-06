<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.head')
</head>

<body class="hold-transition login-page" id="body">

    <div class="login-box">
        <div class="theme-toggle-wrapper">
            <button id="themeToggle" class="btn btn-sm btn-secondary">
                🌙 Dark Mode
            </button>
        </div>

        <div class="login-logo text-center">

            <img src="{{ asset('assets/img/logo-sukamulya.png') }}"
                alt="Logo Sekolah"
                width="100"
                class="mb-3">

            <br>

            <b>Sistem</b> Administrasi
        </div>

        <div class="card">
            <div class="card-body login-card-body">

                <p class="login-box-msg">Silakan login untuk masuk</p>

                @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Login
                    </button>

                </form>

            </div>
        </div>
    </div>

    @include('layouts.partials.footer')

</body>

</html>