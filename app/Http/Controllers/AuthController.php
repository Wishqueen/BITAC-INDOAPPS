<?php

namespace App\Http\Controllers;

use App\Mail\YourCustomMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:student,instructor,admin', // Validate role input
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Store role in the database
        ]);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('course.index');
            } elseif ($user->role === 'instructor') {
                return redirect()->route('course.index');
            } else {
                return redirect()->route('course.index');
            }
        }
    
        return back()->withErrors(['error' => 'Email or password is incorrect.']);
    }
    

    // Forgot Password - Send Reset Link
// Forgot Password - Send Reset Link
public function forgotPassword(Request $request)
{
    // Validasi input email
    $request->validate([
        'email' => 'required|email',
    ]);

    // Ambil email dari request
    $email = $request->input('email');

    // Kirim reset link
    $status = Password::sendResetLink(['email' => $email]);

    // Cek status pengiriman
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
}

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    public function sendEmailFromRegisteredUser($userId)
    {
        // Dapatkan data pengguna berdasarkan ID
        $user = User::find($userId);
        config(['mail.from.address' => $user->email]);
        config(['mail.from.name' => $user->name]);
    
        // Kirim email menggunakan alamat email pengguna terdaftar
        Mail::to('recipient@example.com')->send(new YourCustomMail($user));
    }
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
