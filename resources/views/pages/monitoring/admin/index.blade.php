<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIKEMAH - Monitoring Progress Jabatan</title>

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-pegawai.css') }}" />
</head>

<body>
<div class="layout">
    @include('layouts.sidebar')

    <div class="main-wrapper">
        @include('layouts.header')

        <div class="title-bar">
            <h1>
                <i class="lni lni-timer"></i>
                <span id="page-title">Monitoring Progress Jabatan</span>
            </h1>
        </div>

        <div class="main-content">
            {{-- FORM FILTER PENCARIAN (OTOMATIS SUBMIT) --}}
            <div class="filter-section mb-4 bg-white p-3 shadow-sm border" style="border-radius: 12px; border-left: 5px solid #001f3f !important;">
                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end">
                    
                    {{-- Filter Jabatan Terakhir --}}
                    <div class="col-md-5">
                        <label for="jabatan" class="form-label small fw-bold text-navy mb-1"><i class="fas fa-briefcase me-1"></i> Jabatan Terakhir</label>
                        {{-- Tambahkan onchange="this.form.submit()" di sini --}}
                        <select name="jabatan" id="jabatan" class="form-select form-select-sm border-secondary shadow-none" onchange="this.form.submit()">
                            <option value="">-- Semua Jabatan --</option>
                            @if(isset($listJabatan))
                                @foreach($listJabatan as $jab)
                                    <option value="{{ $jab }}" {{ request('jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Filter Rentang Usia --}}
                    <div class="col-md-5">
                        <label for="age_range" class="form-label small fw-bold text-navy mb-1"><i class="fas fa-calendar-alt me-1"></i> Rentang Usia</label>
                        {{-- Tambahkan onchange="this.form.submit()" di sini --}}
                        <select name="age_range" id="age_range" class="form-select form-select-sm border-secondary shadow-none" onchange="this.form.submit()">
                            <option value="">-- Semua Usia --</option>
                            <option value="20-25" {{ request('age_range') == '20-25' ? 'selected' : '' }}>20 - 25 Tahun</option>
                            <option value="26-30" {{ request('age_range') == '26-30' ? 'selected' : '' }}>26 - 30 Tahun</option>
                            <option value="31-35" {{ request('age_range') == '31-35' ? 'selected' : '' }}>31 - 35 Tahun</option>
                            <option value="36-40" {{ request('age_range') == '36-40' ? 'selected' : '' }}>36 - 40 Tahun</option>
                            <option value="41-45" {{ request('age_range') == '41-45' ? 'selected' : '' }}>41 - 45 Tahun</option>
                            <option value="46-50" {{ request('age_range') == '46-50' ? 'selected' : '' }}>46 - 50 Tahun</option>
                            <option value="51-55" {{ request('age_range') == '51-55' ? 'selected' : '' }}>51 - 55 Tahun</option>
                            <option value="56-60" {{ request('age_range') == '56-60' ? 'selected' : '' }}>56 - 60 Tahun</option>
                            <option value="61-65" {{ request('age_range') == '61-65' ? 'selected' : '' }}>61 - 65 Tahun</option>
                            <option value="66-70" {{ request('age_range') == '66-70' ? 'selected' : '' }}>66 - 70 Tahun</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="table-card">
                {{-- TAB DIVISI --}}
                <div class="tab-bar-container d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills" id="divisiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="perencanaan-tab" data-bs-toggle="tab" data-bs-target="#perencanaan" type="button" role="tab">Perencanaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kebijakan-tab" data-bs-toggle="tab" data-bs-target="#kebijakan" type="button" role="tab">Kebijakan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pemanenan-tab" data-bs-toggle="tab" data-bs-target="#pemanenan" type="button" role="tab">Pemanenan</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content mt-4" id="divisiTabContent">
                    {{-- TAB PERENCANAAN --}}
                    <div class="tab-pane fade show active" id="perencanaan" role="tabpanel">
                        {{-- SESUAIKAN: Kirim variabel dengan nama 'pegawais' --}}
                        @include('pages.monitoring.admin._table_content', ['pegawais' => $perencanaan])
                    </div>

                    {{-- TAB KEBIJAKAN --}}
                    <div class="tab-pane fade" id="kebijakan" role="tabpanel">
                        @include('pages.monitoring.admin._table_content', ['pegawais' => $kebijakan])
                    </div>

                    {{-- TAB PEMANENAN --}}
                    <div class="tab-pane fade" id="pemanenan" role="tabpanel">
                        @include('pages.monitoring.admin._table_content', ['pegawais' => $pemanenan])
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
</div>

{{-- SCRIPT --}}
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/daftar-pegawai.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Ambil ID tab yang tersimpan di SessionStorage (jika ada)
        let activeTabId = sessionStorage.getItem('activeMonitoringTab');

        // 2. Jika ada, aktifkan tab tersebut menggunakan Bootstrap API
        if (activeTabId) {
            let tabToActivate = document.getElementById(activeTabId);
            if (tabToActivate) {
                let tabInstance = new bootstrap.Tab(tabToActivate);
                tabInstance.show();
            }
        }

        // 3. Pasang event listener: Setiap kali tab diklik/diubah, simpan ID-nya ke SessionStorage
        let tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabElements.forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function (event) {
                // event.target.id akan menghasilkan "perencanaan-tab", "kebijakan-tab", dll
                sessionStorage.setItem('activeMonitoringTab', event.target.id);
            });
        });
    });
</script>
</body>
</html>