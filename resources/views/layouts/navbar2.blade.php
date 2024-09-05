<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <div class="container-fluid px-4 px-lg-5">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
            <h2 class="p-0 text-primary">
                <img src="{{ asset('assets/img/bitac.png') }}" alt="" width="150" height="75">
            </h2>
        </a>

        <!-- Search Box -->
        <form class="d-flex ms-3" style="flex-grow: 1; max-width: 300px;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
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
                <a href="{{ url('/cart') }}" class="nav-item nav-link {{ Request::is('cart') ? 'active' : '' }}">
                    <i class="fa fa-shopping-cart"></i> Cart
                </a>
                <button class="btn btn-primary py-4 px-lg-4 {{ Request::is('profile') ? 'active' : '' }}"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarProfile">
                    <i class="fa fa-bars"></i> Profile
                </button>
            </div>
        </div>
    </div>
</nav>