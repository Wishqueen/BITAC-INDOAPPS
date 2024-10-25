<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kursus untuk dropdown filter
        $courses = Course::all();

        // Ambil data siswa berdasarkan course filter jika ada
        $selectedCourse = $request->input('course');

        $query = Transaction::whereHas('transactionItems', function ($query) use ($selectedCourse) {
            if ($selectedCourse) {
                $query->whereHas('course', function ($query) use ($selectedCourse) {
                    $query->where('title', $selectedCourse);
                });
            }
        })->with('user', 'transactionItems.course')->get();

        // Mengambil user unik dari transaksi yang ditemukan
        $students = $query->map(function ($transaction) {
            return $transaction->user;
        })->unique('id'); // Menghindari duplikat siswa

        return view('students.index', compact('students', 'courses', 'selectedCourse'));
    }

    public function index2(Request $request)
    {
        // Get all students
        $students = User::where('role', 'student')->with('transactions.transactionItems.course')->get();
    
        // Filter students who have completed transactions
        $studentsWithTransactions = $students->filter(function ($student) {
            return $student->transactions->contains(function ($transaction) {
                return $transaction->status === 'settlement';
            });
        });

        $shuffledStudents = $studentsWithTransactions->shuffle();

        return view('students.index2', [
            'students' => $shuffledStudents,
        ]);
    }
    

    public function show($id)
    {
        // Fetch the user with 'student' role and their courses by ID
        $student = User::where('role', 'student')->with('courses')->findOrFail($id);

        // Pass the student data to the 'students.show' view
        return view('students.show', compact('student'));
    }
}
