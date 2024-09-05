@extends('layouts.main')

@section('konten')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title bg-white text-center text-primary px-3">Add Instructor</h6>
            <h1 class="mb-5">Add Instructor</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Instructor Details</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('instructors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Instructor Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter instructor's name" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Instructor Photo</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <input type="text" class="form-control" id="skills" name="skills" placeholder="Enter skills or expertise" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter a brief description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Add Instructor</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
