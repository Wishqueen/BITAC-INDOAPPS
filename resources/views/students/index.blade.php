@extends('layouts.main')

@section('konten')
<br><br>
<div class="container">
    <h1 class="mb-4 text-center">Students Data</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
    </div>

    @if($students->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle" id="studentTable">
                <thead class="bg-primary text-white">
                    <tr style="text-align: center">
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Program</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">     
                                    {{ $student->name ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $student->email ?? '-' }}</td>
                            <td>{{ ucfirst($student->gender) ?? '-' }}</td>
                            <td>{{ $student->address ?? '-' }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td>
                                @if($student->courses->isNotEmpty())
                                    @foreach($student->courses as $course)
                                        <span class="badge bg-primary">{{ $course->title }}</span>
                                    @endforeach
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No students found.</div>
    @endif
</div>

<!-- Custom CSS to handle print behavior -->
<style>
    @media print {
        /* Hide everything except the table */
        body * {
            visibility: hidden;
        }

        #studentTable, #studentTable * {
            visibility: visible;
        }

        #studentTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@endsection
