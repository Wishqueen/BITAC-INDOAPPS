@extends('layouts.main')

@section('konten')
<br><br>
<div class="container">
    <h2 style="text-align: center">Attendance</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.store') }}" method="POST" id="attendance-form">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" id="status" required>
                <option value="Hadir">Hadir</option>
                <option value="Tidak Hadir">Tidak Hadir</option>
            </select>
        </div>

        <div class="mb-3" id="reason-field" style="display: none;">
            <label for="reason" class="form-label">Reason (if not present)</label>
            <textarea name="reason" class="form-control" id="reason" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>

    <h2 class="mt-4" style="text-align: center">Attendance Records</h2> <br><br>

    <form method="GET" action="{{ route('attendance.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="date">Filter by Date:</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-4">
                <label for="role">Filter by Role:</label>
                <select name="role" class="form-select">
                    <option value="">All</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-info mt-4">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Date</th>
                <th>Status</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>{{ $attendance->reason ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('attendance.download', ['date' => request('date'), 'role' => request('role')]) }}" class="btn btn-success mt-3">Download Report</a>
</div>
<script>
    // Function to show or hide reason field based on status
    document.getElementById('status').addEventListener('change', function() {
        const reasonField = document.getElementById('reason-field');
        if (this.value === 'Tidak Hadir') {
            reasonField.style.display = 'block';  // Show reason field if status is 'Tidak Hadir'
        } else {
            reasonField.style.display = 'none';   // Hide reason field if status is 'Hadir'
        }
    });
</script>
@endsection
