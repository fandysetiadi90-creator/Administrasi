<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            @php
            $user = auth()->user();
            @endphp

            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">

                @if($user && $user->poto)
                <img src="{{ asset('storage/poto/' . $user->poto) }}"
                    class="img-circle elevation-2"
                    style="width:30px; height:30px; object-fit:cover;">
                @else
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white"
                    style="width:30px; height:30px;">
                    {{ strtoupper(substr($user->nama ?? 'G', 0, 1)) }}
                </span>
                @endif

                <span class="ml-2">
                    {{ $user->nama ?? 'Guest' }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>