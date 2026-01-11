<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Event Organizer – ASSBI Kebumen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

<!-- ===== HEADER ===== -->
<div class="bg-gradient-to-r from-blue-900 to-blue-800 pt-16 pb-28 shadow">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h1 class="text-2xl md:text-3xl font-bold text-white">
            ASSBI Kabupaten Kebumen
        </h1>
        <p class="text-blue-100 mt-1 text-sm">
            Registrasi Event Organizer
        </p>
    </div>
</div>

<!-- ===== CARD ===== -->
<div class="flex-1 flex items-start justify-center px-4 -mt-20 md:-mt-28">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl p-6 md:p-10">

        {{-- Error --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6 text-sm">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.club.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- ===== DATA EO ===== -->
            <div class="bg-gray-50 p-6 rounded-xl border">
                <h3 class="text-blue-900 font-semibold mb-4 flex items-center gap-2">
                    🏢 Data Event Organizer
                </h3>

                <div class="space-y-4">
                    <input name="eo_name" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nama Event Organizer">

                    <input name="contact_person"
                        required
                        placeholder="Nama Penanggung Jawab"
                        class="w-full rounded-lg border px-4 py-3 text-sm">

                    <div>

                        <div class="flex mt-1">
                            <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-700 text-sm">
                                +62
                            </span>

                            <input name="phone"
                                type="tel"
                                inputmode="numeric"
                                pattern="[1-9][0-9]{8,12}"
                                maxlength="13"
                                required
                                class="w-full rounded-r-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="81234567890">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            No Hp, Contoh: 81234567xxx
                        </p>
                    </div>



                    <input type="email" name="email_eo"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Email EO (opsional)">

                    <textarea name="address" rows="3" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Alamat EO"></textarea>
                </div>
            </div>

            <!-- ===== AKUN LOGIN ===== -->
            <div class="bg-gray-50 p-6 rounded-xl border">
                <h3 class="text-blue-900 font-semibold mb-4 flex items-center gap-2">
                    👤 Akun Login
                </h3>

                <div class="space-y-4">
                    <input name="name" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nama User">

                    <input type="email" name="email" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Email Login">

                    <div class="relative">
                        <input type="password"
                            id="password"
                            name="password"
                            required
                            class="w-full rounded-lg border px-4 py-3 pr-12 text-sm"
                            placeholder="Password">

                        <button type="button"
                            data-toggle-password="password"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            👁️
                        </button>
                    </div>


                    <div class="relative">
                        <input type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full rounded-lg border px-4 py-3 pr-12 text-sm"
                            placeholder="Konfirmasi Password">

                        <button type="button"
                            data-toggle-password="password_confirmation"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                            👁️
                        </button>
                    </div>

                </div>
            </div>

        </div>

        <!-- ===== SUBMIT ===== -->
        <div class="mt-10 max-w-md mx-auto">
            <button
                class="w-full bg-blue-900 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold text-sm shadow transition">
                Daftar Event Organizer
            </button>

            <p class="text-center text-sm text-gray-500 mt-4">
                Sudah punya akun?
                <a href="/login" class="text-blue-700 font-semibold hover:underline">
                    Login
                </a>
            </p>
        </div>

        </form>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-toggle-password]").forEach(button => {
        button.addEventListener("click", function () {
            const input = document.getElementById(this.dataset.togglePassword);

            if (input.type === "password") {
                input.type = "text";
                this.innerText = "🙈";
            } else {
                input.type = "password";
                this.innerText = "👁️";
            }
        });
    });
});
</script>


</body>
</html>
