<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = \App\Models\Tenant::all();
        return view('tenant.index', compact('tenants'));
    }

    public function show($id)
    {
        $tenant = Tenant::with('menus')->findOrFail($id);
        return view('tenant.show', compact('tenant'));
    }
}
