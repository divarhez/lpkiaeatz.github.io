<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'mahasiswa') {
            // User: show their own purchase history
            $transactions = Transaction::with('items.menu')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
            return view('orders.user_history', compact('transactions'));
        } else if ($user->role === 'petugas') {
            // Admin: show sales report per day/month
            $filter = $request->get('filter', 'day');
            if ($filter === 'month') {
                $reports = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as total_orders, SUM(total) as total_sales')
                    ->groupBy('period')
                    ->orderByDesc('period')
                    ->get();
            } else {
                $reports = Transaction::selectRaw('DATE(created_at) as period, COUNT(*) as total_orders, SUM(total) as total_sales')
                    ->groupBy('period')
                    ->orderByDesc('period')
                    ->get();
            }
            return view('orders.admin_report', compact('reports', 'filter'));
        }
        abort(403);
    }
}
