<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-gray-800 leading-tight uppercase tracking-tighter italic">
            {{ __('PROFIL MENU') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#1a1c23] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-10 bg-white border-4 border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] rounded-none">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black uppercase mb-4 border-b-2 border-black inline-block">INFORMASI PUBLIK</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white border-4 border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] rounded-none">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black uppercase mb-4 border-b-2 border-black inline-block">UPDATE DATA</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white border-4 border-red-600 shadow-[10px_10px_0px_0px_rgba(220,38,38,1)] rounded-none">
                <div class="max-w-xl">
                    <h3 class="text-lg font-black uppercase mb-4 text-red-600 border-b-2 border-red-600 inline-block">PERINGATAN</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>

    <style>
        input[type="text"], input[type="email"], input[type="password"] {
            border: 2px solid #000 !important;
            border-radius: 0px !important;
            font-weight: 700 !important;
        }
        button[type="submit"] {
            background-color: #000 !important;
            border-radius: 0px !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
        }
    </style>
</x-app-layout>