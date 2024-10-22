<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request; 
use App\Models\Course;
use App\Models\Transaction; 
use App\Models\TransactionItem; 
use Illuminate\Support\Facades\Log; 
use Midtrans\Config; 
use Midtrans\Snap; 

class CartController extends Controller 
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key'); // Mengambil server key dari konfigurasi
        Config::$isProduction = config('midtrans.is_production'); // Menentukan apakah ini produksi atau sandbox
        Config::$isSanitized = true; // Mengaktifkan sanitasi
        Config::$is3ds = true; // Mengaktifkan 3D Secure
    }

    // Menambahkan kursus ke dalam keranjang
    public function addToCart(Request $request, $id)
    {
        $course = Course::findOrFail($id); // Mencari kursus berdasarkan ID
        $cart = session()->get('cart', []); // Mengambil keranjang dari session, jika tidak ada, inisialisasi dengan array kosong

        // Tambahkan item ke keranjang
        $cart[$id] = [
            "course_id" => $course->id,
            "title" => $course->title,
            "price" => $course->price,
            "quantity" => 1, // Set default quantity
            "image" => $course->image,
        ];

        session()->put('cart', $cart); // Simpan keranjang yang sudah diperbarui ke session
        return redirect()->back()->with('success', 'Course added to cart successfully!'); // Mengalihkan kembali dengan pesan sukses
    }

    // Menampilkan view keranjang
    public function viewCart()
    {
        return view('cart.view'); // Mengembalikan view untuk menampilkan keranjang
    }

    // Menampilkan form checkout
    public function checkoutForm()
    {
        $cart = session()->get('cart'); // Mengambil keranjang dari session

        // Jika keranjang kosong, alihkan ke halaman view dengan pesan error
        if (!$cart) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // Hitung total amount
        $amount = 0;
        foreach ($cart as $item) {
            $amount += $item['price'] * $item['quantity']; // Menghitung total harga
        }

        // Generate transaction ID
        $trxid = 'TRX' . time(); // Membuat ID transaksi yang unik

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'id' => $trxid,
            'user_id' => auth()->id(), // ID pengguna yang sedang login
            'amount' => $amount,
            'status' => 'pending', // Status awal adalah pending
        ]);

        // Simpan setiap item dalam transaction_items
        foreach ($cart as $id => $details) {
            TransactionItem::create([
                'transaction_id' => $transaction->id, // ID transaksi
                'course_id' => $details['course_id'], // ID kursus
                'price' => $details['price'], // Harga kursus
                'quantity' => $details['quantity'], // Kuantitas
            ]);
        }

        // Konfigurasi data transaksi untuk Midtrans
        $midtransItems = [];
        foreach ($cart as $id => $details) {
            $midtransItems[] = [
                'id' => $id,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'name' => $details['title'],
            ];
        }

        // Data transaksi Midtrans
        $midtransData = [
            'transaction_details' => [
                'order_id' => $trxid,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name, // Nama depan pengguna
                'email' => auth()->user()->email, // Email pengguna
            ],
            'item_details' => $midtransItems, // Detail item untuk transaksi
        ];

        // Dapatkan Snap token dari Midtrans
        $snapToken = Snap::getSnapToken($midtransData); // Mendapatkan token untuk pembayaran

        // Kosongkan keranjang setelah transaksi
        session()->forget('cart');

        // Mengembalikan view checkout dengan data transaksi dan token
        return view('cart.checkout', compact('transaction', 'snapToken'));
    }

    // Menyelesaikan proses checkout
    public function checkout()
    {
        $cart = session()->get('cart'); // Mengambil keranjang dari session
        if (!$cart) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.'); // Jika keranjang kosong, alihkan dengan pesan error
        }

        $trxid = 'TRX' . time(); // Membuat ID transaksi yang unik

        // Hitung total amount
        $amount = 0;
        foreach ($cart as $item) {
            $amount += $item['price'] * $item['quantity']; // Menghitung total harga
        }

        // Buat transaksi di database
        $transaction = Transaction::create([
            'id' => $trxid,
            'user_id' => auth()->id(), // ID pengguna yang sedang login
            'amount' => $amount,
            'status' => 'pending', // Status awal adalah pending
        ]);

        // Simpan item ke dalam transaction_items
        foreach ($cart as $id => $details) {
            TransactionItem::create([
                'transaction_id' => $trxid,
                'course_id' => $details['course_id'], // ID kursus
                'price' => $details['price'], // Harga kursus
                'quantity' => $details['quantity'], // Kuantitas
            ]);
        }

        // Konfigurasi Midtrans untuk detail item
        $midtransItems = [];
        foreach ($cart as $id => $details) {
            $midtransItems[] = [
                'id' => $id,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'name' => $details['title'],
            ];
        }

        // Data transaksi untuk Midtrans
        $midtransData = [
            'transaction_details' => [
                'order_id' => $trxid,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name, // Nama depan pengguna
                'email' => auth()->user()->email, // Email pengguna
            ],
            'item_details' => $midtransItems, // Detail item untuk transaksi
        ];

        // Dapatkan Snap token dari Midtrans
        $snapToken = Snap::getSnapToken($midtransData);

        session()->forget('cart'); // Kosongkan keranjang setelah menyimpan transaksi

        // Mengembalikan view checkout dengan data transaksi dan token
        return view('cart.checkout', compact('transaction', 'snapToken'));
    }

    // Menangani pembayaran dari Midtrans
    public function handlePayment(Request $request)
    {
        // Dapatkan data dari callback Midtrans
        $serverKey = config('midtrans.server_key'); // Mengambil server key dari konfigurasi
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey); // Menghitung hash untuk verifikasi

        if ($hashed === $request->signature_key) { // Memverifikasi signature
            // Cek status pembayaran
            if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
                // Jika pembayaran sukses, update status transaksi
                $transaction = Transaction::where('id', $request->order_id)->first(); // Mencari transaksi berdasarkan order_id
                $transaction->status = 'paid'; // Mengubah status menjadi paid
                $transaction->save(); // Menyimpan perubahan

                session()->forget('cart'); // Mengosongkan keranjang

                return response()->json(['message' => 'Payment successful and cart reset!']); // Mengembalikan respon sukses
            }
        }

        return response()->json(['message' => 'Payment verification failed!'], 400); // Mengembalikan respon gagal jika verifikasi gagal
    }

    // Menangani callback dari Midtrans setelah pembayaran
    public function handlePaymentCallback(Request $request)
    {
        $transactionData = $request->all(); // Mengambil semua data dari callback

        // Temukan transaksi berdasarkan order_id
        $transaction = Transaction::where('id', $transactionData['order_id'])->first(); // Mencari transaksi berdasarkan order_id

        if ($transaction) {
            // Update status transaksi berdasarkan data callback
            $transaction->status = $transactionData['transaction_status']; // Mengubah status transaksi
            $transaction->save(); // Menyimpan perubahan
        }

        // Jika status transaksi adalah settlement, kurangi jumlah siswa
        if ($transactionData['transaction_status'] == 'settlement') {
            $course = Course::findOrFail($transaction->course_id); // Mencari kursus berdasarkan course_id

            // Kurangi jumlah siswa, pastikan tidak kurang dari 0
            $course->students = max($course->students - 1, 0); // Mengurangi jumlah siswa
            $course->save(); // Menyimpan perubahan

            session()->forget('cart'); // Mengosongkan keranjang setelah transaksi selesai
        }

        return response()->json(['status' => 'success']); // Mengembalikan respon sukses
    }

    // Menghapus item dari keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart'); // Mengambil keranjang dari session

        if (isset($cart[$id])) {
            unset($cart[$id]); // Hapus item dari keranjang
            session()->put('cart', $cart); // Simpan keranjang yang sudah diperbarui ke session
        }

        return redirect()->back()->with('success', 'Item removed from cart successfully!'); // Mengalihkan kembali dengan pesan sukses
    }
}
