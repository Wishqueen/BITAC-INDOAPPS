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
    return view('courses.edit', compact('course'));
}

// Update the course
public function update(Request $request, $id)
{
    $course = Course::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'duration' => 'required|string',
        'instructor' => 'required|string',
        'students' => 'required|integer',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $course->update($request->all());

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $course->image = $imagePath;
        $course->save();
    }

    return redirect()->route('course.index')->with('success', 'Course updated successfully!');
}


    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }
}
