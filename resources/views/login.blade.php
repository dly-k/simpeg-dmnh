<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIKEMAH</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- LineIcons CDN -->
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('/images/background.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            color: white;
        }
        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(6, 78, 59, 0.7), rgba(0,0,0,0.7), rgba(0,0,0,0.85));
        }
        .text-green-custom {
            background: linear-gradient(135deg, #00e676, #00c853);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .login-card {
            max-width: 380px;
            width: 100%;
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            margin-bottom: 0.5rem;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.9s ease forwards;
            color: #fff;
        }
        .login-card p.text-light {
            margin-top: 1.6rem; 
            font-size: 0.8rem;
        }

        /* Floating label */
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .floating-label input {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 8px;
            padding: 1rem 1rem 0.5rem 3rem;
            font-size: 1rem;
            width: 100%;
            color: #222;
            transition: all 0.2s ease;
        }
        .floating-label input:focus {
            border: 2px solid #00753b;
            box-shadow: 0 0 6px rgba(0, 153, 64, 0.3);
            background: #fff;
            outline: none;
            transform: scale(0.99);
        }
        .floating-label label {
            position: absolute;
            left: 3rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(0, 0, 0, 0.6);
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            top: 0.2rem;
            transform: none;
            font-size: 0.8rem;
            color: #00c853;
        }
        .floating-label .input-icon {
            position: absolute;
            top: 50%;
            left: 0.8rem;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: rgba(0, 0, 0, 0.5);
            transition: color 0.3s ease;
        }
        .floating-label input:focus ~ .input-icon {
            color: #00c853;
        }

        .btn-success {
            background: linear-gradient(135deg, #02BA56, #019c47);
            border: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #03d361, #01b84e);
            transform: scale(0.98);
        }
        .related-link {
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .related-link:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .logo-section {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInUp 1s ease forwards 0.3s;
        }

        /* RESPONSIVE FIX */
        @media (max-width: 576px) {
            body {
                background-position: top center;
            }
            .login-card {
                max-width: 95%;
                padding: 1.2rem;
                border-radius: 15px;
                margin-top: 2.5rem; /* card turun di HP */
            }
            .text-green-custom {
                font-size: 1.7rem;
            }
            .floating-label input {
                font-size: 0.9rem;
                padding: 0.8rem 0.8rem 0.4rem 2.5rem;
            }
            .floating-label label {
                left: 2.5rem;
                font-size: 0.85rem;
            }
            .floating-label .input-icon {
                font-size: 1rem;
                left: 0.7rem;
            }
            .btn-success {
                font-size: 0.9rem;
                padding: 0.7rem;
            }
            .logo-section .d-flex.flex-wrap.gap-3 {
                justify-content: flex-start !important; /* tautan rata kiri */
            }
        }
    </style>
</head>
<body>

    <!-- Overlay Gelap -->
    <div class="overlay"></div>

    <!-- Tanggal dan Jam -->
    <div class="position-absolute top-0 end-0 m-4 text-white z-3">
        <div class="d-flex align-items-center gap-4 bg-white bg-opacity-25 rounded-4 px-4 py-2 shadow-sm">
            <div class="d-flex align-items-center gap-2">
                <i class="lni lni-calendar text-white"></i>
                <span id="date">Selasa, 5 Agustus 2025</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="lni lni-timer text-white"></i>
                <span id="clock">14:12:18</span>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container position-relative z-2 d-flex align-items-center justify-content-center min-vh-100">
        <div class="row align-items-center w-100" style="max-width: 1100px;">
            
            <!-- Kiri: Logo & Deskripsi -->
            <div class="col-md-6 text-white px-4 logo-section">
                <div class="d-flex align-items-center mb-3 text-start">
                    <img src="/images/Logo.png" alt="Logo IPB" class="me-3 shadow" style="width: 90px; height: 90px;">
                    <div>
                        <h1 class="fw-bold mb-1">SI<span class="text-green-custom">KEMAH</span></h1>
                        <p class="small fw-medium text-light mb-0">
                            Sistem Informasi Kepegawaian Manajemen Hutan
                        </p>
                    </div>
                </div>
                <p class="small text-light text-start">
                    Demi keamanan, jangan pernah memberikan akun login (nama pengguna dan kata sandi) Anda kepada siapapun.
                </p>
                <div class="mt-4 text-start">
                    <h6 class="text-light mb-3">Tautan Terkait:</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="btn px-4 py-2 fw-semibold text-white related-link" style="background-color:#db2777;">SIPAKARIL</a>
                        <a href="#" class="btn px-4 py-2 fw-semibold text-white related-link" style="background-color:#f59e0b;">SIMPEG</a>
                        <a href="#" class="btn px-4 py-2 fw-semibold text-white related-link" style="background-color:#2563eb;">SIMANEH</a>
                    </div>
                </div>
            </div>

            <!-- Kanan: Form Login -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="login-card">
                  <h2 class="fw-bold text-center mb-2">Akses Masuk</h2>
                    <p class="text-center text-light small mb-4 mt-1">
                        Silakan masuk untuk melanjutkan
                    </p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- ID Pengguna -->
                        <div class="floating-label">
                            <input type="text" id="id_pengguna" name="id_pengguna" 
                                   placeholder=" " required autocomplete="username" 
                                   value="{{ old('id_pengguna') }}"
                                   class="@error('id_pengguna') form-input-error @enderror">
                            <label for="id_pengguna">ID Pengguna</label>
                            <i class="lni lni-user input-icon"></i>
                            @error('id_pengguna')
                                <div class="form-text text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kata Sandi -->
                        <div class="floating-label">
                            <input type="password" id="password" name="password" 
                                   placeholder=" " required autocomplete="current-password"
                                   class="@error('password') form-input-error @enderror">
                            <label for="password">Kata Sandi</label>
                            <i class="lni lni-key input-icon"></i>
                            @error('password')
                                <div class="form-text text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Masuk -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-success py-2 shadow-sm">MASUK</button>
                        </div>

                        <p class="text-center text-light small  mb-0">
                            © <span id="copyright-year">2025</span> Forest Management — All Rights Reserved
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function updateDateTime() {
            const now = new Date();
            document.getElementById('date').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
        document.getElementById('copyright-year').textContent = new Date().getFullYear();
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
