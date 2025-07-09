<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionItem;

class TransactionItemController extends Controller
{
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $item = TransactionItem::findOrFail($id);
        // Optional: pastikan user hanya bisa memberi rating pada item miliknya
        if ($item->transaction->user_id !== auth()->id()) {
            abort(403);
        }
        $item->rating = $request->input('rating');
        $item->save();

        return back()->with('success', 'Rating berhasil disimpan!');
    }
}
