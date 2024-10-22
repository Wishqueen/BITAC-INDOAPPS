<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Course; 
use App\Models\Transaction;
use App\Models\TransactionItem; 
use Illuminate\Support\Facades\Auth; 

class CourseController extends Controller 
{
    // Menampilkan daftar kursus dengan pagination
    public function index()
    {
        $courses = Course::paginate(6); // Menggunakan pagination secara langsung
        return view('courses.courses', compact('courses')); // Mengembalikan view daftar kursus
    }

    // Menampilkan kursus yang dimiliki oleh instruktur yang sedang login
    public function myCourses()
    {
        $instructorName = Auth::user()->name; // Mendapatkan nama instruktur dari pengguna yang sedang login
        $courses = Course::where('instructor', $instructorName)->paginate(6); // Mengambil kursus berdasarkan instruktur
        return view('courses.mycourses', compact('courses')); // Mengembalikan view kursus milik instruktur
    }

    // Menampilkan form untuk membuat kursus baru
    public function create()
    {
        return view('courses.create'); // Mengembalikan view untuk membuat kursus
    }

    // Menyimpan kursus baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'students' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        // Simpan gambar
        $imageName = time() . '.' . $request->image->extension(); // Membuat nama file unik untuk gambar
        $request->image->move(public_path('assets/img'), $imageName); // Memindahkan gambar ke folder yang ditentukan

        // Dapatkan nama instruktur dari pengguna yang sedang login
        $instructorName = Auth::user()->name;

        // Buat kursus baru
        Course::create([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'instructor' => $instructorName, // Nama instruktur dari user yang login
            'students' => $request->students,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('course.index')->with('success', 'Kursus berhasil ditambahkan.'); // Mengalihkan ke halaman daftar kursus dengan pesan sukses
    }

    // Menampilkan form untuk mengedit kursus
    public function edit($id)
    {
        $course = Course::findOrFail($id); // Mencari kursus berdasarkan ID
        return view('courses.update', compact('course')); // Mengembalikan view untuk memperbarui kursus
    }

    // Memperbarui detail kursus
    public function update(Request $request, Course $course)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'students' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        // Jika ada gambar baru diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if (file_exists(public_path('assets/img/' . $course->image))) {
                unlink(public_path('assets/img/' . $course->image)); // Menghapus gambar lama
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->image->extension(); // Membuat nama file unik untuk gambar baru
            $request->image->move(public_path('assets/img'), $imageName); // Memindahkan gambar baru
            $course->image = $imageName; // Memperbarui nama gambar
        }

        // Perbarui detail kursus
        $course->update([
            'title' => $request->title,
            'price' => $request->price,
            'duration' => $request->duration,
            'instructor' => Auth::user()->name, // Update instruktur
            'students' => $request->students,
            'description' => $request->description,
        ]);

        return redirect()->route('course.index')->with('success', 'Kursus berhasil diperbarui.'); // Mengalihkan ke halaman daftar kursus dengan pesan sukses
    }

    // Menghapus kursus
    public function destroy($id)
    {
        $course = Course::findOrFail($id); // Mencari kursus berdasarkan ID

        // Hapus gambar jika ada
        if (file_exists(public_path('assets/img/' . $course->image))) {
            unlink(public_path('assets/img/' . $course->image)); // Menghapus gambar kursus
        }

        $course->delete(); // Menghapus kursus dari database
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.'); // Mengalihkan ke halaman daftar kursus dengan pesan sukses
    }

    // Menampilkan detail kursus
    public function show($id)
    {
        $course = Course::findOrFail($id); // Mencari kursus berdasarkan ID

        // Cek apakah user sudah memiliki transaksi yang dikonfirmasi untuk kursus ini
        $transaction = TransactionItem::whereHas('transaction', function($query) {
            $query->where('user_id', Auth::id()) // Memastikan transaksi milik pengguna yang sedang login
                  ->where('status', 'settlement'); // Memastikan status transaksi adalah settlement
        })
        ->where('course_id', $id) // Mencari transaksi yang berkaitan dengan kursus ini
        ->first(); // Mengambil transaksi pertama yang ditemukan

        return view('courses.detailcourse', compact('course', 'transaction')); // Mengembalikan view detail kursus
    }

    // Menampilkan materi kursus
    public function showMaterials($courseId)
    {
        $course = Course::with('learningMaterials')->findOrFail($courseId); // Mencari kursus dengan materi belajar terkait

        // Cek apakah user sudah memiliki transaksi yang dikonfirmasi untuk kursus ini
        $transaction = Transaction::where('user_id', Auth::id()) // Memastikan transaksi milik pengguna yang sedang login
            ->whereHas('transactionItems', function ($query) use ($courseId) {
                $query->where('course_id', $courseId); // Mencari item transaksi yang berkaitan dengan kursus ini
            })
            ->where('status', 'settlement') // Pastikan transaksi sudah dikonfirmasi
            ->first(); // Mengambil transaksi pertama yang ditemukan

        // Cek jika tidak ada transaksi yang valid, redirect dengan pesan error
        if (!$transaction) {
            return redirect()->back()->with('error', 'You do not have access to this course.'); // Mengalihkan kembali dengan pesan error
        }

        // Kirim course dan transaction ke view
        return view('courses.materials', compact('course', 'transaction')); // Mengembalikan view materi kursus
    }
}
