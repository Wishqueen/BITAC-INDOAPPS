<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LearningMaterial; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class LearningMaterialController extends Controller 
{
    // Menampilkan semua learning materials yang dimiliki oleh instruktur yang sedang login
    public function index()
    {
        $instructorName = auth()->user()->name; // Mendapatkan nama instruktur yang sedang login

        // Mengambil learning materials yang terkait dengan kursus milik instruktur
        $learningMaterials = LearningMaterial::whereHas('course', function ($query) use ($instructorName) {
            $query->where('instructor', $instructorName); // Memfilter kursus berdasarkan instruktur
        })->get();

        return view('learning_materials.index', compact('learningMaterials')); // Mengembalikan view dengan data learning materials
    }

    // Menampilkan form untuk membuat learning material baru
    public function create()
    {
        // Mengambil kursus yang dibuat oleh instruktur yang sedang login
        $courses = Course::where('instructor', Auth::user()->name)->get();

        return view('learning_materials.create', compact('courses')); // Mengembalikan view dengan daftar kursus
    }

    // Menyimpan learning material baru ke database
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'course_id' => 'required|exists:courses,id', // Memastikan course_id valid
            'title' => 'required|string|max:255', // Memastikan title ada dan tidak melebihi 255 karakter
            'description' => 'required|string', // Memastikan deskripsi ada
            'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx', // Memastikan file sesuai tipe
        ]);

        // Mengupload file dan menyimpan path
        $filePath = $request->file('file_path')->store('public/learning_materials');

        // Menyimpan data ke database
        LearningMaterial::create([
            'course_id' => $request->course_id, // Menyimpan ID kursus
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Learning Materials added successfully.'); // Mengalihkan dengan pesan sukses
    }

    // Menampilkan form untuk mengedit learning material
    public function edit($id)
    {
        $learningMaterial = LearningMaterial::findOrFail($id); // Mencari learning material berdasarkan ID
        return view('learning_materials.edit', compact('learningMaterial')); // Mengembalikan view untuk mengedit
    }

    // Memperbarui learning material yang ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255', // Memastikan title ada dan tidak melebihi 255 karakter
            'description' => 'required|string', // Memastikan deskripsi ada
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx', // File opsional
        ]);

        // Menemukan learning material berdasarkan ID
        $learningMaterial = LearningMaterial::findOrFail($id);

        // Memperbarui file jika ada file baru yang diunggah
        if ($request->hasFile('file_path')) {
            // Menghapus file lama jika ada
            if ($learningMaterial->file_path) {
                Storage::delete($learningMaterial->file_path);
            }
            // Menyimpan file baru
            $filePath = $request->file('file_path')->store('public/learning_materials');
            $learningMaterial->file_path = $filePath; // Memperbarui path file
        }

        // Memperbarui data lainnya
        $learningMaterial->title = $request->title;
        $learningMaterial->description = $request->description;
        $learningMaterial->save(); // Menyimpan perubahan

        return redirect()->route('learning-materials.index')->with('success', 'Learning materials have been successfully updated.'); // Mengalihkan setelah update
    }

    // Menghapus learning material
    public function destroy($id)
    {
        $learningMaterial = LearningMaterial::findOrFail($id); // Mencari learning material berdasarkan ID
        Storage::delete($learningMaterial->file_path); // Menghapus file dari storage
        $learningMaterial->delete(); // Menghapus data dari database
        return redirect()->route('learning-materials.index')->with('success', 'Learning materials have been successfully deleted.'); // Mengalihkan dengan pesan sukses
    }
}
