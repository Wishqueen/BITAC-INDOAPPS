@extends('layouts.main')

@section('konten')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Assignment List</h1>

        <!-- Tampilkan Nama Pengguna di Sebelah Kanan -->
        <div class="mb-2" id="userName" style="text-align: right;">
            <p>Name : {{ Auth::user()->name }}</p> <!-- Nama User -->
        </div>

        <!-- Tombol Print -->
        <div class="d-flex justify-content-between mb-4">
            <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="assignmentTable">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>Course</th>
                        <th>Title</th>
                        <th>Deadline</th>
                        <th>File/Image</th>
                        <th>Status</th>
                        <th>Grade</th>
                        <th class="action-column">Action</th> <!-- Action Column -->
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($assignments->groupBy('course.title') as $courseTitle => $courseAssignments)
                        <!-- Baris untuk Judul Course -->
                        <tr>
                            <td colspan="7" class="font-weight-bold">
                                <h4>{{ $courseTitle }}</h4>
                            </td>
                        </tr>

                        <!-- Baris untuk masing-masing Assignment dalam Course tersebut -->
                        @foreach ($courseAssignments as $assignment)
                            <tr>
                                <td></td> <!-- Kosong karena sudah ada judul course di atas -->
                                <td>{{ $assignment->title }}</td>

                                <!-- Tampilkan Deadline -->
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                                </td>

                                <!-- Tampilkan File atau Gambar jika ada -->
                                <td class="text-center">
                                    @if ($assignment->file_path)
                                        <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank">View File</a>
                                    @else
                                        No File
                                    @endif
                                </td>

                                <!-- Tampilkan Status Submission -->
                                <td class="text-center">
                                    {{ $assignment->submission->status ?? 'Not Submitted' }}
                                </td>

                                <!-- Tampilkan Nilai jika ada -->
                                <td class="text-center">
                                    {{ $assignment->submission->grade ?? 'Not Graded' }}
                                </td>

                                <!-- Tampilkan Action -->
                                <td class="text-center action-column">
                                    @php
                                        $deadlinePassed = \Carbon\Carbon::now()->isAfter($assignment->deadline);
                                    @endphp

                                    @if ($assignment->submission)
                                        <a href="{{ route('user.assignments.submit', $assignment->id) }}"
                                            class="btn disabled btn-success btn-sm rounded-pill text-white">Done</a>
                                    @elseif ($deadlinePassed)
                                        <button class="btn disabled btn-danger btn-sm rounded-pill">Deadline Passed</button>
                                    @else
                                        <a href="{{ route('user.assignments.submit', $assignment->id) }}"
                                            class="btn btn-primary btn-sm rounded-pill">Submit Answer</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom CSS untuk handling print behavior -->
<style>
    @media print {
        /* Hanya tabel dan nama pengguna yang akan terlihat saat dicetak */
        body * {
            visibility: hidden;
        }

        #assignmentTable,
        #assignmentTable * {
            visibility: visible;
        }

        #userName,
        #userName * {
            visibility: visible;
        }

        #userName {
            position: absolute;
            top: 0;
            right: 0;
            width: auto;
            text-align: right;
            margin-bottom: 20px;
        }

        #assignmentTable {
            position: absolute;
            top: 50px; /* Sesuaikan posisi tabel agar berada tepat di bawah nama user */
            left: 0;
            width: 100%;
        }

        /* Sembunyikan kolom Action, File/Image, dan Deadline saat dicetak */
        .action-column,
        td:nth-child(3), /* Hides the Deadline column */
        th:nth-child(3), /* Hides the header of the Deadline column */
        td:nth-child(4), /* Hides the File/Image column */
        th:nth-child(4) { /* Hides the header of the File/Image column */
            display: none !important; /* Use !important to ensure it overrides other styles */
        }
    }
</style>

@endsection
