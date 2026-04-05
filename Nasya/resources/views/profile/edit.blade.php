<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#78350f] leading-tight uppercase tracking-wider" style="font-family: 'Playfair Display', serif;">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="p-6 sm:p-10 bg-white border-2 border-[#eaddcf] shadow-[8px_8px_0px_0px_rgba(120,53,15,0.1)] rounded-3xl">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold uppercase mb-6 text-[#78350f] border-b-2 border-[#fef3c7] inline-block" style="font-family: 'Playfair Display', serif;">
                        Informasi Pribadi
                    </h3>
                    <div class="prose prose-stone">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white border-2 border-[#eaddcf] shadow-[8px_8px_0px_0px_rgba(120,53,15,0.1)] rounded-3xl">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold uppercase mb-6 text-[#78350f] border-b-2 border-[#fef3c7] inline-block" style="font-family: 'Playfair Display', serif;">
                        Keamanan Akun
                    </h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-[#fff5f5] border-2 border-red-200 shadow-[8px_8px_0px_0px_rgba(220,38,38,0.05)] rounded-3xl">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold uppercase mb-6 text-red-700 border-b-2 border-red-200 inline-block" style="font-family: 'Playfair Display', serif;">
                        Hapus Akun
                    </h3>
                    <p class="text-sm text-red-600 mb-4 italic">Tindakan ini permanen. Mohon berhati-hati.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Styling Input agar sesuai tema kayu */
        input[type="text"], input[type="email"], input[type="password"], select, textarea {
            border: 1px solid #eaddcf !important;
            border-radius: 12px !important;
            padding: 10px 15px !important;
            background-color: #ffffff !important;
            color: #433422 !important;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #78350f !important;
            box-shadow: 0 0 0 3px rgba(120, 53, 15, 0.1) !important;
            outline: none !important;
        }

        /* Styling Tombol Utama */
        button[type="submit"], .btn-primary {
            background-color: #78350f !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        button[type="submit"]:hover {
            background-color: #451a03 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(120, 53, 15, 0.2) !important;
        }

        /* Label styling */
        label {
            color: #433422 !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            display: block;
        }
    </style>
</x-app-layout>
