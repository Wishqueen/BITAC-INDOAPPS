<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Fetch users with the 'student' role and their courses via the students table
        $students = User::where('role', 'student')->with('courses')->get();
    
        if ($students->isEmpty()) {
            dd("No students found.");
        }
    
        return view('students.index', compact('students'));
    }
    
    public function index2()
    {
        // Fetch users with the 'student' role and their courses via the students table
        $students = User::where('role', 'student')->with('courses')->get();
        $students = $students->shuffle();
    
        return view('students.index2', compact('students'));
    }

    public function show($id)
{
    // Fetch the user with 'student' role and their courses by ID
    $student = User::where('role', 'student')->with('courses')->findOrFail($id);

    // Pass the student data to the 'students.show' view
    return view('students.show', compact('student'));
}


}
