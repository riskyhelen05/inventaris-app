<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        Activity Log
    </x-slot>

    <div class="space-y-6">

{{-- FILTER --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">

    <form method="GET">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            {{-- LEFT: INPUT --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 flex-1">

                {{-- Search --}}
                <div class="md:col-span-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Pencarian
                    </label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari riwayat aktivitas..."
                        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                </div>

                {{-- Action --}}
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Action
                    </label>
                    <select
                        name="action"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                        <option value="">Semua</option>
                        <option value="borrow" {{ request('action')=='borrow'?'selected':'' }}>Borrow</option>
                        <option value="approve" {{ request('action')=='approve'?'selected':'' }}>Approve</option>
                        <option value="reject" {{ request('action')=='reject'?'selected':'' }}>Reject</option>
                        <option value="return" {{ request('action')=='return'?'selected':'' }}>Return</option>
                        <option value="create_product" {{ request('action')=='create_product'?'selected':'' }}>Create Product</option>
                    </select>
                </div>

                {{-- User --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        User
                    </label>
                    <select
                        name="user"
                        class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                        <option value="">Semua</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ request('user')==$user->id?'selected':'' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-transparent mb-1">
                        Action
                    </label>

                    <div class="flex gap-2 h-10">

                        <button
                            type="submit"
                            class="flex-1 h-full rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                            Cari
                        </button>

                        {{-- FIX: pakai URL current biar ga error route --}}
                        <a href="{{ route('activity.index') }}"
                           class="flex-1 h-full rounded-lg bg-gray-100 border border-gray-300 text-gray-700 text-sm font-medium flex items-center justify-center hover:bg-gray-200 transition">
                            Reset
                        </a>

                    </div>
                </div>

            </div>

            {{-- RIGHT (kosong / future feature) --}}
            <div class="hidden md:block">
                <div class="h-10"></div>
            </div>

        </div>

    </form>

</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-3 border-b">
        <div>
            <h3 class="text-base font-semibold text-slate-800">
                Riwayat Aktivitas
            </h3>
            <p class="text-xs text-slate-500">
                Total {{ $logs->total() }} aktivitas
            </p>
        </div>
    </div>

    @php
function diff($old, $new) {
    $changes = [];

    foreach ($old as $key => $value) {
        if (isset($new[$key]) && $new[$key] != $value) {
            $changes[$key] = [
                'old' => $value,
                'new' => $new[$key]
            ];
        }
    }

    return $changes;
}
@endphp

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            {{-- Head --}}
            <thead class="bg-slate-50">
                <tr class="text-[11px] uppercase tracking-wider text-slate-500">
                    <th class="px-4 py-2 text-left">No</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Action</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Time</th>
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="divide-y divide-slate-100">

                @forelse($logs as $index => $log)
                    <tr class="hover:bg-slate-50 transition align-top">

                        {{-- No --}}
                        <td class="px-4 py-2 text-slate-600">
                            {{ $logs->firstItem() + $index }}
                        </td>

                        {{-- User --}}
                        <td class="px-4 py-2 font-medium text-slate-800">
                            {{ $log->user->name ?? '-' }}
                        </td>

                        {{-- Action --}}
                        <td class="px-4 py-2">
                            @switch($log->action)

                                @case('borrow')
                                    <span class="px-2 py-0.5 text-xs rounded-md bg-blue-100 text-blue-700">Borrow</span>
                                @break

                                @case('approve')
                                    <span class="px-2 py-0.5 text-xs rounded-md bg-green-100 text-green-700">Approve</span>
                                @break

                                @case('reject')
                                    <span class="px-2 py-0.5 text-xs rounded-md bg-red-100 text-red-700">Reject</span>
                                @break

                                @case('return')
                                    <span class="px-2 py-0.5 text-xs rounded-md bg-yellow-100 text-yellow-700">Return</span>
                                @break

                                @default
                                    <span class="px-2 py-0.5 text-xs rounded-md bg-slate-100 text-slate-700">
                                        {{ $log->action_label }}
                                    </span>

                            @endswitch
                        </td>

                        {{-- Description + Audit Trail --}}
                        <td class="px-4 py-2 text-slate-600 max-w-xs">

                            {{-- Description --}}
                            <div class="truncate">
                                {{ $log->description }}
                            </div>

                            {{-- AUDIT TRAIL --}}
                            @if($log->old_data && $log->new_data)
    <details class="mt-1 text-xs">
        <summary class="cursor-pointer text-blue-600 hover:underline">
            Lihat Perubahan
        </summary>

        @php
            $old = collect($log->old_data)
                    ->except(['created_at','updated_at'])
                    ->toArray();

            $new = collect($log->new_data)
                    ->except(['created_at','updated_at'])
                    ->toArray();

            $changes = diff($old, $new);
        @endphp

        <div class="mt-2 bg-slate-50 border rounded p-2">

            @if(count($changes))
                <ul class="space-y-1">
                    @foreach($changes as $field => $change)
                        <li class="text-xs">
                            <strong>{{ $field }}</strong>:
                            <span class="text-red-500">
                                {{ $change['old'] }}
                            </span>
                            →
                            <span class="text-green-600">
                                {{ $change['new'] }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <span class="italic text-slate-400">
                    Tidak ada perubahan
                </span>
            @endif

        </div>
    </details>
@endif

                        </td>

                        {{-- Time --}}
                        <td class="px-4 py-2 text-xs text-slate-500 whitespace-nowrap">
                            {{ $log->created_at->diffForHumans() }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center">
                            <div class="flex flex-col items-center">

                                <x-heroicon-o-clock class="w-10 h-10 text-slate-300 mb-2" />

                                <h3 class="text-sm font-semibold text-slate-700">
                                    Belum ada aktivitas
                                </h3>

                                <p class="text-xs text-slate-500 mt-1">
                                    Semua aktivitas akan muncul di sini
                                </p>

                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

</div>

            {{-- Pagination --}}
            @if($logs->hasPages())
                <div class="px-6 py-4 border-t bg-slate-50">
                    {{ $logs->withQueryString()->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>