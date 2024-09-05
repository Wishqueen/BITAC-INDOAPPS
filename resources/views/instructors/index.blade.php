@extends('layouts.main')

@section('konten')

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
            <h1 class="mb-5">Expert Instructors</h1>
            <!-- Add Instructor Button -->
            <a href="{{ route('instructors.create') }}" class="btn btn-primary mb-4">
                <i class="fas fa-plus"></i> Add Instructor
            </a>
        </div>
        <div class="row g-4">
            @foreach($instructors as $instructor)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light position-relative overflow-hidden">
                        <div class="overflow-hidden position-relative">
                            <!-- Make the image clickable -->
                            <a href="{{ route('instructors.show', $instructor->id) }}">
                                <img class="img-fluid instructor-img" src="{{ asset('assets/img/' . $instructor->image) }}" alt="{{ $instructor->name }}">
                            </a>
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">{{ $instructor->name }}</h5>
                            <small>{{ $instructor->skills }}</small>
                            <div class="d-flex justify-content-center mt-3">
                                <!-- Edit Icon -->
                                <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning btn-sm mx-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Icon -->
                                <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this instructor?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Team End -->

@endsection
