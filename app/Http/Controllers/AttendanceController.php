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
        $roles = ['Student', 'Mentor']; // Ganti sesuai role Anda
        $dateFilter = $request->input('date');
        $roleFilter = $request->input('role');

        $attendances = Attendance::with('user')
            ->when($dateFilter, function ($query, $dateFilter) {
                return $query->whereDate('date', $dateFilter);
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->whereHas('user', function ($q) use ($roleFilter) {
                    $q->where('role', $roleFilter);
                });
            })
            ->get();

        return view('attendance.index', compact('attendances', 'roles'));
    }

    // Proses input absensi
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'reason' => 'required_if:status,Tidak Hadir',
        ]);

        Attendance::create([
            'user_id' => Auth::id(),
            'date' => Carbon::today(),
            'status' => $request->status,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
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
