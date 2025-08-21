@extends('layouts.main')
@section('content')
<div class="p-4 sm:p-6">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Data Pimpinan</h5>
            <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                + Tambah Pengguna
            </button>
        </div>
        <div class="p-5">
            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <!-- Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Kontak</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pimpinans as $index => $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ $pimpinans->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->kontak }}</td>
                            <td class="px-6 py-4">{{ $item->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data pimpinan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pimpinans->hasPages())
            <div class="mt-4">
                {{ $pimpinans->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Include Add Modal -->
@include('admin.pengguna.add-modal')
@endsection