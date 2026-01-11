<footer class="bg-[#0A1F44] text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-12 grid gap-8 md:grid-cols-3 text-sm">

        {{-- BRAND --}}
        <div>
            <h3 class="text-white font-bold text-lg mb-3">
                ASSBI Kebumen
            </h3>
            <p class="leading-relaxed text-gray-400">
                Asosiasi Sekolah Sepak Bola Indonesia Kabupaten Kebumen.<br>
                Sistem resmi kompetisi dan pembinaan sepak bola usia dini.
            </p>
        </div>

        {{-- MENU --}}
        <div>
            <h3 class="text-white font-bold mb-3">Navigasi</h3>
            <ul class="space-y-2">
                <li>
                    <a href="/tournaments" class="hover:text-white transition">
                        Turnamen
                    </a>
                </li>
                <li>
                    <a href="/clubs" class="hover:text-white transition">
                        Club
                    </a>
                </li>
                <li>
                    <a href="/news" class="hover:text-white transition">
                        Berita
                    </a>
                </li>
                <li>
                    <a href="/articles" class="hover:text-white transition">
                        Artikel
                    </a>
                </li>
            </ul>
        </div>

        {{-- CONTACT --}}
        <div>
            <h3 class="text-white font-bold mb-3">Kontak Resmi</h3>
            <p class="mb-2">
                📱 <span class="font-semibold">0856 0191 2609</span>
            </p>
            <p class="mb-2">
                📧 assbikabkebumen@gmail.com
            </p>
            <p>
                🌐 assbi-kebumen.id
            </p>
        </div>

    </div>

    {{-- COPYRIGHT --}}
    <div class="bg-[#081730] py-4 text-center text-xs text-gray-400">
        © {{ date('Y') }} ASSBI Kebumen — All rights reserved
    </div>
</footer>
