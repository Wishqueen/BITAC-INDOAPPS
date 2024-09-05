<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instructor;
use Illuminate\Support\Facades\Log;

class instructorController extends Controller
{
    public function index()
    {
        $instructors = instructor::all(); // or use pagination if you have many courses
        return view('instructors.index', compact('instructors'));
    }
    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        Log::info($request->all()); // Log the incoming request data
    
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'skills' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/img'), $imageName);
    
            instructor::create([
                'name' => $request->name,
                'image' => $imageName,
                'skills' => $request->skills,
                'description' => $request->description,
            ]);
    
            return redirect()->route('instructors.index')->with('success', 'Instructor successfully added.');
        }
    
        return redirect()->back()->withErrors(['image' => 'Image upload failed.']);
    }
    public function edit($id)
{
    $instructor = Instructor::findOrFail($id);
    return view('instructors.update', compact('instructor'));
}

public function update(Request $request, $id)
{
    $instructor = Instructor::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'skills' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    if ($request->hasFile('image')) {
        // Delete the old image if a new one is uploaded
        if ($instructor->image) {
            unlink(public_path('assets/img') . '/' . $instructor->image);
        }

        // Upload the new image
        $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('assets/img'), $imageName);
        $instructor->image = $imageName;
    }

    // Update other fields
    $instructor->name = $request->name;
    $instructor->skills = $request->skills;
    $instructor->description = $request->description;

    $instructor->save();

    return redirect()->route('instructors.index')->with('success', 'Instructor successfully updated.');
}

    public function destroy($id)
    {
        $course = instructor::findOrFail($id);
        $course->delete();
        return redirect()->route('instructors.index')->with('success', 'Instructor deleted successfully.');
    }
    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('instructors.show', compact('instructor'));
    }
    

}
