<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <title>SIKEMAH - Dashboard</title>
  
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />  
  <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" />
</head>

<body>
    <div class="layout">
        
        {{-- Memanggil komponen sidebar dan overlay --}}
        @include('layouts.sidebar')

        <div class="main-wrapper">
            
            {{-- Memanggil komponen header (navbar atas) --}}
            @include('layouts.header')

            {{-- Title Bar --}}
            <div class="title-bar">
                <h1><i class="lni lni-grid-alt"></i> <span id="page-title">Dashboard</span></h1>
            </div>

            {{-- Konten Utama Halaman Dashboard --}}
            <div class="main-content">
                <div class="card-container">
                    <div class="stat-card">
                        <div class="card-icon icon-blue">
                            <i class="lni lni-users"></i>
                        </div>
                        <div>
                            <div class="card-label icon-green">Total Pegawai</div>
                            <div class="card-value">46</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="card-icon icon-green">
                            <i class="lni lni-stats-up"></i>
                        </div>
                        <div>
                            <div class="card-label">Kegiatan Tahun Ini</div>
                            <div class="card-value">125</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="card-icon icon-yellow">
                            <i class="lni lni-folder"></i>
                        </div>
                        <div>
                            <div class="card-label">Surat Tugas</div>
                            <div class="card-value">30</div>
                        </div>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart-box">
                        <h3>Statistik Kegiatan per Jenis</h3>
                        <canvas id="jenisChart"></canvas>
                    </div>
                    <div class="chart-box">
                        <h3>Kegiatan Dosen per Bulan</h3>
                        <canvas id="bulanChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Memanggil komponen footer --}}
            @include('layouts.footer')

        </div>
    </div>

<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>