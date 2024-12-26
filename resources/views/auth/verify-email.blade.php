<x-guest-layout>
    <!-- Main Content -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 pt-36">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Side - Verification Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Email</h1>
                    <p class="text-gray-600">Mohon verifikasi alamat email Anda</p>
                </div>

                <div class="mb-6 text-gray-600">
                    Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan email yang baru.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 text-sm font-medium text-green-600">
                        Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                    </div>
                @endif

                <div class="flex flex-col space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" 
                            class="w-full bg-green-600 text-white rounded-lg py-3 px-4 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300 font-semibold">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                            class="w-full bg-white text-gray-600 border-2 border-gray-200 rounded-lg py-3 px-4 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition duration-300 font-semibold">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side - Info -->
            <div class="hidden lg:block">
                <div class="space-y-8">
                    <h2 class="text-4xl font-extrabold text-gray-900">
                        Sistem Informasi Peminjaman
                        <span class="text-green-600 block">Sarana & Prasarana</span>
                    </h2>

                    <p class="text-lg text-gray-600">
                        Kelola dan ajukan peminjaman fasilitas kampus dengan mudah dan efisien melalui SIMSAPRAS Universitas Andalas.
                    </p>

                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
                            <p class="text-gray-600">Peminjaman ruangan dapat diproses dalam waktu 1x24 jam kerja</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-md hover:bg-green-100">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Aman & Terpercaya</h3>
                            <p class="text-gray-600">Sistem terintegrasi dengan SSO Universitas Andalas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>