<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssetTrack</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-700">

<!-- HERO -->
<section class="pt-12 pb-24">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- TEXT -->
            <div>

                <span class="inline-block px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold">
                    Inventory Management System
                </span>

                <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight text-slate-900">
                    Kelola Aset Perusahaan
                    <span class="text-red-600">Lebih Mudah</span>
                    dengan AssetTrack
                </h1>

                <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-xl">
                    Sistem manajemen aset berbasis web untuk membantu perusahaan mengelola
                    inventaris, peminjaman, pengembalian, dan laporan secara efektif dan efisien.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('login') }}"
                       class="px-8 py-3 rounded-xl bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-8 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-white transition">
                        Register
                    </a>
                </div>

            </div>

            <!-- IMAGE / CARD -->
            <div class="flex justify-center">
                <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-10 text-center">

                    <img src="{{ asset('images/logo_full.png') }}"
                         class="w-72 mx-auto"
                         alt="AssetTrack">

                    <div class="mt-8 grid grid-cols-3 gap-6">

                        <div>
                            <h3 class="text-xl font-bold text-red-600">CRUD</h3>
                            <p class="text-xs text-slate-500">Management</p>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-red-600">IoT</h3>
                            <p class="text-xs text-slate-500">Monitoring</p>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-red-600">Analytics</h3>
                            <p class="text-xs text-slate-500">Report</p>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

<!-- FEATURES -->
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-center text-3xl font-bold text-slate-900">
            Fitur AssetTrack
        </h2>

        <p class="text-center text-slate-500 mt-2">
            Semua yang kamu butuhkan untuk mengelola aset perusahaan
        </p>

        <div class="mt-12 grid md:grid-cols-3 gap-6">

            <!-- CARD 1 -->
            <div class="p-6 rounded-2xl border border-slate-200 hover:shadow-md transition bg-slate-50">

                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <x-heroicon-o-cube class="w-6 h-6 text-red-600"/>
                </div>

                <h3 class="mt-4 font-semibold text-slate-800">
                    Manajemen Barang
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola seluruh data aset dan stok perusahaan dengan mudah.
                </p>

            </div>

            <!-- CARD 2 -->
            <div class="p-6 rounded-2xl border border-slate-200 hover:shadow-md transition bg-slate-50">

                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <x-heroicon-o-arrow-path class="w-6 h-6 text-red-600"/>
                </div>

                <h3 class="mt-4 font-semibold text-slate-800">
                    Peminjaman Aset
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Pantau proses peminjaman dan pengembalian secara real-time.
                </p>

            </div>

            <!-- CARD 3 -->
            <div class="p-6 rounded-2xl border border-slate-200 hover:shadow-md transition bg-slate-50">

                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <x-heroicon-o-chart-bar class="w-6 h-6 text-red-600"/>
                </div>

                <h3 class="mt-4 font-semibold text-slate-800">
                    Laporan & Analitik
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Dapatkan insight dari data aset dengan laporan yang jelas.
                </p>

            </div>

        </div>

    </div>
</section>

<!-- FOOTER -->
<footer class="bg-slate-900 py-6 mt-10">
    <p class="text-center text-sm text-slate-400">
        © {{ date('Y') }} AssetTrack. All rights reserved.
    </p>
</footer>

</body>
</html>