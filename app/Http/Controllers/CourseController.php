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
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // Ensure price is non-negative
            'discount' => 'nullable|numeric|min:0|max:100', // Optional discount, 0-100
            'duration' => 'required|string',
            'students' => 'required|integer|min:1', // Ensure at least one student
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);
    
        // Save image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('assets/img'), $imageName);
    
        // Get instructor name from the logged-in user
        $instructorName = Auth::user()->name;
    
        // Calculate discounted price if discount is provided
        $discount = $validatedData['discount'] ?? 0; // Default to 0 if not provided
        $discountedPrice = $this->calculateDiscountedPrice($validatedData['price'], $discount);
    
        // Create a new course
        Course::create([
            'title' => $validatedData['title'],
            'price' => $validatedData['price'], // Save the original price
            'discount' => $discount, // Save the discount percentage
            'discounted_price' => $discountedPrice, // Save the final price after discount
            'duration' => $validatedData['duration'],
            'instructor' => $instructorName,
            'students' => $validatedData['students'],
            'image' => $imageName,
            'description' => $validatedData['description'],
        ]);
    
        return redirect()->route('course.index')->with('success', 'Kursus berhasil ditambahkan.');
    }
    
    /**
     * Calculate discounted price based on original price and discount percentage.
     *
     * @param float $price
     * @param float $discount
     * @return float
     */
    private function calculateDiscountedPrice($price, $discount)
    {
        return $price - ($price * $discount / 100);
    }
    
    

    // Menampilkan form untuk mengedit kursus
    public function edit($id)
    {
        $course = Course::findOrFail($id); // Mencari kursus berdasarkan ID
        return view('courses.update', compact('course')); // Mengembalikan view untuk memperbarui kursus
    }

    // Memperbarui detail kursus
    public function update(Request $request, $id)
    {
        // Find the course by ID
        $course = Course::findOrFail($id);
    
        // Validate input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // Ensure price is non-negative
            'discount' => 'nullable|numeric|min:0|max:100', // Optional discount, 0-100
            'duration' => 'required|string',
            'students' => 'required|integer|min:1', // Ensure at least one student
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is optional
            'description' => 'required|string',
        ]);
    
        // Calculate discounted price if discount is provided
        $discount = $validatedData['discount'] ?? 0; // Default to 0 if not provided
        $discountedPrice = $this->calculateDiscountedPrice($validatedData['price'], $discount);
    
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Save the new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/img'), $imageName);
    
            // Delete the old image (optional)
            if ($course->image && file_exists(public_path('assets/img/' . $course->image))) {
                unlink(public_path('assets/img/' . $course->image));
            }
        } else {
            // Keep the old image if no new image is uploaded
            $imageName = $course->image;
        }
    
        // Update the course record
        $course->update([
            'title' => $validatedData['title'],
            'price' => $validatedData['price'], // Save the original price
            'discount' => $discount, // Save the discount percentage
            'discounted_price' => $discountedPrice, // Save the final price after discount
            'duration' => $validatedData['duration'],
            'students' => $validatedData['students'],
            'image' => $imageName,
            'description' => $validatedData['description'],
        ]);
    
        return redirect()->route('course.index')->with('success', 'Kursus berhasil diperbarui.');
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
