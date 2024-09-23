<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <div class="container-fluid px-4 px-lg-5">
        <!-- Logo -->
        <a href="{{ url('/course') }}" class="navbar-brand d-flex align-items-center">
            <h2 class="p-0 text-primary">
                <img src="{{ asset('assets/img/bitac.png') }}" alt="" width="150" height="75">
            </h2>
        </a>

        <!-- Search Box -->
        <form class="d-flex ms-3" action="{{ url('/search') }}" method="GET" style="flex-grow: 1; max-width: 300px;">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search"
                style="border-radius: 20px; padding: 0.5rem; box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1); border: 1px solid #ddd;">
            <button class="btn btn-primary" type="submit"
                style="border-radius: 20px; padding: 0.5rem 1rem; transition: 0.3s;">
                <i class="fa fa-search"></i>
            </button>
        </form>


        <!-- Toggler for mobile view -->
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Menu Items -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Posisikan My Courses, Cart, dan Profil di sebelah kanan -->
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ url('/my-courses') }}"
                    class="nav-item nav-link {{ Request::is('my-courses') ? 'active' : '' }}">My Courses</a>
                    {{-- <a href="{{ url('/cart') }}" class="nav-item nav-link {{ Request::is('cart') ? 'active' : '' }}" style="position: relative;">
                        <i class="fa fa-shopping-cart"></i>
                        Cart
                        @if(count(session('cart', [])) > 0)
                            <span class="badge rounded-pill bg-danger position-absolute" style=" top : 11px; right: 47px;">
                                {{ count(session('cart', [])) }}
                            </span>
                        @endif
                    </a> --}}
                {{-- <button class="btn btn-primary py-2 px-lg-4 {{ Request::is('profile') ? 'active' : '' }}"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarProfile">
                    <i class="fa fa-bars"></i> Profile
                </button> --}}
                <button class="btn nav-link d-flex align-items-center p-0 border-0" 
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarProfile" style="background: none;">
                    @if (Auth::user()->image)
                        <!-- User's Profile Image -->
                        <img src="{{ asset('img/' . Auth::user()->image) }}" alt="Profile"
                            class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                    @else
                        <!-- Display First Letter of User's Email -->
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; font-size: 18px;">
                            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                        </div>
                    @endif
                </button>
            </div>
        </div>
    </div>
</nav>
