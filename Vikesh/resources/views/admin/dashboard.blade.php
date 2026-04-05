<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Manage Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-red { color: #E2231A; }
        .btn-red { background-color: #E2231A; transition: all 0.2s; }
        .btn-red:hover { background-color: #ba1d15; transform: translateY(-1px); }
        .input-box { border: 1px solid #e5e7eb; background: #f9fafb; padding: 12px; width: 100%; font-size: 14px; }
        .input-box:focus { border-color: #E2231A; outline: none; background: white; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">
<nav class="bg-black text-white px-8 py-5 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <h1 class="text-2xl font-extrabold tracking-tighter">
                BUITENZORG <span class="brand-red">TECH</span>SPERTS
            </h1>
        </div>

        <div class="flex items-center space-x-8 text-[12px] font-bold uppercase tracking-wide">
            <a href="{{ route('catalogue') }}" class="hover:text-red-500 transition">Catalogue</a>
            
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.add') }}" class="hover:text-red-500 transition"></a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

    <div class="bg-gray-50 border-b border-gray-200 py-3 px-8">
        <div class="max-w-7xl mx-auto text-[11px] text-gray-500 font-medium uppercase tracking-wider">
            ADMIN / DASHBOARD / <span class="text-black">INVENTORY MANAGEMENT</span>
        </div>
    </div>

    <header class="max-w-7xl mx-auto py-12 px-8">
        <h2 class="text-4xl font-bold tracking-tight text-gray-900 uppercase">Add New <span class="brand-red">Hardware Asset</span></h2>
        <div class="h-1 w-16 bg-red-600 mt-4"></div>
    </header>

    <main class="max-w-7xl mx-auto pb-24 px-8">
        <div class="bg-white border border-gray-200 p-10 mb-16 shadow-sm">
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Device Model / Name</label>
                        <input type="text" name="model" class="input-box" placeholder="e.g. Lenovo Thinkpad T440p" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Processor / CPU</label>
                            <input type="text" name="processor" class="input-box" placeholder="e.g. i5-4300M">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Memory / RAM</label>
                            <input type="text" name="ram" class="input-box" placeholder="e.g. 16GB">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Storage</label>
                            <input type="text" name="storage" class="input-box" placeholder="e.g. 256GB SSD">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Price (IDR)</label>
                            <input type="number" name="price" class="input-box" placeholder="1500000" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Technical Description</label>
                        <textarea name="description" class="input-box" rows="4" placeholder="Kondisi barang secara keseluruhan..."></textarea>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Hardware Preview</label>
                    <div id="image-preview-container" class="flex-grow border-2 border-dashed border-gray-200 rounded-lg flex flex-col items-center justify-center p-4 bg-gray-50 hover:border-red-500 transition-colors cursor-pointer relative overflow-hidden">
                        <div id="placeholder-content" class="text-center">
                            <svg class="w-10 h-10 text-gray-300 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Click to upload photo</span>
                        </div>
                        <img id="preview-img" src="" class="hidden max-h-full w-auto object-contain z-10">
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*" required>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="btn-red text-white w-full py-5 font-bold uppercase text-xs tracking-[0.2em] shadow-lg">
                            Publish to Catalogue
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-200">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h3 class="font-black uppercase tracking-tighter text-lg">Active <span class="brand-red">Inventory</span> List</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-100">
                            <th class="p-4 font-bold">Hardware Model</th>
                            <th class="p-4 font-bold">Specs Summary</th>
                            <th class="p-4 font-bold">Price</th>
                            <th class="p-4 font-bold text-right">Management</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach(\App\Models\Laptop::all() as $item)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                            <td class="p-4 font-bold uppercase text-gray-900">{{ $item->model }}</td>
                            <td class="p-4 text-gray-500 text-xs">{{ $item->processor }} / {{ $item->ram }} / {{ $item->storage }}</td>
                            <td class="p-4 font-semibold text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="{{ route('admin.edit', $item->id) }}" class="text-blue-600 font-bold text-[10px] uppercase hover:underline">Edit Asset</a>
                                    
                                    <form action="{{ route('admin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Confirm permanent removal of this asset?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 font-bold text-[10px] uppercase hover:underline">Remove Asset</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const imageInput = document.getElementById('image-input');
        const previewImg = document.getElementById('preview-img');
        const placeholder = document.getElementById('placeholder-content');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>