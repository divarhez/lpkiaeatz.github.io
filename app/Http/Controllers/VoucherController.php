<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function available(Request $request)
    {
        $vouchers = Voucher::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->get();
        return response()->json($vouchers);
    }
}
