<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Transaction;

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
}

