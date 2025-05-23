<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Tenant; // Pastikan untuk mengimpor model Tenant
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $tenants = Tenant::all();  // Mengambil semua tenant
        return view('menu', compact('menus', 'tenants'));
    }

    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function updateCart(Request $request, $id)
    {
        if($request->quantity <= 0){
            return $this->removeFromCart($id);
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak bisa checkout');
        }

        // Simulasi menyimpan pesanan ke database (bisa dikembangkan)
        // Simpan data pesanan, kirim email, dll

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('menu.index')->with('success', 'Terima kasih! Pesanan anda berhasil diproses.');
    }
public function search(Request $request)
{
    $keyword = $request->input('keyword');

    $menus = Menu::query()
        ->where('name', 'LIKE', "%{$keyword}%")
        ->orWhere('description', 'LIKE', "%{$keyword}%")
        ->get();

    return view('menu', compact('menus'));
}


}
