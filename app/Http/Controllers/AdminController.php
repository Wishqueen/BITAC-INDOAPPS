<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\instructor;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::with('user', 'course')->where('status', 'pending')->get();
        return view('admin.transactions', compact('transactions'));
    }

    public function confirmTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'confirmed']);

        return redirect()->route('admin.transactions')->with('success', 'Transaction confirmed successfully.');
    }

    public function rejectTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);

        return redirect()->route('admin.transactions')->with('error', 'Transaction rejected.');
    }

    public function pendingInstructors()
    {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('/')->with('error', 'You do not have permission to access this page.');
        }
        // Fetch all instructors with 'pending' status
        $instructors = Instructor::all();
        return view('instructors.pending', compact('instructors'));
    }
    
    public function approveInstructor($id)
    {
        // Find the instructor and approve them
        $instructor = Instructor::findOrFail($id);
    
        // Generate a random password for the new user
        $password = Str::random(8);
    
        // Update instructor status to 'approved'
        $instructor->status = 'approved';
        $instructor->save();
    
        // Create a user account for the instructor with the generated password
        $user = User::firstOrCreate([
            'email' => $instructor->email
        ], [
            'name' => $instructor->name,
            'password' => Hash::make($password),
            'role' => 'instructor',
            'status' => $instructor->status,
        ]);
    
        // Redirect back with the generated email and password details
        return redirect()->route('admin.instructors.pending')
            ->with('success', "Instructor approved successfully. Email: {$instructor->email}, Password: {$password}");
    }
    
    public function rejectInstructor($id)
    {
        // Find the instructor in the Instructor table
        $instructor = Instructor::findOrFail($id);
    
        // Update the status of the instructor to 'rejected'
        $instructor->status = 'rejected';
        $instructor->save();
    
        // Find and delete the associated user record from the User table
        $user = User::where('email', $instructor->email)->first();
        
        if ($user) {
            $user->delete();  // Delete the user from the users table
        }
    
        // Redirect back with a success message indicating the instructor was rejected
        return redirect()->route('admin.instructors.pending')->with('success', 'Instructor rejected and user account deleted successfully.');
    }
    
    

}

