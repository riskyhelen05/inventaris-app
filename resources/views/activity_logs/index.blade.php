<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-700">
            Activity Logs
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                {{-- TITLE --}}
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-gray-700">
                        Riwayat Aktivitas
                    </h3>
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3">Action</th>
                                <th class="px-6 py-3">Deskripsi</th>
                                <th class="px-6 py-3">Waktu</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($logs as $index => $log)
                                <tr class="border-b hover:bg-gray-50 transition">

                                    <td class="px-6 py-3">
                                        {{ $logs->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-3 font-medium text-gray-800">
                                        {{ $log->user->name ?? '-' }}
                                    </td>

                                    {{-- BADGE --}}
                                    <td class="px-6 py-3">
                                        @if($log->action == 'borrow')
                                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-600">
                                                Borrow
                                            </span>
                                        @elseif($log->action == 'approve')
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">
                                                Approve
                                            </span>
                                        @elseif($log->action == 'return')
                                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-600">
                                                Return
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                                                {{ $log->action }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-3">
                                        {{ $log->description }}
                                    </td>

                                    <td class="px-6 py-3 text-gray-500">
                                        {{ $log->created_at->diffForHumans() }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-400">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4">
                    {{ $logs->links() }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>