<nav class="bg-blue-900 fixed top-0 w-full z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 text-white font-bold text-lg">
                <img src="/img/assbi-logo.png" class="h-8" onerror="this.style.display='none'">
                ASSBI Kebumen
            </a>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8 text-sm text-white">
                <a href="/tournaments" class="hover:text-yellow-400">Turnamen</a>
                <a href="/clubs" class="hover:text-yellow-400">Club</a>
                <a href="/news" class="hover:text-yellow-400">Berita</a>
                <a href="/articles" class="hover:text-yellow-400">Artikel</a>
            </div>

            {{-- Actions --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="/login" class="text-sm text-white hover:underline">Login</a>

                <a href="/register/club"
                   class="bg-yellow-400 text-blue-900 px-4 py-2 rounded-md text-sm font-semibold hover:bg-yellow-300">
                    Daftar Club
                </a>

                <a href="/register/eo"
                   class="border border-yellow-400 text-yellow-400 px-4 py-2 rounded-md text-sm hover:bg-yellow-400 hover:text-blue-900">
                    Daftar EO
                </a>
            </div>

            {{-- Mobile Button --}}
            <button data-collapse-toggle="mobile-menu"
                class="md:hidden text-white text-xl">
                ☰
            </button>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-blue-900 border-t border-blue-800">
        <div class="px-6 py-4 space-y-3 text-white text-sm">
            <a href="/tournaments" class="block">Turnamen</a>
            <a href="/clubs" class="block">Club</a>
            <a href="/news" class="block">Berita</a>
            <a href="/articles" class="block">Artikel</a>
            <hr class="border-blue-700">
            <a href="/login" class="block">Login</a>
            <a href="/register/club" class="block text-yellow-400 font-semibold">Daftar Club</a>
            <a href="/register/eo" class="block text-yellow-400">Daftar EO</a>
        </div>
    </div>
</nav>
