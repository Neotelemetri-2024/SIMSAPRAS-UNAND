@extends('layouts.user')

@section('content')
<section class="bg-white pt-24">
    <div class="max-w-screen-xl px-4 mx-auto lg:px-6">
        <div class="text-center mb-12">
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900">
                Daftar Gedung & Sarana
            </h2>
            <p class="text-gray-500 lg:mx-auto text-lg">
                Temukan dan pinjam berbagai fasilitas dan ruangan yang tersedia di Universitas Andalas
            </p>
        </div>

        <div class="mb-8">
            <form action="{{ route('user.sarana') }}" method="GET" class="flex items-center justify-center gap-2">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari gedung atau sarana..."
                    class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-300 focus:outline-none" />
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                    Cari
                </button>
            </form>
        </div>

        <!-- Main Content Grid -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Side - Building List -->
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($sarana as $item)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $item->nama }}</h5>
                            <p class="mb-3 text-gray-600">{{ $item->deskripsi }}</p>
                        <a href="{{ route('user.sarana.show', $item) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
    Lihat Detail
    <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
    </svg>
</a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-8">
                        <p class="text-gray-500">Tidak ada sarana yang ditemukan.</p>
                    </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="col-span-2 mt-6">
                        {{ $sarana->links() }}
                    </div>
                </div>
            </div>

            <!-- Right Side - Sticky Information Bar -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4">Informasi Peminjaman</h3>

                        <!-- Quick Stats -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3 pb-3 border-b">
                                <span class="text-gray-600">Total Gedung</span>
                                <span class="font-semibold">{{ $sarana->total() }} Gedung</span>
                            </div>
                            <div class="flex items-center justify-between mb-3 pb-3 border-b">
                                <span class="text-gray-600">Ruangan Tersedia</span>
                                <span class="font-semibold">24 Ruangan</span>
                            </div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-gray-600">Jam Operasional</span>
                                <span class="font-semibold">08:00 - 16:00</span>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3">Kontak Pengelola</h4>
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                <span class="text-gray-600">(0751) 123456</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                <span class="text-gray-600">peminjaman@unand.ac.id</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="space-y-3">
                            <button class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                                Panduan Peminjaman
                            </button>
                            <button class="w-full px-4 py-2 text-sm font-medium text-green-600 bg-white border border-green-600 rounded-lg hover:bg-green-50 focus:ring-4 focus:ring-green-300">
                                FAQ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection