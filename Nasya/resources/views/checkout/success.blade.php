<x-app-layout>
    <div class="py-12 bg-[#F9F7F2] min-h-screen flex items-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[3rem] shadow-xl shadow-[#78350f]/5 p-12 text-center border border-[#eaddcf]">

                <div class="w-24 h-24 bg-[#f0fdf4] text-[#166534] rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="text-4xl font-bold text-[#433422] mb-3" style="font-family: 'Playfair Display', serif;">Pesanan Berhasil!</h1>
                <p class="text-[#7d6e5d] font-medium mb-10">Terima kasih telah mempercayakan keindahan hunian Anda kepada kami. Pesanan Anda kini sedang kami persiapkan.</p>

                <div class="bg-[#fef3c7]/50 border border-[#fde68a] rounded-[2rem] p-8 mb-10 text-left">
                    <h3 class="font-bold text-[#78350f] mb-4 flex items-center gap-3 uppercase tracking-widest text-xs">
                        <svg xmlns="http://www.w3.org/2000/center" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Instruksi Pembayaran:
                    </h3>
                    <ul class="text-sm text-[#92400e] space-y-3 font-medium">
                        <li class="flex items-start gap-2">
                            <span class="text-[#78350f]">•</span>
                            Silakan transfer ke rekening <strong class="text-[#78350f]">Bank BCA 123-456-7890</strong> a/n <strong class="text-[#78350f]">FurniSpace Premium</strong>.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#78350f]">•</span>
                            Mohon pastikan nominal sesuai dengan total tagihan hingga digit terakhir.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#78350f]">•</span>
                            Unggah atau simpan bukti transfer Anda untuk mempercepat proses verifikasi oleh tim kami.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#78350f]">•</span>
                            Status pesanan Anda akan diperbarui secara otomatis dalam 1x24 jam setelah diverifikasi.
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.index') }}" class="bg-[#78350f] text-white px-10 py-4 rounded-2xl font-bold hover:bg-[#451a03] transition-all shadow-lg shadow-[#78350f]/20 uppercase tracking-tighter text-sm">
                        Lihat Riwayat Pesanan
                    </a>
                    <a href="{{ route('products.index') }}" class="bg-[#F9F7F2] text-[#78350f] border-2 border-[#78350f] px-10 py-4 rounded-2xl font-bold hover:bg-[#78350f] hover:text-white transition-all uppercase tracking-tighter text-sm">
                        Kembali ke Katalog
                    </a>
                </div>
            </div>

            <p class="text-center mt-8 text-[#7d6e5d] text-xs">Butuh bantuan? Hubungi layanan pelanggan kami melalui WhatsApp.</p>
        </div>
    </div>
</x-app-layout>
