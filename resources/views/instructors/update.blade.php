@extends('layouts.main')

@section('konten')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title bg-white text-center text-primary px-3">Edit Instructor</h6>
            <h1 class="mb-5">Update Instructor</h1>
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
                <form action="{{ route('instructors.update', $instructor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Instructor Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $instructor->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Instructor Photo</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if($instructor->image)
                            <img src="{{ asset('assets/img/' . $instructor->image) }}" alt="Instructor Image" class="mt-3" width="100">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <input type="text" class="form-control" id="skills" name="skills" value="{{ $instructor->skills }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $instructor->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Instructor</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
