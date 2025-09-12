{{-- Modal Edit Data Kerjasama --}}
<div class="modal fade" id="editKerjasamaModal-{{ $kerjasama->id }}" tabindex="-1" aria-labelledby="editKerjasamaModalLabel-{{ $kerjasama->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editKerjasamaModalLabel-{{ $kerjasama->id }}">
                    <i class="fas fa-edit"></i> Edit Kerjasama
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="editKerjasamaForm-{{ $kerjasama->id }}" 
                      action="{{ route('kerjasama.update', $kerjasama->id) }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Judul -->
                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" 
                                   name="judul" placeholder="Judul Kerjasama" 
                                   value="{{ $kerjasama->judul }}" required>
                        </div>

                        <!-- Mitra -->
                        <div class="col-12">
                            <label class="form-label">Mitra</label>
                            <input type="text" class="form-control" 
                                   name="mitra" placeholder="Nama Mitra atau Instansi" 
                                   value="{{ $kerjasama->mitra }}" required>
                        </div>

                        <!-- Nomor Dokumen -->
                        <div class="col-md-6">
                            <label class="form-label">No Surat Mitra</label>
                            <input type="text" class="form-control" 
                                   name="no_surat_mitra" placeholder="Nomor Surat dari Mitra" 
                                   value="{{ $kerjasama->no_surat_mitra }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Surat Departemen</label>
                            <input type="text" class="form-control" 
                                   name="no_surat_departemen" placeholder="Nomor Surat dari Departemen" 
                                   value="{{ $kerjasama->no_surat_departemen }}" required>
                        </div>

                        <!-- Tanggal Dokumen -->
                        <div class="col-md-6">
                            <label class="form-label">Tgl. Dokumen</label>
                            <input type="date" name="tgl_dokumen" 
                                   class="form-control" 
                                   value="{{ optional($kerjasama->tgl_dokumen)->format('Y-m-d') }}" required>
                        </div>

                        <!-- Departemen PJ -->
                        <div class="col-md-6">
                            <label class="form-label">Departemen Penanggung Jawab</label>
                            <select class="form-select" required 
                                    name="departemen_penanggung_jawab">
                                <option disabled>-- Pilih Salah Satu --</option>
                                <option value="Manajemen Hutan" {{ $kerjasama->departemen_penanggung_jawab == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                <option value="Konservasi Sumberdaya Hutan" {{ $kerjasama->departemen_penanggung_jawab == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                <option value="Teknologi Hasil Hutan" {{ $kerjasama->departemen_penanggung_jawab == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                            </select>
                        </div>

                        <!-- TMT dan TST -->
                        <div class="col-md-6">
                            <label class="form-label">TMT (Mulai)</label>
                            <input type="date" class="form-control" 
                                   name="tmt" value="{{ optional($kerjasama->tmt)->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">TST (Selesai)</label>
                            <input type="date" class="form-control" 
                                   name="tst" value="{{ optional($kerjasama->tst)->format('Y-m-d') }}" required>
                        </div>

                        <!-- Tim Kerjasama -->
                        <label class="form-label fw-normal d-block mb-0">Tim Kerjasama</label>
                        <div class="col-12 mb-2">
                            <div class="border rounded p-3">
                                {{-- Ketua --}}
                                <label class="form-label">Ketua</label>
                                <div id="ketua-list-{{ $kerjasama->id }}">
                                    @foreach($kerjasama->ketua as $i => $ketua)
                                        <div class="d-flex gap-2 mb-2 ketua-item">
                                            <div class="flex-fill">
                                                <input type="text" name="ketua[{{ $i }}][nama]" 
                                                       class="form-control" 
                                                       placeholder="Nama Ketua" 
                                                       value="{{ $ketua->nama }}">
                                            </div>
                                            <div class="flex-fill">
                                                <select name="ketua[{{ $i }}][departemen]" class="form-select">
                                                    <option disabled>-- Pilih Departemen --</option>
                                                    <option value="Manajemen Hutan" {{ $ketua->departemen == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                                    <option value="Konservasi Sumberdaya Hutan" {{ $ketua->departemen == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                                    <option value="Teknologi Hasil Hutan" {{ $ketua->departemen == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-ketua">X</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-ketua-btn-{{ $kerjasama->id }}">+ Tambah Ketua</button>

                                {{-- Anggota --}}
                                <div class="mt-3">
                                    <label class="form-label">Anggota</label>
                                    <div id="anggota-list-{{ $kerjasama->id }}">
                                        @foreach($kerjasama->anggota as $i => $anggota)
                                            <div class="d-flex gap-2 mb-2 anggota-item">
                                                <div class="flex-fill">
                                                    <input type="text" name="anggota[{{ $i }}][nama]" 
                                                           class="form-control" 
                                                           placeholder="Nama Anggota" 
                                                           value="{{ $anggota->nama }}">
                                                </div>
                                                <div class="flex-fill">
                                                    <select name="anggota[{{ $i }}][departemen]" class="form-select">
                                                        <option disabled>-- Pilih Departemen --</option>
                                                        <option value="Manajemen Hutan" {{ $anggota->departemen == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                                        <option value="Konservasi Sumberdaya Hutan" {{ $anggota->departemen == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                                        <option value="Teknologi Hasil Hutan" {{ $anggota->departemen == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-danger remove-anggota">X</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-anggota-btn-{{ $kerjasama->id }}">+ Tambah Anggota</button>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" 
                                   value="{{ $kerjasama->lokasi }}">
                        </div>

                        <!-- Dana -->
                        <div class="col-md-6">
                            <label class="form-label">Besaran Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="besaran_dana" class="form-control" 
                                       value="{{ $kerjasama->besaran_dana }}">
                            </div>
                        </div>

                        <!-- Jenis Kerjasama -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kerjasama</label>
                            <select class="form-select" name="jenis_kerjasama">
                                <option disabled>-- Pilih Salah Satu --</option>
                                <option value="MoU" {{ $kerjasama->jenis_kerjasama == 'MoU' ? 'selected' : '' }}>MoU</option>
                                <option value="LoA" {{ $kerjasama->jenis_kerjasama == 'LoA' ? 'selected' : '' }}>LoA</option>
                                <option value="SPK" {{ $kerjasama->jenis_kerjasama == 'SPK' ? 'selected' : '' }}>SPK</option>
                            </select>
                        </div>

                        <!-- Jenis Usulan -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Usulan</label>
                            <select class="form-select" name="jenis_usulan">
                                <option disabled>-- Pilih Salah Satu --</option>
                                <option value="Baru" {{ $kerjasama->jenis_usulan == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Perpanjangan" {{ $kerjasama->jenis_usulan == 'Perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                            </select>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="col-12">
                            <label class="form-label">Unggah Dokumen</label>
                            <div class="upload-area" id="uploadAreaDokumen-{{ $kerjasama->id }}">
                                <i class="fas fa-cloud-upload-alt default-icon"></i>
                                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                            </div>
                            <input type="file" name="file_dokumen" id="file_dokumen-{{ $kerjasama->id }}" accept=".pdf,.doc,.docx" class="hidden-input">
                            @if($kerjasama->file_dokumen)
                                <small class="text-muted">File saat ini: {{ $kerjasama->file_dokumen }}</small>
                            @endif
                        </div>

                        <!-- Upload Laporan -->
                        <div class="col-12">
                            <label class="form-label">Unggah Laporan Kerjasama (opsional)</label>
                            <div class="upload-area" id="uploadAreaLaporan-{{ $kerjasama->id }}">
                                <i class="fas fa-cloud-upload-alt default-icon"></i>
                                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                            </div>
                            <input type="file" name="file_laporan" id="file_laporan-{{ $kerjasama->id }}" accept=".pdf,.doc,.docx" class="hidden-input">
                            @if($kerjasama->file_laporan)
                                <small class="text-muted">File saat ini: {{ $kerjasama->file_laporan }}</small>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="editKerjasamaForm-{{ $kerjasama->id }}" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>