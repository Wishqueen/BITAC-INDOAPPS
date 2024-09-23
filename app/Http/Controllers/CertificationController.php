<?php
namespace App\Http\Controllers;

use App\Models\certification;
use App\Models\course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
    // Menampilkan halaman daftar sertifikasi dan kursus
    public function index()
    {
        $certifications = Certification::with('course')->get();
        $courses = Course::all();
        return view('certifications.index', compact('certifications', 'courses'));
    }
       

    // Menyimpan sertifikasi baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'course_id' => 'required|exists:courses,id', // Validasi course_id
        ]);

        // Simpan gambar ke direktori public/images dan dapatkan path-nya
        $imagePath = $this->saveImage($request->file('image'));

        // Buat sertifikasi baru dengan data yang tervalidasi
        Certification::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'user_id' => Auth::id(), // Ambil user_id dari user yang sedang login
            'course_id' => $validatedData['course_id'], // Ambil course_id dari input
        ]);

        // Redirect ke halaman index sertifikasi dengan notifikasi sukses
        return redirect()->route('certifications.index')->with('success', 'Certification added successfully.');
    }

    // Mengupdate sertifikasi yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Cari sertifikasi yang akan diupdate
        $certification = Certification::findOrFail($id);

        // Jika ada gambar baru yang diupload, simpan dan hapus gambar lama
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $this->deleteImage($certification->image);

            // Simpan gambar baru
            $imagePath = $this->saveImage($request->file('image'));
            $certification->image = $imagePath;
        }

        // Update sertifikasi dengan data yang baru
        $certification->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'course_id' => $validatedData['course_id'],
        ]);

        return redirect()->route('certifications.index')->with('success', 'Certification updated successfully.');
    }

    // Menghapus sertifikasi
    public function destroy($id)
    {
        // Cari sertifikasi yang akan dihapus
        $certification = Certification::findOrFail($id);

        // Hapus gambar
        $this->deleteImage($certification->image);

        // Hapus data sertifikasi dari database
        $certification->delete();

        return redirect()->route('certifications.index')->with('success', 'Certification deleted successfully.');
    }

    // Fungsi untuk menyimpan gambar ke direktori public/images
    private function saveImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $imageName);
        return 'images/' . $imageName;
    }

    // Fungsi untuk menghapus gambar dari direktori public/images
    private function deleteImage($imagePath)
    {
        $fullImagePath = public_path($imagePath);

        // Cek apakah file ada sebelum menghapus
        if (file_exists($fullImagePath)) {
            unlink($fullImagePath);
        }
    }
}
