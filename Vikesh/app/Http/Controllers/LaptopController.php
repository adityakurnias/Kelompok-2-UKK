<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop; 
use App\Models\Order; // Pastikan ini di-import / Make sure this is imported
use Illuminate\Support\Facades\Auth;

class LaptopController extends Controller
{
    // 1. Show all laptops in the catalogue
    public function index()
    {
        $laptops = Laptop::all();
        return view('catalogue', compact('laptops'));
    }

    // 2. Show the professional Admin Dashboard form + INFOS & ORDERS
    public function create()
    {
        // Mengambil data untuk tabel inventaris / Fetching inventory data
        $laptops = Laptop::all(); 

        // Mengambil data pesanan untuk tabel di bawah / Fetching order data for the bottom table
        $orders = Order::with(['user', 'laptop'])->latest()->get();

        // Menghitung statistik untuk bagian "Infos" / Calculating stats for the "Infos" section
        $totalSales = Order::where('status', 'completed')->sum('quantity');
        $pendingCount = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'completed')->get()->sum(function($order) {
            return $order->quantity * $order->laptop->price;
        });

        return view('admin.dashboard', compact('laptops', 'orders', 'totalSales', 'pendingCount', 'totalRevenue')); 
    }

    // 3. Save the new laptop
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        } else {
            $imagePath = 'images/t440p.jpg'; 
        }

        Laptop::create([
            'model'       => $request->model,
            'processor'   => $request->processor,
            'ram'         => $request->ram,
            'storage'     => $request->storage,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath, 
        ]);

        return redirect()->route('admin.add')->with('success', 'Laptop added to catalogue!');
    }

    // NEW: Fungsi untuk menyimpan pesanan dari form checkout
    // NEW: Function to save orders from the checkout form
    public function storeOrder(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'alamat' => 'required',
            'payment_method' => 'required'
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'laptop_id' => $id,
            'quantity' => $request->quantity,
            'alamat' => $request->alamat,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    // 4. Show the checkout page for a specific laptop
    public function checkout($id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('checkout', compact('laptop'));
    }

    public function destroy($id) {
        Laptop::destroy($id);
        return back()->with('success', 'Asset removed');
    }

    public function edit($id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('admin.edit', compact('laptop'));
    }

    public function update(Request $request, $id)
    {
        $laptop = Laptop::findOrFail($id);

        $request->validate([
            'model' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $laptop->model = $request->model;
        $laptop->processor = $request->processor;
        $laptop->ram = $request->ram;
        $laptop->storage = $request->storage;
        $laptop->price = $request->price;
        $laptop->description = $request->description;

        if ($request->hasFile('image')) {
            if (file_exists(public_path($laptop->image)) && $laptop->image != 'images/t440p.jpg') {
                unlink(public_path($laptop->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $laptop->image = 'images/' . $filename;
        }

        $laptop->save();

        return redirect()->route('admin.add')->with('success', 'Hardware asset updated successfully!');
    }

    public function userOrders()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('laptop')
                       ->latest()
                       ->get();

        return view('orders', compact('orders'));
    }

    // Menampilkan halaman khusus pengiriman
// Displaying the dedicated shipping page
public function manageShipping()
{
    $orders = Order::with(['user', 'laptop'])->latest()->get();
    
    // Hitung total unit yang terjual / Calculate total units sold
    $totalQtySold = $orders->where('status', 'completed')->sum('quantity');

    // Hitung total revenue / Calculate total revenue
    $totalProfit = $orders->where('status', 'completed')->sum(function($order) {
        return $order->laptop->price * $order->quantity;
    });

    $pendingCount = $orders->where('status', 'pending')->count();
    $shippedCount = $orders->where('status', 'shipped')->count();

    return view('admin.shipping', compact('orders', 'totalProfit', 'pendingCount', 'shippedCount', 'totalQtySold'));
}

// Fungsi untuk update status dari dropdown
// Function to update status from the dropdown
public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Status Updated!');
}

public function deleteOrder($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return back()->with('success', 'Order Deleted Successfully!');
}
}