<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>SIKEMAH - Ubah Password</title>
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />  
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/ubah-password.css') }}" />
</head>

<body>
<div class="layout">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div class="main-wrapper">

      <!-- Header -->
      @include('layouts.header')

      <!-- Title Bar -->
      <div class="title-bar">
        <h1>
          <i class="fas fa-key"></i>
          <span id="page-title">Password</span>
        </h1>
      </div>

<div class="main-content">
  <div class="password-form-container">
    <div class="form-header">
      <h2>Ubah Password</h2>
    </div>
    <div class="form-body">
      {{-- Menampilkan pesan sukses --}}
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <form id="ubahPasswordForm" method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf

        <div class="mb-4">
          <label for="password_lama" class="form-label">Password Lama<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" placeholder="Masukkan Password Lama Anda" required aria-describedby="password_lama-error">
            <i class="fas fa-eye toggle-password"></i>
          </div>
          @error('password_lama')
            <div id="password_lama-error" class="error-message d-block">{{ $message }}</div>
          @else
            <div id="password_lama-error" class="error-message"></div>
          @enderror
        </div>

        <div class="mb-4">
          <label for="password_baru" class="form-label">Password Baru<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" placeholder="Masukkan Password Baru Anda" required aria-describedby="password_baru-error">
            <i class="fas fa-eye toggle-password"></i>
          </div>
           @error('password_baru')
            <div id="password_baru-error" class="error-message d-block">{{ $message }}</div>
          @else
            <div id="password_baru-error" class="error-message"></div>
          @enderror
        </div>
        
        <div class="mb-4">
          <label for="password_baru_confirmation" class="form-label">Konfirmasi Password Baru<span class="text-danger">*</span></label>
          <div class="password-field-wrapper">
            <input type="password" class="form-control" id="password_baru_confirmation" name="password_baru_confirmation" placeholder="Masukkan Kembali Password Baru Anda" required aria-describedby="konfirmasi_password_baru-error">
            <i class="fas fa-eye toggle-password"></i>
          </div>
          <div id="konfirmasi_password_baru-error" class="error-message"></div>
        </div>

        <button type="submit" class="btn btn-simpan w-100">Simpan</button>
      </form>
    </div>
  </div>
</div>

      <!-- Footer -->
      @include('layouts.footer')
    </div>
</div>

    {{-- Kumpulan Modal  --}}
    @include('components.konfirmasi-berhasil')

<script src="{{ asset('assets/js/layout.js') }}"></script> 
<script src="{{ asset('assets/js/ubah-password.js') }}"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>