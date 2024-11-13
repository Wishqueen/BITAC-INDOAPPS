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
        // Validate required fields, excluding role
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Check validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Default role assignment (e.g., "student")
        $role = 'student'; // You can change this to another default role if needed
    
        // Create the user with the default role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Assign default role
        ]);
    
        // Log the user in
        Auth::login($user);
    
        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
    

    // Login
    public function login(Request $request)
    {
        // Validate the login form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Retrieve the user based on email
        $user = User::where('email', $request->email)->first();
    
        // Check if the user exists
        if ($user) {
            // Check if the password is correct
            if (Hash::check($request->password, $user->password)) {
                // If the user is an instructor and not approved, show an error message
                if ($user->role === 'instructor' && $user->status !== 'approved') {
                    return back()->withErrors(['email' => 'Your account is still pending approval by the admin.']);
                }
    
                // Log the user in
                Auth::login($user);
    
                // Regenerate session to prevent session fixation
                $request->session()->regenerate();
    
                // Redirect to intended page or dashboard based on role
                return redirect()->route('course.index');
            } else {
                // Password is incorrect
                return back()->withErrors(['password' => 'The provided password is incorrect.']);
            }
        }
    
        // If the user does not exist
        return back()->withErrors(['email' => 'No account found with this email address.']);
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
