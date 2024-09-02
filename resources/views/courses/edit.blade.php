@extends('layouts.main')

@section('konten')

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Edit Kursus</h6>
                <h1 class="mb-5">Form Edit Kursus</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('course.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Kursus</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $course->price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi Kursus</label>
                    <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration', $course->duration) }}" required>
                </div>

                <div class="mb-3">
                    <label for="instructor" class="form-label">Nama Instruktur</label>
                    <input type="text" class="form-control" id="instructor" name="instructor" value="{{ old('instructor', $course->instructor) }}" required>
                </div>

                <div class="mb-3">
                    <label for="students" class="form-label">Jumlah Siswa</label>
                    <input type="number" class="form-control" id="students" name="students" value="{{ old('students', $course->students) }}" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Kursus</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if($course->image)
                        <img src="{{ asset('assets/img/' . $course->image) }}" alt="Current Image" class="img-fluid mt-2" style="max-height: 200px;">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Kursus</button>
            </form>
        </div>
    </div>
@endsection
