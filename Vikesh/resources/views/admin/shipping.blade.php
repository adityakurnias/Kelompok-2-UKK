<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shipping | Buitenzorg TechSperts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        .lenovo-red { color: #E2231A; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-black text-white px-8 py-5 flex justify-between items-center border-b-2 border-red-600 shadow-2xl">
        <h1 class="text-xl font-extrabold tracking-tighter uppercase">
            BUITENZORG <span class="lenovo-red">TECH</span>SPERTS
        </h1>
        
        <div class="flex items-center space-x-6">
            <span class="text-gray-400 font-normal normal-case text-xs">Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
            <div class="flex items-center bg-gray-900 border border-gray-700 rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-widest">
                <button onclick="setLanguage('en')" id="btn-en" class="text-red-500 px-1">EN</button>
                <span class="text-gray-600 px-1">|</span>
                <button onclick="setLanguage('id')" id="btn-id" class="text-gray-400 px-1">ID</button>
            </div>
            <a href="{{ route('admin.add') }}" class="lang-target text-[10px] font-bold uppercase border border-white px-4 py-2 hover:bg-white hover:text-black transition"
               data-en="Back to Inventory" data-id="Kembali ke Inventaris">Back to Inventory</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-12 px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-black p-8 border-b-4 border-red-600 shadow-xl">
                <h4 class="lang-target text-gray-400 text-[10px] font-black uppercase tracking-widest" data-en="Total Revenue" data-id="Total Pendapatan">Total Revenue</h4>
                <p class="text-white text-2xl font-black mt-2">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-8 border border-gray-200 shadow-sm">
                <h4 class="lang-target text-gray-500 text-[10px] font-black uppercase tracking-widest" data-en="Total Units Sold" data-id="Total Unit Terjual">Total Units Sold</h4>
                <p class="text-2xl font-black text-red-600 mt-2">{{ $totalQtySold }} Units</p>
            </div>
            <div class="bg-white p-8 border border-gray-200 shadow-sm">
                <h4 class="lang-target text-gray-500 text-[10px] font-black uppercase tracking-widest" data-en="Pending Orders" data-id="Pesanan Tertunda">Pending Orders</h4>
                <p class="text-2xl font-black text-yellow-500 mt-2">{{ $pendingCount }} Orders</p>
            </div>
            <div class="bg-white p-8 border border-gray-200 shadow-sm">
                <h4 class="lang-target text-gray-500 text-[10px] font-black uppercase tracking-widest" data-en="Completed" data-id="Selesai">Completed</h4>
                <p class="text-2xl font-black text-green-600 mt-2">{{ $orders->where('status', 'completed')->count() }} Orders</p>
            </div>
        </div>

        <h2 class="text-lg font-black uppercase tracking-tighter mb-4 text-yellow-600">⚠️ Pending Shipments</h2>
        <div class="bg-white border-2 border-black shadow-xl overflow-hidden mb-12">
            <table class="w-full text-left border-collapse">
                <thead class="bg-yellow-400 text-black text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Item</th>
                        <th class="p-4 text-center">QTY</th>
                        <th class="p-4">Method</th>
                        <th class="p-4">Address</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @forelse($orders->where('status', 'pending') as $order)
                    <tr class="border-b border-gray-200 hover:bg-yellow-50 transition">
                        <td class="p-4 font-black">{{ $order->user->name }}</td>
                        <td class="p-4">
                            <div class="font-bold uppercase">{{ $order->laptop->model }}</div>
                            <div class="text-gray-400 text-[9px]">Total: Rp {{ number_format($order->laptop->price * $order->quantity, 0, ',', '.') }}</div>
                        </td>
                        <td class="p-4 text-center font-black">{{ $order->quantity }}</td>
                        <td class="p-4 font-bold uppercase text-gray-500">{{ $order->payment_method }}</td>
                        <td class="p-4 font-bold text-red-600 uppercase">{{ $order->alamat }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="w-full p-2 border-2 border-black font-black uppercase text-[9px] bg-yellow-400">
                                    <option value="pending" selected>Pending</option>
                                    <option value="shipped">Ship Now</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Delete this order?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-red-600 font-black text-[9px]">[ DELETE ]</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="p-8 text-center text-gray-400 italic">No pending orders.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

      <h2 class="text-lg font-black uppercase tracking-tighter mb-4 text-blue-600">🚚 Processed & History</h2>
<div class="bg-white border-2 border-black shadow-xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-black text-white text-[10px] font-black uppercase tracking-widest">
            <tr>
                <th class="p-4">Customer</th>
                <th class="p-4">Item</th>
                <th class="p-4 text-center">QTY</th>
                <th class="p-4">Method</th>
                <th class="p-4">Address</th>
                <th class="p-4 text-center">Status</th>
                <th class="p-4 text-center">Action</th> </tr>
        </thead>
        <tbody class="text-xs">
            @forelse($orders->whereIn('status', ['shipped', 'completed']) as $order)
            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                <td class="p-4 font-black uppercase text-gray-900">{{ $order->user->name }}</td>
                <td class="p-4">
                    <div class="font-bold uppercase tracking-tighter">{{ $order->laptop->model }}</div>
                    <div class="text-gray-400 text-[9px]">Total: Rp {{ number_format($order->laptop->price * $order->quantity, 0, ',', '.') }}</div>
                </td>
                <td class="p-4 text-center font-black border-x border-gray-50">{{ $order->quantity }}</td>
                <td class="p-4 font-bold uppercase text-gray-500">{{ $order->payment_method }}</td>
                <td class="p-4 font-bold text-red-600 uppercase">{{ $order->alamat }}</td>
                <td class="p-4">
                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="w-full p-2 border-2 border-black font-black uppercase text-[9px] cursor-pointer
                                {{ $order->status == 'shipped' ? 'bg-blue-600 text-white' : 'bg-green-600 text-white' }}">
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Arrived</option>
                        </select>
                    </form>
                </td>
                <td class="p-4 text-center">
                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Delete this history record?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-300 hover:text-red-600 transition font-black text-[9px] tracking-widest uppercase">
                            [ Delete ]
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="p-8 text-center text-gray-400 italic">No processed history.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
    </main>

    <script>
        function setLanguage(lang) {
            const targets = document.querySelectorAll('.lang-target');
            targets.forEach(el => {
                const translation = el.getAttribute(`data-${lang}`);
                if (translation) el.innerText = translation;
            });
            document.getElementById('btn-en').className = lang === 'en' ? 'text-red-500 px-1' : 'text-gray-400 px-1';
            document.getElementById('btn-id').className = lang === 'id' ? 'text-red-500 px-1' : 'text-gray-400 px-1';
        }
    </script>
</body>
</html>