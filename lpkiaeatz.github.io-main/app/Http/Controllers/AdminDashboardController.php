<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'petugas') {
            abort(403);
        }
        return view('admin.dashboard');
    }
}
