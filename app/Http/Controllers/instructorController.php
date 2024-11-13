<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instructor;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class instructorController extends Controller
{
    public function index()
    {
        // Fetch instructors from the 'instructors' table with status 'approve'
        $instructors = Instructor::where('status', 'approved')->get();
    
        // Pass instructors to the view
        return view('instructors.index', compact('instructors'));
    }
    

    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('instructors.show', compact('instructor'));
    }
    
    public function storePending(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:instructors,email',
            'skills' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        // Store the new instructor data
        $instructor = new Instructor();
        $instructor->name = $request->name;
        $instructor->address = $request->address;
        $instructor->phone = $request->phone;
        $instructor->email = $request->email;
        $instructor->skills = $request->skills;
        $instructor->date_of_birth = $request->date_of_birth;
        $instructor->description = $request->description;
    
        // Handle the profile image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();  // Generate image file name
            $request->image->move(public_path('assets/img/instructors'), $imageName);  // Save image in 'assets/img/instructors' folder
            $instructor->image = 'assets/img/instructors/' . $imageName;  // Store the relative path in the database
        }
    
        // Handle the CV upload
        if ($request->hasFile('cv')) {
            $cvName = time() . '.' . $request->cv->extension();  // Generate CV file name
            $request->cv->move(public_path('assets/cvs/instructors'), $cvName);  // Save CV in 'assets/cvs/instructors' folder
            $instructor->cv = 'assets/cvs/instructors/' . $cvName;  // Store the relative path in the database
        }
    
        // Set the status as pending
        $instructor->status = 'pending';
    
        // Save the instructor
        $instructor->save();
    
        // Redirect back with a success message
       // Example in your controller after a successful registration or action
return redirect()->route('instructors.index')->with('status', 'Your registration is being processed. We will contact you via WhatsApp');

    }

}
