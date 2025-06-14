<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Tenant;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index(Request $request)
    {
        $category = $request->input('category');
        $keyword = $request->input('keyword');

        $query = Menu::query();
        if ($category) {
            $query->where('category', $category);
        }
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%$keyword%")
                  ->orWhere('description', 'LIKE', "%$keyword%") ;
            });
        }
        $menus = $query->get();
        $categories = Menu::select('category')->distinct()->pluck('category');
        $tenants = Tenant::all();
        return view('menu', compact('menus', 'categories', 'tenants'));
    }

    public function addToCart(Request $request, $id)
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
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => 'Menu berhasil ditambahkan ke keranjang!']);
        }
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
    // Agar filter kategori & keyword bisa digabung
    return $this->index($request);
}

    public function create()
    {
        return view('menu_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
        ]);
        \App\Models\Menu::create($validated);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }
}
