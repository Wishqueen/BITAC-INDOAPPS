@extends('layouts.main')

@section('konten')
<br><br>
<!-- Student Profile Section Start -->
<section class="section" id="student-profile">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-images text-center">
                    <!-- Check if the student has uploaded a profile picture -->
                    @if($student->image)
                        <!-- If profile picture exists -->
                        <img src="{{ asset('img/' . $student->image) }}" 
                             alt="Profile Picture" class="img-fluid rounded-circle mb-4" width="400" height="400">
                    @else
                        <!-- If no profile picture, display the first letter of the student's email -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center mx-auto mb-4"
                             style="width: 400px; height: 400px; font-size: 200px;">
                            {{ strtoupper(substr($student->email, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <!-- Full Name -->
                    <div class="mb-3">
                        <i class="fa fa-user me-2"></i> <strong>Full Name:</strong> {{ $student->name }}
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <i class="fa fa-venus-mars me-2"></i> <strong>Gender:</strong> {{ ucfirst($student->gender) }}
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <i class="fa fa-map-marker-alt me-2"></i> <strong>Address:</strong> {{ $student->address }}
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <i class="fa fa-envelope me-2"></i> <strong>Email:</strong> {{ $student->email }}
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <i class="fa fa-phone me-2"></i> <strong>Phone Number:</strong> {{ $student->phone }}
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <i class="fa fa-birthday-cake me-2"></i> <strong>Date of Birth:</strong> {{ $student->date_of_birth }}
                    </div>

                    <!-- Courses List -->
                    <div class="mb-3">
                        <h5><i class="fa fa-book me-2"></i> Courses</h5>
                        <ul>
                            @foreach($student->courses as $course)
                                <li>{{ $course->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Student Profile Section End -->
@endsection
