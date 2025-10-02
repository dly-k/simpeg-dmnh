<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Login - SIKEMAH</title>

  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" />
</head>

<body>
  <div class="overlay"></div>
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
    <div class="row align-items-center w-100">

      <!-- Kiri: Logo & Deskripsi -->
      <div class="col-md-6 text-white px-4 logo-section">
        <div class="d-flex align-items-center mb-3 text-start">
          <img src="assets/images/Logo.png" alt="Logo IPB" class="me-3 logo-ipb">
          <div>
            <h1 class="fw-bold mb-1">SI<span class="text-green-custom">KEMAH</span></h1>
            <p class="small fw-medium text-light mb-0">Sistem Informasi Kepegawaian Manajemen Hutan</p>
          </div>
        </div>

        <p class="small text-light text-start">
          Demi keamanan, jangan pernah memberikan akun login (nama pengguna dan kata sandi) Anda kepada siapapun.
        </p>

        <div class="mt-4 text-start">
          <h6 class="text-light mb-3">Tautan Terkait:</h6>
          <div class="d-flex flex-wrap gap-3">
            <a href="https://sipakaril.ipb.ac.id/" class="btn px-4 py-2 fw-semibold text-white related-link sipakaril">SIPAKARIL</a>
            <a href="https://simpeg.ipb.ac.id/" class="btn px-4 py-2 fw-semibold text-white related-link simpeg">SIMPEG</a>
            <a href="#" class="btn px-4 py-2 fw-semibold text-white related-link simaneh">SIMANEH</a> 
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

<form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="floating-label">
              <input type="text" id="username" name="username" placeholder=" " required value="{{ old('username') }}" class="@error('username') form-input-error @enderror">
              <label for="username">ID Pengguna</label>
              <i class="lni lni-user input-icon"></i>
              @error('username')
                <div class="form-text text-danger small">{{ $message }}</div>
              @enderror
            </div>
            <div class="floating-label">
              <input type="password" id="password" name="password" placeholder=" " required autocomplete="current-password" class="@error('password') form-input-error @enderror">
              <label for="password">Kata Sandi</label>
              <i class="lni lni-key input-icon"></i>
              @error('password')
                <div class="form-text text-danger small">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-grid mb-4">
              <button type="submit" class="btn btn-success py-2 shadow-sm">MASUK</button>
            </div>
            <p class="text-center text-light small mb-0">
              © <span id="copyright-year"></span> Forest Management — All Rights Reserved
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/login.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>