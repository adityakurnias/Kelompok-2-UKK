<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\SellerRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;  
class AdminController extends Controller
{
    // ========== DASHBOARD ==========
    public function dashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalSellers' => User::where('role', 'seller')->count(),
            'totalBuyers' => User::where('role', 'buyer')->count(),
            'totalProducts' => Product::count(),
            'pendingProducts' => Product::where('status', 'pending')->count(),
            'totalOrders' => Order::count(),
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'pendingRequests' => SellerRequest::where('status', 'pending')->count(),
        ];
        
        return view('admin.dashboard', $data);
    }
    
    // ========== USERS MANAGEMENT ==========
    public function users(Request $request)
    {
        $query = User::query();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:buyer,seller,admin',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ];

        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/users', $photoName);
            $data['photo'] = $photoName;
        }

        User::create($data);

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil ditambahkan');
    }
    
    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role == 'admin') {
            return back()->with('error', 'Tidak bisa memblokir admin!');
        }
        
        $user->update(['is_blocked' => true]);
        
        return back()->with('success', 'User berhasil diblokir');
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role == 'admin') {
            return back()->with('error', 'Tidak bisa menghapus admin!');
        }
        
        if ($user->photo) {
            Storage::delete('public/users/' . $user->photo);
        }
        
        $user->delete();
        
        return back()->with('success', 'User berhasil dihapus');
    }
    
    // ========== CATEGORIES MANAGEMENT ==========
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }
    
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);
        
        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name)
        ]);
        
        return back()->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        
        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name)
        ]);
        
        return back()->with('success', 'Kategori berhasil diupdate');
    }
    
    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk');
        }
        
        $category->delete();
        
        return back()->with('success', 'Kategori berhasil dihapus');
    }
    
    // ========== SELLER REQUESTS ==========
    public function sellerRequests(Request $request)
    {
        $query = SellerRequest::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('shop_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $requests = $query->latest()->paginate(10);
        
        $totalPending = SellerRequest::where('status', 'pending')->count();
        $totalApproved = SellerRequest::where('status', 'approved')->count();
        $totalRejected = SellerRequest::where('status', 'rejected')->count();
        
        return view('admin.seller-requests.index', compact(
            'requests', 
            'totalPending', 
            'totalApproved', 
            'totalRejected'
        ));
    }
    
    public function sellerRequestDetail($id)
    {
        $request = SellerRequest::with('user')->findOrFail($id);
        return view('admin.seller-requests.show', compact('request'));
    }
    
    // ========== METHOD APPROVE & REJECT ==========
    public function approveSeller(Request $request, $id)
    {
        $sellerRequest = SellerRequest::findOrFail($id);
        
        // Update status request
        $sellerRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => $request->note
        ]);
        
        // Update role user menjadi seller
        $sellerRequest->user->update(['role' => 'seller']);
        
        return redirect()->route('admin.seller-requests')
            ->with('success', 'Permohonan seller disetujui. User sekarang menjadi seller.');
    }
    
    public function rejectSeller(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:500'
        ]);
        
        $sellerRequest = SellerRequest::findOrFail($id);
        
        $sellerRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note' => $request->note
        ]);
        
        return redirect()->route('admin.seller-requests')
            ->with('success', 'Permohonan seller ditolak');
    }
    
    // ========== PRODUCT MODERATION ==========
    public function productModeration(Request $request)
    {
        $query = Product::with(['user', 'category']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'pending');
        }
        
        $products = $query->latest()->paginate(10);
        
        return view('admin.products.moderation', compact('products'));
    }
    
    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'tersedia']);
        
        return back()->with('success', 'Produk disetujui');
    }
    
    public function rejectProduct(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255'
        ]);
        
        $product = Product::findOrFail($id);
        $product->update([
            'status' => 'ditolak',
            'rejection_note' => $request->note
        ]);
        
        return back()->with('success', 'Produk ditolak');
    }
    
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }
        
        $product->delete();
        
        return back()->with('success', 'Produk berhasil dihapus');
    }
    
    // ========== ORDERS MANAGEMENT (SUDAH DIMODIFIKASI) ==========
    public function orders(Request $request)
    {
        $query = Order::with(['buyer', 'items.product']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        
        // Search by order number or buyer name
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('buyer', function($buyerQuery) use ($request) {
                      $buyerQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
        $orders = $query->latest()->paginate(10);
        
        // ========== TAMBAHKAN STATISTIK ORDERS ==========
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        // ================================================
        
        return view('admin.orders.index', compact(
            'orders', 
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'shippedOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }
    
    public function orderDetail($id)
    {
        $order = Order::with(['buyer', 'items.product', 'items.seller'])
                 ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }
}