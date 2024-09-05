<!-- Sidebar Offcanvas -->
<div class="offcanvas offcanvas-end bg-light text-black shadow-lg" tabindex="-1" id="sidebarProfile"
    aria-labelledby="sidebarLabel" style="width: 250px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel" style="font-weight: bold;">Profile Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-3">
        <!-- Profile Picture (Optional) -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/profile.png') }}" alt="Profile Picture" class="rounded-circle" width="60"
                height="60">
            <h6 class="mt-2">John Doe</h6>
            <small>johndoe@example.com</small>
        </div>

        <!-- Menu Items -->
        <ul class="navbar-nav flex-grow-1">
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/materi') }}">
                    <i class="fa fa-book me-2" style="font-size: 16px;"></i> Learning Materials
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/penilaian') }}">
                    <i class="fa fa-check-square me-2" style="font-size: 16px;"></i> Assessments
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/sertifikasi') }}">
                    <i class="fa fa-certificate me-2" style="font-size: 16px;"></i> Certification
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/datasiswa') }}">
                    <i class="fa fa-users me-2" style="font-size: 16px;"></i> Student Data
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/absensi') }}">
                    <i class="fa fa-calendar-check me-2" style="font-size: 16px;"></i> Attendance
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/jadwal') }}">
                    <i class="fa fa-calendar-alt me-2" style="font-size: 16px;"></i> Learning schedule
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-black d-flex align-items-center" href="{{ url('/settings') }}">
                    <i class="fa fa-cog me-2" style="font-size: 16px;"></i> Settings
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <div class="mt-auto">
            <a href="{{ url('/logout') }}" class="btn btn-outline-dark w-100 py-2">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
</div>