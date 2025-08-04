<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKEMAH</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('/images/background.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="antialiased">
    <div class="absolute top-4 right-4 text-white text-sm">
        <div class="bg-black bg-opacity-30 backdrop-blur-sm rounded-lg px-4 py-2 flex items-center gap-4">
            <span>Senin, 7 Juli 2025</span>
            <span>10:20:50</span>
        </div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        
        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 items-center gap-16 max-w-6xl w-full">
            
            <div class="text-white">
                <img src="/images/Logo.png" alt="Logo IPB" class="w-24 h-24 mb-4">
                <h1 class="text-6xl font-bold text-green-300">SIKEMAH</h1>
                <p class="mt-2 text-xl font-medium">Selamat Datang di Sistem Informasi Kepegawaian Manajemen Hutan</p>
                <p class="mt-4 text-sm text-gray-200">
                    Jangan memberikan akun login (nama pengguna dan kata sandi) anda pada siapapun. Keamanan data anda terletak pada anda sendiri.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-6 rounded-md transition-colors">SIPAKARIL</a>
                    <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-md transition-colors">SIMPEG</a>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">SISEMINAR</a>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label for="id_pengguna" class="block mb-2 text-sm font-medium text-gray-700">ID Pengguna</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input type="text" id="id_pengguna" name="id_pengguna" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Masukkan ID Pengguna" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                         <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Kata sandi</label>
                         <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                               <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Masukkan kata sandi" required>
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                               <svg id="eye-icon" class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.42-7.14a1 1 0 0 1 1.59-.058l.424.688a1 1 0 0 0 1.59 0l.424-.688a1 1 0 0 1 1.59-.058l4.42 7.14c.264.426.264.954 0 1.38l-4.42 7.14a1 1 0 0 1-1.59.058l-.424-.688a1 1 0 0 0-1.59 0l-.424.688a1 1 0 0 1-1.59-.058l-4.42-7.14Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                               </svg>
                               <svg id="eye-slash-icon" class="w-5 h-5 text-gray-500 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.774 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
                               </svg>
                            </button>
                         </div>
                    </div>
                    
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-bold rounded-lg text-lg px-5 py-3 text-center transition-colors">MASUK</button>
                    
                    <p class="mt-8 text-center text-xs text-gray-500">
                        &copy; 2025 Forest Management — All Rights Reserved
                    </p>
                </form>
            </div>

        </div>
    </div>
    
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>