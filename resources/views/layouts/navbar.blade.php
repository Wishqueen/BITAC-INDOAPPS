<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="p-0 text-primary"><img src="{{ asset('assets/img/bitac.png') }}" alt="" width="150" height="75"></h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('index') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/courses') }}" class="nav-item nav-link {{ Request::is('courses') ? 'active' : '' }}">Program</a>
            <a href="{{ url('/instructor') }}" class="nav-item nav-link {{ Request::is('instructor') ? 'active' : '' }}">Instructor</a>
            <a href="{{ url('/student') }}" class="nav-item nav-link {{ Request::is('student') ? 'active' : '' }}">Student</a>
            {{-- <a href="{{ url('/cart') }}" class="nav-item nav-link {{ Request::is('cart') ? 'active' : '' }}" style="position: relative;">
                <i class="fa fa-shopping-cart"></i>
                Cart
                @if(count(session('cart', [])) > 0)
                    <span class="badge rounded-pill bg-danger position-absolute" style=" top : 11px; right: 47px;">
                        {{ count(session('cart', [])) }}
                    </span>
                @endif
            </a> --}}
        </div>
        <a href="{{ url('/login') }}" class="btn btn-primary py-4 px-lg-4 d-none d-lg-block {{ Request::is('login') ? 'active' : '' }}">Login</a>
        <a href="{{ url('/register') }}" class="btn btn-secondary py-4 px-lg-4 d-none d-lg-block {{ Request::is('register') ? 'active' : '' }}">Register</a>
    </div>
</nav>
