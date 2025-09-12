{{-- Modal Tambah Data Kerjasama --}}
<div class="modal fade" id="kerjasamaModal" tabindex="-1" aria-labelledby="kerjasamaModalLabel" aria-hidden="true" data-has-error="{{ $errors->any() ? 'true' : 'false' }}">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="kerjasamaModalLabel">
                    <i class="fas fa-plus-circle"></i> Tambah Kerjasama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="kerjasamaForm" action="{{ route('kerjasama.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <!-- Judul -->
                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="Judul Kerjasama" value="{{ old('judul') }}">
                            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Mitra -->
                        <div class="col-12">
                            <label class="form-label">Mitra</label>
                            <input type="text" class="form-control @error('mitra') is-invalid @enderror" name="mitra" placeholder="Nama Mitra atau Instansi" value="{{ old('mitra') }}">
                            @error('mitra') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Nomor Dokumen -->
                        <div class="col-md-6">
                            <label class="form-label">No Surat Mitra</label>
                            <input type="text" class="form-control @error('no_surat_mitra') is-invalid @enderror" name="no_surat_mitra" placeholder="Nomor Surat dari Mitra" value="{{ old('no_surat_mitra') }}">
                            @error('no_surat_mitra') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No Surat Departemen</label>
                            <input type="text" class="form-control @error('no_surat_departemen') is-invalid @enderror" name="no_surat_departemen" placeholder="Nomor Surat dari Departemen" value="{{ old('no_surat_departemen') }}">
                            @error('no_surat_departemen') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Tanggal Dokumen -->
                        <div class="col-md-6">
                            <label class="form-label">Tgl. Dokumen</label>
                            <input type="date" name="tgl_dokumen" class="form-control @error('tgl_dokumen') is-invalid @enderror" value="{{ old('tgl_dokumen') }}">
                            @error('tgl_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Departemen PJ -->
                        <div class="col-md-6">
                            <label class="form-label">Departemen Penanggung Jawab</label>
                            <select class="form-select @error('departemen_penanggung_jawab') is-invalid @enderror" name="departemen_penanggung_jawab">
                                <option selected disabled>-- Pilih Salah Satu --</option>
                                <option value="Manajemen Hutan" {{ old('departemen_penanggung_jawab') == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                <option value="Konservasi Sumberdaya Hutan" {{ old('departemen_penanggung_jawab') == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                <option value="Teknologi Hasil Hutan" {{ old('departemen_penanggung_jawab') == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                            </select>
                            @error('departemen_penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- TMT dan TST -->
                        <div class="col-md-6">
                            <label class="form-label">TMT (Mulai)</label>
                            <input type="date" class="form-control @error('tmt') is-invalid @enderror" name="tmt" value="{{ old('tmt') }}">
                            @error('tmt') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">TST (Selesai)</label>
                            <input type="date" class="form-control @error('tst') is-invalid @enderror" name="tst" value="{{ old('tst') }}">
                            @error('tst') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Tim Kerjasama -->
                        <label class="form-label fw-normal d-block mb-0">Tim Kerjasama</label>
                        <div class="col-12 mb-2">
                            <div class="border rounded p-3">

                                <!-- Ketua -->
                                <label class="form-label">Ketua</label>
                                <div id="ketua-list">
                                    @foreach(old('ketua', [['nama'=>'','departemen'=>'']]) as $i => $ketua)
                                        <div class="d-flex gap-2 mb-2 ketua-item">
                                            <div class="flex-fill">
                                                <input type="text" name="ketua[{{ $i }}][nama]" class="form-control @error("ketua.$i.nama") is-invalid @enderror" placeholder="Nama Ketua" value="{{ old("ketua.$i.nama", $ketua['nama'] ?? '') }}">
                                                @error("ketua.$i.nama") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="flex-fill">
                                                <select name="ketua[{{ $i }}][departemen]" class="form-select @error("ketua.$i.departemen") is-invalid @enderror">
                                                    <option disabled {{ old("ketua.$i.departemen", $ketua['departemen'] ?? '') == '' ? 'selected' : '' }}>-- Pilih Departemen --</option>
                                                    <option value="Manajemen Hutan" {{ old("ketua.$i.departemen", $ketua['departemen'] ?? '') == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                                    <option value="Konservasi Sumberdaya Hutan" {{ old("ketua.$i.departemen", $ketua['departemen'] ?? '') == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                                    <option value="Teknologi Hasil Hutan" {{ old("ketua.$i.departemen", $ketua['departemen'] ?? '') == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                                                </select>
                                                @error("ketua.$i.departemen") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <button type="button" class="btn btn-danger remove-ketua">X</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-ketua-btn">+ Tambah Ketua</button>
                                @error('ketua') <div><small class="text-danger">{{ $message }}</small></div> @enderror

                                <!-- Anggota -->
                                <div class="mt-3">
                                    <label class="form-label">Anggota</label>
                                    <div id="anggota-list">
                                        @foreach(old('anggota', [['nama'=>'','departemen'=>'']]) as $i => $anggota)
                                            <div class="d-flex gap-2 mb-2 anggota-item">
                                                <div class="flex-fill">
                                                    <input type="text" name="anggota[{{ $i }}][nama]" class="form-control @error("anggota.$i.nama") is-invalid @enderror" placeholder="Nama Anggota" value="{{ old("anggota.$i.nama", $anggota['nama'] ?? '') }}">
                                                    @error("anggota.$i.nama") <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <div class="flex-fill">
                                                    <select name="anggota[{{ $i }}][departemen]" class="form-select @error("anggota.$i.departemen") is-invalid @enderror">
                                                        <option disabled {{ old("anggota.$i.departemen", $anggota['departemen'] ?? '') == '' ? 'selected' : '' }}>-- Pilih Departemen --</option>
                                                        <option value="Manajemen Hutan" {{ old("anggota.$i.departemen", $anggota['departemen'] ?? '') == 'Manajemen Hutan' ? 'selected' : '' }}>Manajemen Hutan</option>
                                                        <option value="Konservasi Sumberdaya Hutan" {{ old("anggota.$i.departemen", $anggota['departemen'] ?? '') == 'Konservasi Sumberdaya Hutan' ? 'selected' : '' }}>Konservasi Sumberdaya Hutan</option>
                                                        <option value="Teknologi Hasil Hutan" {{ old("anggota.$i.departemen", $anggota['departemen'] ?? '') == 'Teknologi Hasil Hutan' ? 'selected' : '' }}>Teknologi Hasil Hutan</option>
                                                    </select>
                                                    @error("anggota.$i.departemen") <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                                <button type="button" class="btn btn-danger remove-anggota">X</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-anggota-btn">+ Tambah Anggota</button>
                                    @error('anggota') <div><small class="text-danger">{{ $message }}</small></div> @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="Lokasi Kerjasama" value="{{ old('lokasi') }}">
                            @error('lokasi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Dana -->
                        <div class="col-md-6">
                            <label class="form-label">Besaran Dana</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" name="besaran_dana" id="besaran_dana" class="form-control @error('besaran_dana') is-invalid @enderror" placeholder="Contoh: 50000000" value="{{ old('besaran_dana') }}">
                            </div>
                            @error('besaran_dana') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Jenis Kerjasama -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kerjasama</label>
                            <select class="form-select @error('jenis_kerjasama') is-invalid @enderror" name="jenis_kerjasama">
                                <option selected disabled>-- Pilih Salah Satu --</option>
                                <option value="MoU" {{ old('jenis_kerjasama') == 'MoU' ? 'selected' : '' }}>MoU</option>
                                <option value="LoA" {{ old('jenis_kerjasama') == 'LoA' ? 'selected' : '' }}>LoA</option>
                                <option value="SPK" {{ old('jenis_kerjasama') == 'SPK' ? 'selected' : '' }}>SPK</option>
                            </select>
                            @error('jenis_kerjasama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Jenis Usulan -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Usulan</label>
                            <select class="form-select @error('jenis_usulan') is-invalid @enderror" name="jenis_usulan">
                                <option selected disabled>-- Pilih Salah Satu --</option>
                                <option value="Baru" {{ old('jenis_usulan') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Perpanjangan" {{ old('jenis_usulan') == 'Perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                            </select>
                            @error('jenis_usulan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="col-12">
                            <label class="form-label">Unggah Dokumen</label>
                            <div class="upload-area" id="uploadAreaDokumen">
                                <i class="fas fa-cloud-upload-alt default-icon"></i>
                                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                            </div>
                            <input type="file" name="file_dokumen" id="file_dokumen" accept=".pdf,.doc,.docx" class="hidden-input">
                            @error('file_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Upload Laporan -->
                        <div class="col-12">
                            <label class="form-label">Unggah Laporan Kerjasama (opsional)</label>
                            <div class="upload-area" id="uploadAreaLaporan">
                                <i class="fas fa-cloud-upload-alt default-icon"></i>
                                <p class="upload-text">Seret & Lepas File di sini<br><small>Ukuran Maksimal 5 MB</small></p>
                            </div>
                            <input type="file" name="file_laporan" id="file_laporan" accept=".pdf,.doc,.docx" class="hidden-input">
                            @error('file_laporan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="kerjasamaForm" class="btn btn-success">Simpan</button>
            </div>

        </div>
    </div>
</div>