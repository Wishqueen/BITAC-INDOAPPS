@extends('layouts.main')

@section('konten')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Pending Instructor Registrations</h2>

        <!-- Alert for success message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table to display instructor data -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Skills</th>
                        <th>Date of Birth</th>
                        <th>Profile Image</th>
                        <th>CV</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        <tr>
                            <td>{{ $instructor->name }}</td>
                            <td>{{ $instructor->address }}</td>
                            <td>{{ $instructor->phone }}</td>
                            <td>{{ $instructor->email }}</td>
                            <td>{{ $instructor->skills }}</td>
                            <td>{{ \Carbon\Carbon::parse($instructor->date_of_birth)->format('d M, Y') }}</td>
                            <td>
                                <!-- Display Profile Image -->
                                @if($instructor->image)
                                    <img src="{{ asset($instructor->image) }}" alt="Profile Image" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Image" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>
                                <!-- Display CV (download link) -->
                                @if($instructor->cv)
                                    <a href="{{ asset($instructor->cv) }}" target="_blank" class="btn btn-info btn-sm">Download CV</a>
                                @else
                                    <span class="text-muted">No CV uploaded</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($instructor->status) }}</td>
                            <td class="text-center">
                                <!-- Approve and Reject buttons -->
                                <form action="{{ route('admin.instructor.approve', $instructor->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm me-2">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.instructor.reject', $instructor->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
