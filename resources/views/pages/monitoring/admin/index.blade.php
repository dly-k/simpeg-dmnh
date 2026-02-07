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
                        @include('pages.monitoring.admin._table_content', ['data' => $perencanaan])
                    </div>

                    {{-- TAB KEBIJAKAN --}}
                    <div class="tab-pane fade" id="kebijakan" role="tabpanel">
                        @include('pages.monitoring.admin._table_content', ['data' => $kebijakan])
                    </div>

                    {{-- TAB PEMANENAN --}}
                    <div class="tab-pane fade" id="pemanenan" role="tabpanel">
                        @include('pages.monitoring.admin._table_content', ['data' => $pemanenan])
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

</body>
</html>