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

    public function create()
    {
        return view('tenant.create');
    }

    public function store(Request $request)
    {
        // Validasi dan simpan tenant baru (dummy/placeholder)
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $tenant = new \App\Models\Tenant();
        $tenant->name = $request->name;
        $tenant->description = $request->description;
        // Simpan logo jika ada
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('foto'), $filename);
            $tenant->logo = $filename;
        }
        $tenant->save();
        return redirect()->route('tenant.index')->with('success', 'Tenant berhasil ditambahkan!');
    }
}
