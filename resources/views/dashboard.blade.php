<x-app-layout>

<!-- ================= HERO ================= -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-red-600 via-red-500 to-red-400 px-6 py-5 shadow-xl">

    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-white/10"></div>

    <div class="relative z-10 flex items-center gap-4">

        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center">
            <x-heroicon-o-home-modern class="w-7 h-7 text-white"/>
        </div>

        <div>
            <p class="text-red-100 text-sm">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>

            <h1 class="text-2xl font-bold text-white">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>

            <p class="text-red-100 text-sm mt-1">
                Kelola aset dengan <span class="font-semibold text-white">AssetTrack</span>
            </p>
        </div>

    </div>
</div>

<div class="mt-6 bg-white rounded-xl border shadow-sm p-5">

{{-- ================= DASHBOARD SUMMARY ================= --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-1">

@php
$cards = [

    // ===== BARANG =====
    ['title'=>'Total Barang','value'=>$totalBarang,'icon'=>'cube','color'=>'bg-red-100 text-red-600'],
    ['title'=>'Stok Habis','value'=>$stokHabis,'icon'=>'exclamation','color'=>'bg-orange-100 text-orange-600'],
    ['title'=>'Kategori','value'=>$totalKategori,'icon'=>'tag','color'=>'bg-blue-100 text-blue-600'],

    ['title'=>'Barang Dipinjam','value'=>$barangDipinjam,'icon'=>'arrow-up','color'=>'bg-purple-100 text-purple-600'],
    ['title'=>'Barang Tersedia','value'=>$barangTersedia,'icon'=>'archive','color'=>'bg-green-100 text-green-700'],

    // ===== PEMINJAMAN =====
    ['title'=>'Total Peminjaman','value'=>$totalBorrowing,'icon'=>'clipboard','color'=>'bg-red-100 text-red-600'],
    ['title'=>'Pending','value'=>$totalPending,'icon'=>'clock','color'=>'bg-yellow-100 text-yellow-600'],
    ['title'=>'Approved','value'=>$totalApproved,'icon'=>'check','color'=>'bg-blue-100 text-blue-600'],
    ['title'=>'Returned','value'=>$totalReturned,'icon'=>'arrow','color'=>'bg-green-100 text-green-600'],
    ['title'=>'Rejected','value'=>$totalRejected,'icon'=>'x','color'=>'bg-red-100 text-red-500'],

];
@endphp

@foreach($cards as $card)
<div class="bg-white rounded-lg border hover:shadow-sm transition px-3 py-2 flex items-center gap-3">

    {{-- ICON --}}
    <div class="w-8 h-8 rounded-md {{ $card['color'] }} flex items-center justify-center shrink-0">
        @switch($card['icon'])
            @case('cube') <x-heroicon-o-cube class="w-4 h-4"/> @break
            @case('exclamation') <x-heroicon-o-exclamation-triangle class="w-4 h-4"/> @break
            @case('tag') <x-heroicon-o-tag class="w-4 h-4"/> @break
            @case('clipboard') <x-heroicon-o-clipboard-document-list class="w-4 h-4"/> @break
            @case('clock') <x-heroicon-o-clock class="w-4 h-4"/> @break
            @case('check') <x-heroicon-o-check class="w-4 h-4"/> @break
            @case('arrow') <x-heroicon-o-arrow-uturn-left class="w-4 h-4"/> @break
            @case('x') <x-heroicon-o-x-circle class="w-4 h-4"/> @break
            @case('arrow-up') <x-heroicon-o-arrow-up-tray class="w-4 h-4"/> @break
            @case('archive') <x-heroicon-o-archive-box class="w-4 h-4"/> @break
        @endswitch
    </div>

    {{-- TEXT --}}
    <div class="leading-tight">
        <p class="text-[11px] text-gray-500">{{ $card['title'] }}</p>
        <p class="text-sm font-semibold text-slate-800">{{ $card['value'] }}</p>
    </div>

</div>
@endforeach

</div>

</div>

<!-- ================= CHART ================= -->
<div class="mt-6 bg-white rounded-xl border shadow-sm p-5">

    <h3 class="text-sm font-semibold text-slate-800 mb-3">
        Grafik Peminjaman
    </h3>

    <canvas id="lineChart" class="h-64"></canvas>

</div>

<div class="mt-6 bg-white rounded-xl border shadow-sm p-5">

<div class="bg-white rounded-xl border shadow-sm p-5">

    <h3 class="text-sm font-semibold text-slate-800 mb-3">
        Top Barang Dipinjam
    </h3>

    <canvas id="barChart" class="h-52"></canvas>

</div>

</div>

<!-- ================= BOTTOM ================= -->
<div class="mt-6 grid md:grid-cols-2 gap-6">

    <!-- LOW STOCK -->
<div class="bg-white rounded-xl border shadow-sm p-5">

    <h3 class="text-sm font-semibold text-slate-800 mb-4">
        Stok Menipis
    </h3>

    @if($lowStocks->count())

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-xs text-gray-500 border-b">
                        <th class="py-2">Nama Barang</th>
                        <th class="py-2 text-right">Stok</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($lowStocks->take(5) as $item)
                        <tr class="hover:bg-red-50 transition">

                            <td class="py-3 text-slate-700">
                                {{ $item->name }}
                            </td>

                            <td class="py-3 text-right">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">
                                    {{ $item->stock }}
                                </span>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    @else

        <!-- EMPTY STATE -->
        <div class="flex flex-col items-center justify-center text-center py-10 text-gray-400">

            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 mb-3">
                <x-heroicon-o-check-circle class="w-6 h-6 text-green-500"/>
            </div>

            <p class="text-sm font-medium text-gray-500">
                Stok Aman
            </p>

            <p class="text-xs text-gray-400 mt-1">
                Tidak ada barang dengan stok rendah
            </p>

        </div>

    @endif

</div>

<div class="bg-white rounded-xl border shadow-sm p-5">
    <h3 class="text-sm font-semibold text-slate-800 mb-4">
        Recent Activity
    </h3>

    <div class="space-y-4">
        @foreach ($recentActivities as $item)
            <div class="flex items-start justify-between">

                <!-- LEFT -->
                <div class="flex items-start gap-3">

                    <!-- ICON -->
                    <div class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100">
                        <x-heroicon-o-user class="w-5 h-5 text-slate-500"/>
                    </div>

                    <!-- TEXT -->
                    <div class="text-sm leading-tight">

                        <p class="text-slate-800">
                            <span class="font-semibold">{{ $item->user }}</span>
                            <span class="text-slate-500">
                                meminjam {{ $item->product }}
                            </span>
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Qty: {{ $item->quantity }} • 
                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </p>

                    </div>
                </div>

                <!-- STATUS -->
                <span class="
                    px-2 py-1 text-xs rounded-full whitespace-nowrap
                    {{ $item->status == 'approved' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                    {{ $item->status == 'returned' ? 'bg-blue-100 text-blue-600' : '' }}
                ">
                    {{ ucfirst($item->status) }}
                </span>

            </div>
        @endforeach
    </div>
</div>

</div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const chartData = @json($chartData ?? []);
const stockData = @json($stockData ?? []);

// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: chartData.map(i => i.date),
        datasets: [{
            data: chartData.map(i => i.total),
            borderColor: '#dc2626',
            backgroundColor: 'rgba(220,38,38,0.15)',
            fill: true,
            tension: 0.4,

            // penting ini
            borderWidth: 3,
            pointRadius: 5,
            pointBackgroundColor: '#dc2626'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// BAR CHART
const colors = [
    '#dc2626', // merah
    '#f97316', // orange
    '#eab308', // kuning
    '#22c55e', // hijau
    '#3b82f6'  // biru
];

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: stockData.map(i => `${i.rank}. ${i.product}`),
        datasets: [{
            data: stockData.map(i => i.total),
            backgroundColor: colors,
            borderRadius: 8,
            barThickness: 30
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total dipinjam: ' + context.raw;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});
</script>

<script>
setInterval(() => {
    location.reload();
}, 10000); // 10 detik
</script>