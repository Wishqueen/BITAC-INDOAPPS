@extends('layouts.main')

@section('konten')
<div class="container mt-5">
    <h2 class="text-center mb-5">Certifications</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCertificationModal">
            <i class="fas fa-plus me-2"></i> Add Certification
        </button>
    </div>

    <div class="row">
        @foreach($certifications as $certification)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <img src="{{ asset($certification->image) }}" alt="Certification Image">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $certification->title }}</h5>
                    <p class="card-text text-muted">{{ $certification->description }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ asset($certification->image) }}" class="btn btn-outline-primary" download>
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editCertificationModal-{{ $certification->id }}">
                            <i class="fas fa-edit"></i> Update
                        </button>
                        <form action="{{ route('certifications.destroy', $certification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certification?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editCertificationModal-{{ $certification->id }}" tabindex="-1" aria-labelledby="editCertificationLabel-{{ $certification->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCertificationLabel-{{ $certification->id }}">Edit Certification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('certifications.update', $certification->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="title-{{ $certification->id }}" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-{{ $certification->id }}" name="title" value="{{ $certification->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description-{{ $certification->id }}" class="form-label">Description</label>
                                <textarea class="form-control" id="description-{{ $certification->id }}" name="description" rows="3" required>{{ $certification->description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="course_id-{{ $certification->id }}" class="form-label">Course</label>
                                <select class="form-select" id="course_id-{{ $certification->id }}" name="course_id" required>
                                    <option selected disabled>Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" @if($certification->course_id == $course->id) selected @endif>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image-{{ $certification->id }}" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image-{{ $certification->id }}" name="image" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Certification</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificationLabel">Add Certification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('certifications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <option selected disabled>Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Certification</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
@endsection
