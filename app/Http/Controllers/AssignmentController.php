<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // Menampilkan daftar semua assignment yang dibuat oleh instructor yang sedang login
    public function index()
    {
        $instructorName = auth()->user()->name; // Mengambil nama instructor yang sedang login

        // Mengambil assignment yang terkait dengan kursus yang diajarkan oleh instructor ini
        $assignments = Assignment::whereHas('course', function ($query) use ($instructorName) {
            $query->where('instructor', $instructorName);
        })->get();

        // Mengembalikan view dengan data assignments
        return view('admin.assignments.index', compact('assignments'));
    }

    // Menampilkan form untuk membuat assignment baru
    public function create()
    {
        // Mengambil semua kursus yang diajarkan oleh instructor yang sedang login
        $courses = Course::where('instructor', auth()->user()->name)->get();
        return view('admin.assignments.create', compact('courses')); // Mengembalikan view dengan data kursus
    }

    // Menyimpan assignment baru ke database
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'course_id' => 'required', // ID kursus harus diisi
            'title' => 'required', // Judul assignment harus diisi
            'description' => 'required', // Deskripsi assignment harus diisi
            'file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // File bersifat opsional, tetapi jika ada, harus sesuai format
            'deadline' => 'required|date', // Deadline harus diisi dan merupakan tanggal yang valid
        ]);

        // Simpan file jika diunggah
        if ($request->hasFile('file')) {
            // Mengunggah file dan menyimpannya di direktori 'assignments' dalam storage publik
            $filePath = $request->file('file')->store('assignments', 'public');
            $request->merge(['file_path' => $filePath]); // Menyimpan path file ke request
        }

        // Membuat assignment baru dengan data dari request
        Assignment::create($request->all());

        // Mengalihkan ke halaman index dengan pesan sukses
        return redirect()->route('admin.assignments.index')->with('success', 'Assignment berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit assignment yang sudah ada
    public function edit($id)
    {
        // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
        $assignment = Assignment::findOrFail($id);
        $courses = Course::all(); // Mengambil semua kursus untuk ditampilkan di form edit

        // Mengembalikan view dengan data assignment dan kursus
        return view('admin.assignments.edit', compact('assignment', 'courses'));
    }

    // Memperbarui assignment yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'course_id' => 'required', // ID kursus harus diisi
            'title' => 'required', // Judul assignment harus diisi
            'description' => 'required', // Deskripsi assignment harus diisi
            'file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // File bersifat opsional, tetapi jika ada, harus sesuai format
            'deadline' => 'required|date', // Deadline harus diisi dan merupakan tanggal yang valid
        ]);

        // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
        $assignment = Assignment::findOrFail($id);

        // Memperbarui file jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Mengunggah file dan menyimpannya di direktori 'assignments' dalam storage publik
            $filePath = $request->file('file')->store('assignments', 'public');
            $assignment->update(['file_path' => $filePath]); // Memperbarui path file assignment
        }

        // Memperbarui data assignment dengan data dari request
        $assignment->update($request->all());

        // Mengalihkan ke halaman index dengan pesan sukses
        return redirect()->route('admin.assignments.index')->with('success', 'Assignment berhasil diupdate!');
    }

    // Menghapus assignment berdasarkan ID
    public function destroy($id)
    {
        // Mencari assignment berdasarkan ID, jika tidak ditemukan, akan mengembalikan 404
        $assignment = Assignment::findOrFail($id);
        $assignment->delete(); // Menghapus assignment dari database

        // Mengalihkan ke halaman index dengan pesan sukses
        return redirect()->route('admin.assignments.index')->with('success', 'Assignment berhasil dihapus!');
    }
}
