<x-app-layout>

<!-- TITLE -->
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-700">Dashboard</h1>
    <p class="text-gray-400 text-sm">Control panel</p>
</div>

<!-- CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @php
    $cards = [
        ['title'=>'Total Barang','value'=>$totalBarang,'icon'=>'📦'],
        ['title'=>'Barang Dipinjam','value'=>$barangDipinjam,'icon'=>'📋'],
        ['title'=>'Barang Tersedia','value'=>$barangTersedia,'icon'=>'✅'],
    ];
    @endphp

    @foreach($cards as $c)
    <div class="bg-white rounded-xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group">

    <div class="p-5 flex items-center gap-4">

        <div class="w-14 h-14 flex items-center justify-center 
            bg-gradient-to-br from-red-500 to-red-700 
            text-white rounded-full text-xl shadow-md
            group-hover:scale-110 transition">
            {{ $c['icon'] }}
        </div>

        <div>
            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-red-600 transition">
                {{ $c['value'] }}
            </h2>
            <p class="text-gray-500 text-sm">{{ $c['title'] }}</p>
        </div>

    </div>

    <div class="border-t px-5 py-2 text-red-500 text-sm flex justify-between items-center 
        hover:bg-red-50 cursor-pointer transition">
        <span>More info</span>
        <span class="group-hover:translate-x-1 transition">➜</span>
    </div>

</div>
    @endforeach

</div>

<!-- CHART -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm font-semibold tracking-wide">
            Grafik Peminjaman
        </div>
        <div class="p-4">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm font-semibold tracking-wide">
            Peminjaman per Barang
        </div>
        <div class="p-4">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 text-sm font-semibold tracking-wide">
            Stok Barang
        </div>
        <div class="p-4">
            <canvas id="barChart"></canvas>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">

    {{-- LOW STOCK --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 font-semibold">
            ⚠️ Low Stock
        </div>

        <table class="w-full">

            <thead>

                <tr class="bg-gray-100">

                    <th class="p-3 text-left">Barang</th>
                    <th class="p-3 text-center">Stok</th>

                </tr>

            </thead>

            <tbody>

            @forelse($lowStocks as $item)

                <tr class="border-b">

                    <td class="p-3">

                        {{ $item->name }}

                    </td>

                    <td class="p-3 text-center">

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                            {{ $item->stock }}

                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="2"
                        class="text-center py-5 text-gray-500">

                        Tidak ada stok menipis.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 font-semibold">
            🕒 Recent Activity
        </div>

        <table class="w-full">

            <thead>

                <tr class="bg-gray-100">

                    <th class="p-3">User</th>
                    <th class="p-3">Activity</th>

                </tr>

            </thead>

            <tbody>

            @forelse($recentActivities as $log)

                <tr class="border-b">

                    <td class="p-3">

                        {{ $log->user->name ?? '-' }}

                    </td>

                    <td class="p-3">

                        <td class="p-3 text-sm">
                            {{ $log->description }}
                        </td>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="2"
                        class="text-center py-5 text-gray-500">

                        Belum ada aktivitas.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden mt-10">

    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 font-semibold">
        🔥 Top Borrowed
    </div>

    <table class="w-full">

        <thead>

            <tr class="bg-gray-100">

                <th class="p-3 text-left">

                    Barang

                </th>

                <th class="p-3 text-center">

                    Total Dipinjam

                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($topBorrowed as $item)

            <tr class="border-b">

                <td class="p-3">

                    {{ $item->product->name ?? '-' }}

                </td>

                <td class="p-3 text-center">

                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">

                        {{ $item->total }}

                    </span>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="2"
                    class="text-center py-5 text-gray-500">

                    Belum ada data.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const chartData = @json($chartData ?? []);
const pieData = @json($pieData ?? []);
const stockData = @json($stockData ?? []);

// LINE
const ctx = document.getElementById('lineChart').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, "rgba(220,38,38,0.4)");
gradient.addColorStop(1, "rgba(220,38,38,0)");

new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.map(i => i.date),
        datasets: [{
            label: 'Peminjaman',
            data: chartData.map(i => i.total),
            borderColor: '#dc2626',
            backgroundColor: gradient,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#dc2626'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#111',
                titleColor: '#fff',
                bodyColor: '#fff'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                min: 0,
                ticks: {
                    stepSize: 1,
                    callback: val => val
                }
            }
        }
    }
});

// PIE
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: pieData.map(i => i.product),
        datasets: [{
            data: pieData.map(i => i.total),
            backgroundColor: [
                '#dc2626',
                '#fb7185',
                '#f97316',
                '#facc15',
                '#4ade80',
                '#60a5fa'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// BAR
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: stockData.map(i => i.product),
        datasets: [{
            data: stockData.map(i => i.stock),
            backgroundColor: 'rgba(220,38,38,0.8)',
            borderRadius: 6
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                min: 0,
                ticks: {
                    stepSize: 1,
                    callback: val => val
                }
            }
        }
    }
});
</script>