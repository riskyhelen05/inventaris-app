<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>InventarisApp</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Segoe UI', sans-serif; }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-lg min-h-screen">

        <!-- LOGO -->
        <div class="p-5 border-b">
            <h1 class="text-xl font-bold text-red-600">📦 InventarisApp</h1>
        </div>

        <!-- PROFILE -->
        <div class="p-5 border-b flex items-center gap-3">
            <img src="https://i.pravatar.cc/40" class="rounded-full">
            <div>
                <p class="font-semibold text-sm">{{ auth()->user()->name ?? 'User' }}</p>
                <span class="text-green-500 text-xs">● Online</span>
            </div>
        </div>

<!-- MENU -->
<nav class="p-4 space-y-2 text-sm">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        🏠 Dashboard
    </a>

    <!-- Data Barang -->
    <a href="{{ route('products.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('products.*') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        📦 Data Barang
    </a>

    <!-- Kategori -->
    <a href="{{ route('categories.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('categories.*') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        🗂️ Kategori
    </a>

    <!-- Supplier -->
    <a href="{{ route('suppliers.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('suppliers.*') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        🚚 Supplier
    </a>

    <!-- Peminjaman -->
    <a href="{{ route('borrowings.index') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('borrowings.*') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        📋 Peminjaman
    </a>

    <!-- Activity Log -->
    <a href="{{ route('activity.logs') }}"
        class="flex items-center gap-2 px-4 py-2 rounded transition
        {{ request()->routeIs('activity.logs') ? 'bg-red-600 text-white shadow' : 'hover:bg-red-50 hover:text-red-600' }}">
        📊 Activity Logs
    </a>

</nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1">

        <!-- TOPBAR -->
        <header class="bg-gradient-to-r from-red-600 to-red-500 text-white p-4 flex justify-between items-center shadow">

            <div class="flex items-center gap-3">
                <span class="text-2xl">☰</span>
                <h1 class="font-semibold text-lg"> {{ $header ?? 'Dashboard' }} </h1>
            </div>

            <div class="flex items-center gap-3">
                <img src="https://i.pravatar.cc/35" class="rounded-full">
                <span>{{ auth()->user()->name ?? 'User' }}</span>
                <button class="bg-white text-red-600 px-3 py-1 rounded text-sm">Logout</button>
            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-6">
            {{ $slot }}
        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:"{{ session('success') }}",
    confirmButtonColor:'#dc2626'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'Gagal',
    text:"{{ session('error') }}",
    confirmButtonColor:'#dc2626'
});
</script>
@endif

<script>
document.querySelectorAll('.delete-btn').forEach(button => {

    button.addEventListener('click', function(){

        const form = this.closest('form');

        Swal.fire({
            title:'Hapus Data?',
            text:'Data tidak dapat dikembalikan.',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#dc2626',
            cancelButtonColor:'#6b7280',
            confirmButtonText:'Ya',
            cancelButtonText:'Batal'
        }).then((result)=>{

            if(result.isConfirmed){
                form.submit();
            }

        });

    });

});
</script>
</body>
</html>