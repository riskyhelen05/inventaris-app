<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AssetTrack</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-700 antialiased">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col min-h-screen">

        <!-- LOGO -->
        <div class="px-6 py-5 border-b border-slate-200">

            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('images/logo_icon.png') }}"
                    alt="AssetTrack"
                    class="h-10 w-auto">

                <div>

                    <h1 class="text-lg font-bold text-slate-900">
                        AssetTrack
                    </h1>

                    <p class="text-xs text-slate-500">
                        Inventory Management
                    </p>

                </div>

            </div>

        </div>


        <!-- PROFILE -->
        <div class="px-4 py-5">

            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-xl bg-red-100 flex items-center justify-center">

                        <span class="font-bold text-red-600 text-lg">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </span>

                    </div>

                    <div>

                        <h3 class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </h3>

                        <p class="text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>

                        <span class="inline-flex mt-1 px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[11px] font-semibold capitalize">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- MENU -->
        <div class="flex-1 px-4 overflow-y-auto">

            <nav class="space-y-2">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                   {{ request()->routeIs('dashboard')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-home class="w-5 h-5"/>

                    <span>Dashboard</span>

                </a>


                {{-- Admin + Staff + User --}}
                @hasanyrole('admin|staff|user')

                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                    {{ request()->routeIs('products.*')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-cube class="w-5 h-5"/>

                    <span>
                        {{ auth()->user()->hasRole('user') ? 'Produk' : 'Data Barang' }}
                    </span>

                </a>

                @endhasanyrole

                {{-- Admin + Staff --}}
                @hasanyrole('admin|staff')
                <a href="{{ route('categories.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                   {{ request()->routeIs('categories.*')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-tag class="w-5 h-5"/>

                    <span>Kategori</span>

                </a>

                @endhasanyrole


                {{-- Semua Role --}}
                @hasanyrole('admin|staff|manager|user')

<a href="{{ route('borrowings.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
   {{ request()->routeIs('borrowings.*')
        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

    <x-heroicon-o-clipboard-document-list class="w-5 h-5"/>

    <span>
        {{ auth()->user()->hasRole('user') ? 'Peminjaman Saya' : 'Peminjaman' }}
    </span>

</a>

@endhasanyrole


                {{-- Admin + Manager --}}
                @hasanyrole('admin|manager')

                <a href="{{ route('reports.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                   {{ request()->routeIs('reports.*')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-chart-bar-square class="w-5 h-5"/>

                    <span>Laporan</span>

                </a>

                @endhasanyrole


                {{-- Admin --}}
                @role('admin')

                <a href="{{ route('activity.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                   {{ request()->routeIs('activity.index')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-document-text class="w-5 h-5"/>

                    <span>Activity Log</span>

                </a>

                @endrole

            </nav>


            <!-- ACCOUNT -->
            <div class="mt-8 pt-6 border-t border-slate-200 space-y-2">

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 font-medium
                   {{ request()->routeIs('profile.*')
                        ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg'
                        : 'text-slate-600 hover:bg-slate-100 hover:text-red-600' }}">

                    <x-heroicon-o-user-circle class="w-5 h-5"/>

                    <span>My Profile</span>

                </a>


                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-red-50 hover:text-red-600 transition">

                        <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5"/>

                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </div>

    </aside>

<!-- MAIN -->
<div class="flex-1 min-h-screen bg-slate-100">

<!-- TOPBAR -->
<header class="h-20 bg-white border-b border-slate-200 px-8 flex items-center justify-between">

    <!-- Left -->
    <div>

        <p class="text-sm text-slate-400">
            AssetTrack /
                <span class="text-red-600 font-semibold">
                    {{ $header ?? 'Dashboard' }}
                </span>
        </p>

        <h1 class="mt-1 text-2xl font-bold text-slate-900">
            {{ $header ?? 'Dashboard' }}
        </h1>

    </div>

<!-- Right -->
<div class="flex items-center gap-4">

 @hasanyrole('admin|staff')   
<!-- NOTIFICATION -->
    <div class="relative">

        <button
            id="notificationBtn"
            class="relative w-11 h-11 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 transition-all duration-200 flex items-center justify-center">

            <x-heroicon-o-bell class="w-6 h-6 text-slate-600" />

            <span
                id="notificationCount"
                class="hidden absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-red-600 text-white text-[10px] flex items-center justify-center">
            </span>

        </button>


        <!-- DROPDOWN -->
        <div
            id="notificationBox"
            class="hidden absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-50 transition-all duration-200">

            <div class="px-5 py-3 border-b font-semibold">
                Notifications
            </div>

            <div
                id="notificationList"
                class="max-h-96 overflow-y-auto">
            </div>

        </div>

    </div>
@endhasanyrole

</div>

</header>

<main class="p-8">
    {{ $slot }}
</main>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    confirmButtonText: 'OK',
    confirmButtonColor: '#DC2626',
    background: '#FFFFFF',
    color: '#0F172A',
    customClass: {
        popup: 'rounded-2xl shadow-2xl',
        confirmButton: 'rounded-xl px-6'
    }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: "{{ session('error') }}",
    confirmButtonText: 'Close',
    confirmButtonColor: '#DC2626',
    background: '#FFFFFF',
    color: '#0F172A',
    customClass: {
        popup: 'rounded-2xl shadow-2xl',
        confirmButton: 'rounded-xl px-6'
    }
});
</script>
@endif

<script>
document.querySelectorAll('.delete-btn').forEach(button => {

    button.addEventListener('click', function (e) {

        e.preventDefault();

        const form = this.closest('form');

        Swal.fire({
            title: 'Delete Item?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            background: '#FFFFFF',
            color: '#0F172A',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#CBD5E1',
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                confirmButton: 'rounded-xl px-5',
                cancelButton: 'rounded-xl px-5'
            }
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
</script>

<script>
const btnNotif = document.getElementById('notificationBtn');
const notifBox = document.getElementById('notificationBox');
const notifList = document.getElementById('notificationList');
const notifCount = document.getElementById('notificationCount');

function loadNotification(){

    fetch("{{ route('notifications') }}")

    .then(res=>res.json())

    .then(data=>{

        notifCount.innerHTML = data.count;

        if (data.count > 0) {
            notifCount.classList.remove('hidden');
        } else {
            notifCount.classList.add('hidden');
        }

        let html='';

        if(data.data.length===0){

            html=`
            <div class="p-5 text-center text-slate-500">
                No notification
            </div>
            `;

        }else{

            data.data.forEach(item=>{

                html+=`
                <a href="${item.url}"
                    class="block px-5 py-4 border-b hover:bg-red-50">

                    <div class="font-semibold text-sm text-red-600">
                        ${item.title}
                    </div>

                    <div class="text-sm text-slate-600">
                        ${item.message}
                    </div>

                </a>
                `;

            });

        }

        notifList.innerHTML=html;

    });

}

loadNotification();

setInterval(loadNotification,30000);

btnNotif.addEventListener('click',function(){

    notifBox.classList.toggle('hidden');

});

document.addEventListener('click',function(e){

    if(!btnNotif.contains(e.target) &&
       !notifBox.contains(e.target)){

        notifBox.classList.add('hidden');

    }

});
</script>

</body>
</html>