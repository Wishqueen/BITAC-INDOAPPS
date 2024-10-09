<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Tampilkan form absensi

public function index(Request $request)
{
    $roles = ['instructor', 'student', 'Admin']; // Only show these roles in the filter
    $attendances = Attendance::query()
        ->with('user')
        ->when($request->date, function ($query, $date) {
            return $query->whereDate('date', $date);
        })
        ->when($request->role, function ($query, $role) {
            return $query->whereHas('user', function ($query) use ($role) {
                $query->where('role', $role);
            });
        })
        ->get();

    return view('attendance.index', compact('attendances', 'roles'));
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
        $attendances = Attendance::with('user')
            ->when($request->input('date'), function ($query, $date) {
                return $query->whereDate('date', $date);
            })
            ->when($request->input('role'), function ($query, $role) {
                return $query->whereHas('user', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->get();
    
        $filename = 'attendance_report_' . Carbon::now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];
    
        $callback = function() use ($attendances) {
            // Bersihkan buffer output sebelum mengirim file
            ob_clean();
    
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['User', 'Date', 'Status', 'Reason']);
    
            foreach ($attendances as $attendance) {
                fputcsv($handle, [
                    $attendance->user->name,
                    $attendance->date,
                    $attendance->status,
                    $attendance->reason
                ]);
            }
    
            fclose($handle);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
}
