<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-white leading-tight uppercase tracking-tighter">
            👤 {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-10 min-h-screen" style="background-color: #0f172a;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-8 rounded-3xl" style="background:#1e293b; border: 1px solid rgba(255,255,255,0.05);">
                <div class="max-w-xl">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">Informasi Publik</h3>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 rounded-3xl" style="background:#1e293b; border: 1px solid rgba(255,255,255,0.05);">
                <div class="max-w-xl">
                    <h3 class="text-sm font-black uppercase tracking-widest text-slate-400 mb-6 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">Update Password</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 rounded-3xl" style="background:rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.2);">
                <div class="max-w-xl">
                    <h3 class="text-sm font-black uppercase tracking-widest text-red-400 mb-6 pb-4" style="border-bottom: 1px solid rgba(239,68,68,0.2);">⚠️ Hapus Akun</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>

    <style>
        input[type="text"], input[type="email"], input[type="password"] {
            background: #0f172a !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 0.75rem !important;
            color: white !important;
            font-weight: 600 !important;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 3px rgba(14,165,233,0.15) !important;
        }
        label {
            color: #94a3b8 !important;
            font-size: 0.7rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
        }
        button[type="submit"] {
            background-color: #0ea5e9 !important;
            border-radius: 0.75rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            color: white !important;
        }
    </style>
</x-app-layout>