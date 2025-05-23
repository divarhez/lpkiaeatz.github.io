<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class StokMakananController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('stok_makanan.index', compact('menus'));
    }

    public function create()
    {
        return view('stok_makanan.create');
    }

    public function store(Request $request)
    {
        Menu::create($request->all());
        return redirect()->route('stok-makanan.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $stok_makanan)
    {
        return view('stok_makanan.edit', ['menu' => $stok_makanan]);
    }

    public function update(Request $request, Menu $stok_makanan)
    {
        $stok_makanan->update($request->all());
        return redirect()->route('stok-makanan.index')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy(Menu $stok_makanan)
    {
        $stok_makanan->delete();
        return redirect()->route('stok-makanan.index')->with('success', 'Menu berhasil dihapus');
    }
}
