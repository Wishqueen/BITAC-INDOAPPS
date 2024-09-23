@extends('layouts.main')

@section('konten')
<br><br>
<!-- Profile Section Start -->
<section class="section" id="profile">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="profile-image-container">
                    <!-- Cek apakah pengguna telah mengunggah foto profil -->
                    @if(Auth::user()->image)
                        <!-- Jika ada foto profil -->
                        <img src="{{ asset('img/' . Auth::user()->image) }}" 
                             alt="Profile Picture" class="img-fluid rounded-circle shadow-lg mb-4 profile-image" width="400" height="400">
                    @else
                        <!-- Jika tidak ada foto profil, tampilkan huruf depan dari email pengguna -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto mb-4 shadow-lg"
                             style="width: 400px; height: 400px; font-size: 200px;">
                            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content text-center text-lg-start">
                    <!-- Nama Lengkap -->
                    <h2 class="mb-3 text-uppercase fw-bold">{{ Auth::user()->name }}</h2>

                    <!-- Email -->
                    <p class="h5 text-primary mb-4">
                        <i class="fas fa-envelope me-2 text-primary"></i>{{ Auth::user()->email }}
                    </p>

                    <!-- Informasi Tambahan -->
                    <div class="description mt-3">
                        <p><i class="fas fa-venus-mars me-2 text-primary"></i><strong>Gender: </strong>{{ Auth::user()->gender ?? 'Not specified' }}</p>
                        <p><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Address: </strong>{{ Auth::user()->address ?? 'No address provided' }}</p>
                        <p><i class="fas fa-phone me-2 text-primary"></i><strong>Phone Number: </strong>{{ Auth::user()->phone ?? 'No phone number provided' }}</p>
                        <p><i class="fas fa-birthday-cake me-2 text-primary"></i><strong>Date of Birth: </strong>{{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('F j, Y') : 'Not provided' }}</p>
                    </div>

                    <!-- Tombol Edit Profil -->
                    <div class="main-border-button mt-4">
                        <a href="{{ url('/update') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="fa fa-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->

<!-- Custom CSS untuk halaman profil -->
@endsection