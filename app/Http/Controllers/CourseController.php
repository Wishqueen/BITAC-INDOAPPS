<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all(); // or use pagination if you have many courses
        return view('courses.courses', compact('courses'));
    }
    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'instructor' => 'required|string|max:255',
            'students' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('assets/img'), $imageName);

        Course::create([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'instructor' => $request->instructor,
            'students' => $request->students,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('course.index')->with('success', 'Kursus berhasil ditambahkan.');
    }
// Show the form to edit a course
public function edit($id)
{
    $course = Course::findOrFail($id);
    return view('courses.update', compact('course'));
}

public function update(Request $request, Course $course)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'duration' => 'required|string',
        'instructor' => 'required|string|max:255',
        'students' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'description' => 'required|string',
    ]);

    if ($request->hasFile('image')) {
        // Delete old image
        if (file_exists(public_path('assets/img/' . $course->image))) {
            unlink(public_path('assets/img/' . $course->image));
        }

        // Store new image
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('assets/img'), $imageName);
        $course->image = $imageName;
    }

    // Update course details
    $course->update([
        'title' => $request->title,
        'price' => $request->price,
        'duration' => $request->duration,
        'instructor' => $request->instructor,
        'students' => $request->students,
        'description' => $request->description,
    ]);

    return redirect()->route('course.index')->with('success', 'Kursus berhasil diperbarui.');
}

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }
    
    public function show($id)
{
    $course = Course::findOrFail($id);
    return view('courses.detailCourse', compact('course'));
}

}
