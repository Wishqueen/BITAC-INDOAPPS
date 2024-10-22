<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Tampilkan form absensi

    public function index(Request $request)
    {
        // Ambil roles dan courses untuk opsi filter
        $roles = ['student', 'instructor'];
        $courses = Course::all();

        // Ambil data attendance dengan filter
        $attendances = Attendance::with('user')
            ->when($request->date, function ($query) use ($request) {
                $query->whereDate('date', Carbon::parse($request->date));
            })
            ->when($request->role, function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('role', $request->role);
                });
            })
            ->when($request->course, function ($query) use ($request) {
                $query->whereHas('user.transactionItems.course', function ($q) use ($request) {
                    $q->where('course_id', $request->course);
                });
            })
            ->get();

        return view('attendance.index', compact('attendances', 'roles', 'courses'));
    }

    public function store(Request $request)
    {
        // Only allow 'student' and 'instructor' roles to submit attendance
        if (auth()->user()->role !== 'student' && auth()->user()->role !== 'instructor') {
            return redirect()->route('attendance.index')->with('error', 'You are not authorized to submit attendance.');
        }

        $request->validate([
            'status' => 'required',
            'reason' => 'nullable|string',
        ]);

        Attendance::create([
            'user_id' => auth()->id(),
            'date' => now(),
            'status' => $request->status,
            'reason' => $request->status === 'Tidak Hadir' ? $request->reason : null,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance submitted successfully.');
    }

    // Unduh laporan absensi
    public function downloadReport(Request $request)
    {
        // Fetch attendance records with user and course relationships and apply filters
        $attendances = Attendance::with('user.course')
            ->when($request->input('date'), function ($query, $date) {
                return $query->whereDate('date', $date);
            })
            ->when($request->input('role'), function ($query, $role) {
                return $query->whereHas('user', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->when($request->input('course'), function ($query, $courseId) {
                return $query->whereHas('user', function ($q) use ($courseId) {
                    $q->where('course_id', $courseId);
                });
            })
            ->get();

        // Set up the CSV filename and headers
        $filename = 'attendance_report_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        // Generate the CSV content
        $callback = function () use ($attendances) {
            // Clear output buffer before sending file
            ob_clean();

            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ['User', 'Course', 'Date', 'Status', 'Reason']);

            // Add each attendance record as a row
            foreach ($attendances as $attendance) {
                fputcsv($handle, [
                    $attendance->user->name,
                    $attendance->user->course ? $attendance->user->course->title : 'N/A',
                    $attendance->date,
                    $attendance->status,
                    $attendance->reason ?? '-'
                ]);
            }

            fclose($handle);
        };

        // Return the streamed CSV file as a response
        return response()->stream($callback, 200, $headers);
    }
}
