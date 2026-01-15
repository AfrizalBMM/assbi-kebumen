<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- 🔥 WAJIB -->
    <title>@yield('title','Club ASSBI')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css" rel="stylesheet">
    <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>
</head>


<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    <!-- OVERLAY MOBILE -->
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-[#0A1F44] text-white
               flex flex-col transform -translate-x-full md:translate-x-0
               transition-transform duration-300">

        <div class="p-5 text-xl font-bold border-b border-blue-800">
            🏟️ CLUB / SSB
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">
            <a href="{{ route('club.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-800">📊 Dashboard</a>
            <a href="{{ route('club.profile') }}" class="block px-4 py-2 rounded hover:bg-blue-800">📝 Profil Club</a>
            <a href="{{ route('club.players.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800">👥 Data Pemain</a>
            <a href="{{ route('club.kta-backgrounds.index') }}"
            class="block px-4 py-2 rounded hover:bg-blue-800">
                🎴 Background KTA
            </a>
            <a href="{{ route('club.lineups.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800">⚽ Formasi</a>
            <a href="{{ route('club.tournaments.index') }}" class="block px-4 py-2 rounded hover:bg-blue-800">🏆 Daftar Turnamen</a>
        </nav>
    </aside>

    <!-- MAIN AREA -->
    <div class="flex-1 flex flex-col md:ml-64">

        <!-- TOP BAR -->
        <header class="bg-white border-b px-4 py-3 flex justify-between items-center sticky top-0 z-20">

            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()"
                        class="md:hidden p-2 rounded bg-blue-600 text-white">
                    ☰
                </button>

                <h1 class="text-lg font-semibold text-blue-900">
                    @yield('page_title','Dashboard Club')
                </h1>
            </div>

            <div class="flex items-center gap-4">

                <!-- Club Logo Bubble -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-blue-600 bg-white shadow">
                        @if(auth()->user()->club && auth()->user()->club->logo)
                            <img src="{{ asset('storage/'.auth()->user()->club->logo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-blue-700">SSB</div>
                        @endif
                    </div>

                    <div class="text-sm">
                        <div class="font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500">CLUB</div>
                    </div>
                </div>

                <!-- Logout -->
                <form id="logoutForm" method="POST" action="/logout">
                    @csrf
                    <button type="button"
                        onclick="confirmAction('Keluar dari sistem sekarang?','danger',()=>document.getElementById('logoutForm').submit())"
                        class="px-4 py-2 rounded bg-red-600 text-white text-sm hover:bg-red-700">
                        Logout
                    </button>
                </form>

            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-auto">
            <div class="px-6 py-4">
                @yield('content')
            </div>
        </main>

    </div>
</div>

<!-- CONFIRM MODAL -->
<div id="confirmModal"
     class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

    <div id="confirmBox" class="bg-white w-[420px] rounded-xl shadow-xl p-6 border-t-8">
        <h3 class="text-lg font-bold mb-2">Konfirmasi Aksi</h3>
        <p class="text-sm text-gray-600 mb-6" id="confirmMessage"></p>

        <div class="flex justify-end gap-3">
            <button onclick="closeConfirm()" class="px-4 py-2 border rounded">Batal</button>
            <button id="confirmOk" class="px-4 py-2 rounded text-white">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}

let pendingAction=null;
function confirmAction(msg,level,cb){
    document.getElementById('confirmMessage').innerText=msg;
    document.getElementById('confirmModal').classList.remove('hidden');

    const box=document.getElementById('confirmBox');
    const btn=document.getElementById('confirmOk');

    box.className="bg-white w-[420px] rounded-xl shadow-xl p-6 border-t-8";
    if(level==='danger'){box.classList.add('border-red-600');btn.className="px-4 py-2 bg-red-600 text-white rounded";}
    else if(level==='warning'){box.classList.add('border-yellow-500');btn.className="px-4 py-2 bg-yellow-500 text-white rounded";}
    else{box.classList.add('border-blue-600');btn.className="px-4 py-2 bg-blue-600 text-white rounded";}

    pendingAction=cb;
}
document.getElementById('confirmOk').onclick=function(){
    document.getElementById('confirmModal').classList.add('hidden');
    if(pendingAction) pendingAction();
};
function closeConfirm(){
    document.getElementById('confirmModal').classList.add('hidden');
}
</script>
@stack('scripts')
</body>
</html>
