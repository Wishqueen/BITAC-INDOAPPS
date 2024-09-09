@extends('layouts.main')

@section('konten')
<br><br>
<!-- Profile Section Start -->
<section class="section" id="profile">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-images text-center">
                    <!-- Cek apakah pengguna telah mengunggah foto profil -->
                    @if(Auth::user()->image)
                        <!-- Jika ada foto profil -->
                        <img src="{{ asset('img/' . Auth::user()->image) }}" 
                             alt="Profile Picture" class="img-fluid rounded-circle mb-4" width="400" height="400">
                    @else
                        <!-- Jika tidak ada foto profil, tampilkan huruf depan dari email pengguna -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto mb-4"
                             style="width: 400px; height: 400px; font-size: 200px;">
                            {{ strtoupper(substr(Auth::user()->email, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <!-- Nama Lengkap -->
                    <h4 class="mb-3">{{ Auth::user()->name }}</h4>

                    <!-- Email -->
                    <span class="h5 text-primary mb-3">{{ Auth::user()->email }}</span>

                    <!-- Informasi Tambahan -->
                    <div class="description mt-3">
                        <p><strong>Gender: </strong>{{ Auth::user()->gender ?? 'Not specified' }}</p>
                        <p><strong>Address: </strong>{{ Auth::user()->address ?? 'No address provided' }}</p>
                        <p><strong>Phone Number: </strong>{{ Auth::user()->phone ?? 'No phone number provided' }}</p>
                        <p><strong>Date of Birth: </strong>{{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('F j, Y') : 'Not provided' }}</p>
                    </div>

                    <!-- Tombol Edit Profil -->
                    <div class="main-border-button mb-4">
                        <a href="{{ url('/update') }}" class="btn btn-primary w-100">
                            <i class="fa fa-edit me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->
@endsection
