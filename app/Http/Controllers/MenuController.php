<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\NewOrderNotification;

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

        // Query 3 menu favorit: transaksi terbanyak & rating rata-rata tertinggi
        $favoriteMenusQuery = \App\Models\Menu::with('tenant') // eager loading tenant
            ->join('transaction_items', 'menus.id', '=', 'transaction_items.menu_id')
            ->selectRaw('menus.*, COUNT(transaction_items.id) as trx_count, AVG(transaction_items.rating) as avg_rating')
            ->groupBy('menus.id', 'menus.name', 'menus.category', 'menus.description', 'menus.price', 'menus.image', 'menus.tenant_id', 'menus.created_at', 'menus.updated_at');

        // Filter berdasarkan kategori jika ada
        if ($category) {
            $favoriteMenusQuery->where('menus.category', $category);
        }

        $favoriteMenus = $favoriteMenusQuery
            ->orderByDesc('trx_count')
            ->orderByDesc('avg_rating')
            ->take(3)
            ->get();

        $categories = Menu::select('category')->distinct()->pluck('category');
        $tenants = Tenant::all();
        return view('menu', compact('categories', 'tenants', 'favoriteMenus'));
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
        $vouchers = \App\Models\Voucher::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->get();
        // Tidak perlu eager loading di sini karena cart dari session
        return view('cart', compact('cart', 'vouchers'));
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
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => 'Keranjang berhasil diperbarui!',
                'cart' => $cart
            ]);
        }
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak bisa checkout');
        }
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,qris',
            'voucher_code' => 'nullable|string|exists:vouchers,code',
        ]);

        // Jika QRIS, status transaksi menunggu konfirmasi pembayaran
        $status = $request->payment_method === 'qris' ? 'pending_qris' : 'success';

        $voucher = null;
        $discountAmount = 0;
        if ($request->filled('voucher_code')) {
            $voucher = \App\Models\Voucher::where('code', $request->voucher_code)
                ->where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
                })->first();
            if ($voucher) {
                $total = collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; });
                if ($voucher->type == 'percent') {
                    $discountAmount = $total * ($voucher->discount / 100);
                } else {
                    $discountAmount = $voucher->discount;
                }
            }
        }

        $total = collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; });
        $totalAfterDiscount = max(0, $total - $discountAmount);

        // Simpan transaksi ke database
        $transaction = \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'total' => $totalAfterDiscount,
            'status' => $status,
            'payment_method' => $request->payment_method,
        ]);
        foreach ($cart as $menuId => $item) {
            \App\Models\TransactionItem::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $menuId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        // (Opsional) Simpan info voucher ke transaksi jika ingin tracking
        if ($voucher) {
            $transaction->voucher_code = $voucher->code;
            $transaction->discount = $discountAmount;
            $transaction->save();
        }
        // Kirim notifikasi ke semua petugas
        $petugas = User::where('role', 'petugas')->get();
        foreach ($petugas as $user) {
            $user->notify(new NewOrderNotification($transaction));
        }
        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('menu.index')->with('success', 'Pesanan dengan pembayaran ' . ($request->payment_method === 'qris' ? 'QRIS' : 'tunai') . ' berhasil diproses!' . ($voucher ? ' Voucher diterapkan.' : ''));
    }
public function search(Request $request)
{
    // Agar filter kategori & keyword bisa digabung
    return $this->index($request);
}

    public function create(Request $request)
    {
        $tenants = \App\Models\Tenant::all();
        $selectedTenant = $request->get('tenant_id');
        return view('menu_create', compact('tenants', 'selectedTenant'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'tenant_id' => 'required|exists:tenants,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        }

        \App\Models\Menu::create($validated);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }
    public function management(Request $request)
    {
        $tenants = \App\Models\Tenant::all();
        $selectedTenant = null;
        $menus = collect();
        if ($request->tenant_id) {
            $selectedTenant = \App\Models\Tenant::find($request->tenant_id);
            if ($selectedTenant) {
                $menus = $selectedTenant->menus;
            }
        }
        return view('admin.menu_management', compact('tenants', 'selectedTenant', 'menus'));
    }
    public function edit($id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $tenants = \App\Models\Tenant::all();
        return view('menu_create', [
            'menu' => $menu,
            'tenants' => $tenants,
            'selectedTenant' => $menu->tenant_id
        ]);
    }

    public function update(Request $request, $id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'tenant_id' => 'required|exists:tenants,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Jika ada file gambar baru diupload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Jika tidak upload gambar baru, gunakan gambar lama
            $validated['image'] = $menu->image;
        }
        $menu->update($validated);
        return redirect()->route('admin.menu.management', ['tenant_id' => $menu->tenant_id])->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy($id)
    {
        $menu = \App\Models\Menu::findOrFail($id);
        $tenantId = $menu->tenant_id;
        $menu->delete();
        return redirect()->route('admin.menu.management', ['tenant_id' => $tenantId])->with('success', 'Menu berhasil dihapus!');
    }
}
