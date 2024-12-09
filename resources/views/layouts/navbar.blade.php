<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="p-0 text-primary"><img src="{{ asset('assets/img/bitac.png') }}" alt="" width="150" height="75"></h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/courses') }}" class="nav-item nav-link {{ Request::is('courses') ? 'active' : '' }}">Program</a>
            <a href="{{ url('/instructor') }}" class="nav-item nav-link {{ Request::is('instructor') ? 'active' : '' }}">Instructor</a>
            <a href="{{ url('/student') }}" class="nav-item nav-link {{ Request::is('student') ? 'active' : '' }}">Student</a>
        </div>
        <a href="{{ url('/login') }}" class="btn btn-primary py-4 px-lg-4 d-none d-lg-block {{ Request::is('login') ? 'active' : '' }}">Login</a>
        <!-- Register Dropdown -->
        <div class="btn-group d-none d-lg-block">
            <button type="button" class="btn btn-secondary dropdown-toggle py-4 px-lg-4" data-bs-toggle="dropdown" aria-expanded="false">
                Register
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ url('/register2') }}">Instructor</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('/register') }}">Student</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
