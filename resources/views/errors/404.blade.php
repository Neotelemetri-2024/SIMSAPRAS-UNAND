<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | SIMSAPRAS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-cyan-50 to-gray-100 h-screen overflow-hidden">
    <div class="h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full bg-white rounded-2xl shadow-lg p-6">
            <div class="transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('assets/images/404-not.png') }}" 
                     alt="404 Illustration" 
                     class="w-48 md:w-56 mx-auto">
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-cyan-400 to-pink-500 text-transparent bg-clip-text mt-4 text-center">
                Halaman Tidak Ditemukan
            </h1>
            
            <div class="mb-4 mt-4 text-center">
                <a href="{{ url()->previous() }}" 
                   class="inline-block px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-lg hover:from-cyan-600 hover:to-cyan-700 transition-all duration-300 shadow-md hover:shadow-lg">
                    <span class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </span>
                </a>
            </div>

            <div class="text-sm text-gray-500 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Kode Error: 404 | SIMSAPRAS</span>
            </div>
        </div>
    </div>
</body>
</html>