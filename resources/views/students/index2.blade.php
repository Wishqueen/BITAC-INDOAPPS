@extends('layouts.main')

@section('konten')

<!-- Student Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Students</h6>
            <h1 class="mb-5">Our Students</h1>
        </div>
        <div class="row g-4">
            @foreach($students as $student)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light position-relative overflow-hidden">
                        <div class="overflow-hidden position-relative">
                            <a href="{{ route('students.show', $student->id) }}">
                                @if($student->image)
                                    <img class="img-fluid student-img" src="{{ asset('img/' . $student->image) }}" alt="{{ $student->name }}" style="width: 100%; height: 250px; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center" style="width: 100%; height: 250px; background-color: #e0e0e0;">
                                        <span class="h1 text-secondary">{{ substr($student->email, 0, 1) }}</span>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">{{ $student->name }}</h5>
                            <small>{{ $student->email }}</small>
                            <div class="d-flex justify-content-center mt-3">
                                <!-- Optional: Add edit and delete buttons here -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Student End -->

@endsection
