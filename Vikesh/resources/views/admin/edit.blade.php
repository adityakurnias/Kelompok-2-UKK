<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buitenzorg TechSperts | Edit Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-red { color: #E2231A; }
        .btn-red { background-color: #E2231A; transition: all 0.2s; }
        .btn-red:hover { background-color: #ba1d15; }
        .input-box { border: 1px solid #e5e7eb; background: #f9fafb; padding: 12px; width: 100%; font-size: 14px; }
        .input-box:focus { border-color: #E2231A; outline: none; background: white; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <nav class="bg-black text-white px-8 py-5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-extrabold tracking-tighter">BUITENZORG <span class="brand-red">TECH</span>SPERTS</h1>
            <a href="{{ route('admin.add') }}" class="text-[12px] font-bold uppercase tracking-wide hover:text-red-500 transition">← Back to Inventory</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-12 px-8">
        <header class="mb-10">
            <h2 class="text-4xl font-bold tracking-tight uppercase">Edit <span class="brand-red">Asset Details</span></h2>
            <p class="text-gray-500 text-sm mt-2">Updating: {{ $laptop->model }}</p>
        </header>

        <div class="bg-white border border-gray-200 p-10 shadow-sm">
            <form action="{{ route('admin.update', $laptop->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Device Model</label>
                        <input type="text" name="model" class="input-box" value="{{ $laptop->model }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="processor" class="input-box" placeholder="Processor" value="{{ $laptop->processor }}">
                        <input type="text" name="ram" class="input-box" placeholder="RAM" value="{{ $laptop->ram }}">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="storage" class="input-box" placeholder="Storage" value="{{ $laptop->storage }}">
                        <input type="number" name="price" class="input-box" placeholder="Price" value="{{ $laptop->price }}" required>
                    </div>

                    <textarea name="description" class="input-box" rows="4" placeholder="Description">{{ $laptop->description }}</textarea>
                </div>

                <div class="flex flex-col">
                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-2">Hardware Preview</label>
                    <div id="image-preview-container" class="flex-grow border-2 border-dashed border-gray-200 rounded-lg flex flex-col items-center justify-center p-4 bg-gray-50 relative overflow-hidden">
                        
                        <img id="preview-img" src="{{ asset($laptop->image) }}" class="max-h-full w-auto object-contain z-10">
                        
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*">
                        
                        <div class="absolute bottom-2 bg-black/50 text-white text-[9px] px-2 py-1 uppercase z-30 pointer-events-none">
                            Click to change image
                        </div>
                    </div>

                    <button type="submit" class="btn-red text-white w-full py-5 mt-8 font-bold uppercase text-xs tracking-[0.2em] shadow-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Preview logic for when you select a NEW image
        document.getElementById('image-input').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>