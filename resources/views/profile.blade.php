@extends('layouts.user')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="relative bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
        <!-- Header Section with Avatar -->
        <div class="relative bg-gradient-to-r from-green-600 to-green-400 p-8">
            <!-- Edit Button -->
            <button
                class="absolute top-4 right-4 bg-white/30 hover:bg-white/50 rounded-full p-2 transition-all flex items-center justify-center"
                onclick="toggleEditForm()"
            >
                <i class="fas fa-pen text-white text-xl"></i>
            </button>
            <!-- Profile Info -->
            <div class="flex flex-col items-center">
                <div
                    class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg mb-4"
                >
                    <i class="fas fa-user text-4xl text-gray-400"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2 text-center" id="name">
                    {{ $pengguna->name ?? 'Tidak diketahui' }}
                </h2>
                <p class="text-green-100 text-center" id="kontak">
                    {{ $pengguna->kontak ?? 'Tidak diketahui' }}
                </p>
                <p class="text-green-100 text-center" id="email">
                    {{ $pengguna->email ?? 'Tidak diketahui' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
