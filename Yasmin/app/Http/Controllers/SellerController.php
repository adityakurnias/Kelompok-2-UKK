<?php
// app/Http/Controllers/SellerController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\SellerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // ========== DASHBOARD ==========
    public function dashboard()
    {
        $user = Auth::user();

        $totalProducts = Product::where('user_id', $user->id)->count();
        $activeProducts = Product::where('user_id', $user->id)->where('status', 'tersedia')->count();
        $pendingProducts = Product::where('user_id', $user->id)->where('status', 'pending')->count();
        $soldProducts = Product::where('user_id', $user->id)->where('status', 'terjual')->count();

        $totalOrders = OrderItem::where('seller_id', $user->id)->count();
        $pendingOrders = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', fn($q) => $q->where('status', 'pending'))->count();
        $shippedOrders = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', fn($q) => $q->where('status', 'shipped'))->count();
        $completedOrders = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', fn($q) => $q->where('status', 'completed'))->count();

        $recentOrders = OrderItem::with(['order', 'product'])
            ->where('seller_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'pendingProducts',
            'soldProducts',
            'totalOrders',
            'pendingOrders',
            'shippedOrders',
            'completedOrders',
            'recentOrders'
        ));
    }

    // ========== MANAJEMEN PRODUK ==========
    public function products()
    {
        $products = Product::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:baru,seperti_baru,bekas',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Simpan gambar dengan nama unik
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->extension();
        $image->storeAs('products', $imageName, 'public');

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'status' => 'pending', // ← admin harus approve dulu
            'image' => $imageName,
        ]);

        return redirect()->route('seller.products')
            ->with('success', 'Produk berhasil ditambahkan! Menunggu persetujuan admin.');
    }

    public function editProduct(Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:baru,seperti_baru,bekas',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'status' => 'pending', // ← setelah edit, pending lagi untuk re-moderasi
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika bukan default
            if ($product->image && $product->image !== 'default-product.jpg') {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('seller.products')
            ->with('success', 'Produk berhasil diupdate! Menunggu persetujuan admin kembali.');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->user_id != Auth::id()) {
            abort(403);
        }

        // Hapus file gambar jika bukan default
        if ($product->image && $product->image !== 'default-product.jpg') {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('seller.products')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // ========== PESANAN MASUK ==========
    public function orders()
    {
        $orderItems = OrderItem::with(['order', 'product', 'order.buyer'])
            ->where('seller_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orderItems'));
    }

    public function confirmOrder(Order $order)
    {
        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Pesanan dikonfirmasi.');
    }

    public function shipOrder(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string',
            'courier' => 'required|string',
        ]);

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $request->tracking_number,
            'courier' => $request->courier,
        ]);

        return back()->with('success', 'Status pengiriman diupdate.');
    }

    // ========== SELLER REQUEST ==========
    public function showRequestForm()
    {
        $user = Auth::user();

        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah menjadi seller!');
        }

        $existingRequest = SellerRequest::where('user_id', $user->id)->first();

        if ($existingRequest && $existingRequest->status !== 'rejected') {
            return redirect()->route('seller.request-status')
                ->with('info', 'Anda sudah mengajukan permohonan seller. Status: ' . $existingRequest->status);
        }

        return view('buyer.seller-request');
    }

    public function submitRequest(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'required|string|min:20',
            'shop_address' => 'required|string',
            'whatsapp_number' => 'required|string|max:20',
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ktpPath = null;
        if ($request->hasFile('ktp_image')) {
            $ktpPath = time() . '_' . uniqid() . '.' . $request->file('ktp_image')->extension();
            $request->file('ktp_image')->storeAs('ktp', $ktpPath, 'public');
        }

        SellerRequest::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'shop_name' => $request->shop_name,
                'shop_description' => $request->shop_description,
                'shop_address' => $request->shop_address,
                'whatsapp_number' => $request->whatsapp_number,
                'ktp_image' => $ktpPath,
                'status' => 'pending',
                'admin_note' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]
        );

        return redirect()->route('seller.request-status')
            ->with('success', 'Permohonan seller berhasil dikirim! Admin akan memverifikasi dalam 1x24 jam.');
    }

    public function requestStatus()
    {
        $user = Auth::user();
        $sellerRequest = SellerRequest::where('user_id', $user->id)->first();

        if (!$sellerRequest) {
            return redirect()->route('seller.request')
                ->with('error', 'Anda belum mengajukan permohonan seller.');
        }

        return view('buyer.seller-request-status', compact('sellerRequest'));
    }
}