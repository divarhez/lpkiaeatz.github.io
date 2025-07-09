<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Notifications\OrderStatusNotification;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Petugas: update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:proses,selesai',
        ]);
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();
        // Kirim notifikasi ke user
        $transaction->user->notify(new OrderStatusNotification($transaction, $request->status));
        return back()->with('success', 'Status pesanan diperbarui!');
    }
}
