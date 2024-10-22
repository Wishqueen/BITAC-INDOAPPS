<!-- Sidebar Offcanvas -->
<div class="offcanvas offcanvas-end bg-light text-black shadow-lg" tabindex="-1" id="sidebarProfile"
    aria-labelledby="sidebarLabel" style="width: 250px;">
    <div class="offcanvas-body d-flex flex-column p-3">
        <!-- Profile Picture (Optional) -->
        <div class="text-center mb-4">
            @auth
                @if (Auth::user()->image)
                    <!-- If profile picture exists -->
                    <a href="{{ url('/profile') }}">
                        <img src="{{ asset('img/' . Auth::user()->image) }}" alt="Profile Picture" class="rounded-circle"
                            width="60" height="60">
                    </a>
                @else
                    <!-- If no profile picture, display the first letter of the name or email -->
                    <a href="{{ url('/profile') }}">
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto"
                            style="width: 60px; height: 60px; font-size: 24px;">
                            {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email, 0, 1)) }}
                        </div>
                    </a>
                @endif
                <h6 class="mt-2">{{ Auth::user()->name }}</h6>
                <small>{{ Auth::user()->email }}</small>
            @else
                <p>Please log in to see your profile information.</p>
            @endauth
        </div>

        <!-- Menu Items -->
        <ul class="navbar-nav flex-grow-1">
            @auth
                @if (Auth::user()->role === 'student')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/my-courses') }}">
                            <i class="fa fa-book me-2" style="font-size: 16px;"></i> Learning Materials
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'instructor'|| Auth::user()->role === 'Admin')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/learning-materials') }}">
                            <i class="fa fa-book me-2" style="font-size: 16px;"></i> Learning Materials
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'student'|| Auth::user()->role === 'Admin')
                <li class="nav-item mb-2">
                    <a class="nav-link text-black d-flex align-items-center" href="{{ url('/certifications') }}">
                        <i class="fa fa-certificate me-2" style="font-size: 16px;"></i> Certification
                    </a>
                </li>
                @endif
                
                @if (Auth::user()->role === 'student')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/user/assignments') }}">
                            <i class="fa fa-check-square me-2" style="font-size: 16px;"></i> Assignments
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/certifications') }}">
                            <i class="fa fa-certificate me-2" style="font-size: 16px;"></i> Certification
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'instructor'|| Auth::user()->role === 'Admin')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/admin/assignments') }}">
                            <i class="fa fa-check-square me-2" style="font-size: 16px;"></i> Assignments
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/students') }}">
                            <i class="fa fa-users me-2" style="font-size: 16px;"></i> Student Data
                        </a>
                    </li>
                @endif



                @if (Auth::user()->role === 'instructor' || Auth::user()->role === 'Admin' || Auth::user()->role === 'student')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/attendance') }}">
                            <i class="fa fa-calendar-check me-2" style="font-size: 16px;"></i> Attendance
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/learning-schedule') }}">
                            <i class="fa fa-calendar-alt me-2" style="font-size: 16px;"></i> Learning Schedule
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role === 'instructor')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center" href="{{ url('/feedback') }}">
                            <i class="fa fa-chart-bar me-2" style="font-size: 16px;"></i> Evaluation
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role === 'student')
                    <li class="nav-item mb-2">
                        <a class="nav-link text-black d-flex align-items-center"
                            href="{{ url('feedback/user/' . Auth::user()->id) }}">
                            <i class="fa fa-chart-bar me-2" style="font-size: 16px;"></i> Evaluation
                        </a>

                    </li>
                @endif
            @endauth
        </ul>

        <!-- Logout Button -->
        <div class="mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-dark w-100 py-2">
                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>
