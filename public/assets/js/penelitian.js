// ===================================================================================
// DEFINISI FUNGSI GLOBAL & VARIABEL
// ===================================================================================

// Variabel global untuk menyimpan data pegawai & counter
let pegawaiList = [];
let counters = { ipb: 1, luar: 1, mahasiswa: 1 };
// Variabel untuk menyimpan ID item yang sedang diproses
let currentVerifikasiId = null; 
let currentVerifikasiJudul = '';
let currentHapusId = null;

// Menerima data pegawai dari Blade dan menyimpannya di variabel global
window.initPegawaiList = (data) => {
  pegawaiList = data;
};

// Fungsi utama untuk membuat baris input penulis baru
window.createPenulisInput = (type, index, isFirst = false) => {
  const btnClass = isFirst ? "btn-outline-success" : "btn-outline-danger";
  const btnIcon = isFirst ? "+" : "-";
  const btnAction = isFirst
    ? `addPenulis('${type}')`
    : "this.parentElement.remove()";

  let fields = "";
  if (type === "ipb") {
    const options = pegawaiList.map(p => `<option value="${p.id}">${p.nama}</option>`).join('');
    fields = `
      <select class="form-select" name="penulis_ipb[${index}][pegawai_id]" required>
        <option value="" selected disabled>-- Pilih Pegawai Aktif --</option>
        ${options}
      </select>
      <label class="input-group-text">Upload SK</label>
      <input type="file" class="form-control" name="penulis_ipb[${index}][sk]">
    `;
  } else if (type === "luar") {
    fields = `
      <input type="text" class="form-control" name="penulis_luar[${index}][nama]" placeholder="Nama Penulis Luar" required>
      <input type="text" class="form-control" name="penulis_luar[${index}][afiliasi]" placeholder="Afiliasi/Instansi">
      <label class="input-group-text">Upload SK</label>
      <input type="file" class="form-control" name="penulis_luar[${index}][sk]">
    `;
  } else if (type === "mahasiswa") {
    fields = `<input type="text" class="form-control" name="penulis_mahasiswa[${index}][nama]" placeholder="Nama Mahasiswa" required>`;
  }

  return `<div class="input-group mb-2">${fields}<button class="btn ${btnClass}" type="button" onclick="${btnAction}">${btnIcon}</button></div>`;
};

// Fungsi untuk menambahkan baris penulis baru
window.addPenulis = (type) => {
  const listId = `penulis-${type}-list`;
  const list = document.getElementById(listId);
  if (list) {
    list.insertAdjacentHTML("beforeend", createPenulisInput(type, counters[type]++));
  }
};

// Fungsi untuk mereset field saat modal dibuka
window.resetPenulisFields = () => {
    counters = { ipb: 1, luar: 1, mahasiswa: 1 };
    document.getElementById("penulis-ipb-list").innerHTML = createPenulisInput('ipb', 0, true);
    document.getElementById("penulis-luar-list").innerHTML = createPenulisInput('luar', 0, true);
    document.getElementById("penulis-mahasiswa-list").innerHTML = createPenulisInput('mahasiswa', 0, true);
};

// Fungsi untuk menampilkan modal sukses
window.showSuccessModal = (title, subtitle) => {
    const modalBerhasil = document.getElementById("modalBerhasil");
    const berhasilTitle = document.getElementById("berhasil-title");
    const berhasilSubtitle = document.getElementById("berhasil-subtitle");
    const successSound = new Audio("/assets/sounds/success.mp3");

    if (!modalBerhasil || !berhasilTitle || !berhasilSubtitle) return;
    berhasilTitle.textContent = title;
    berhasilSubtitle.textContent = subtitle;
    modalBerhasil.classList.add("show");
    document.body.style.overflow = "hidden";
    successSound.play().catch(e => console.error("Error memutar audio:", e));
    setTimeout(() => {
        modalBerhasil.classList.remove("show");
        if (!document.querySelector(".modal.show")) {
            document.body.style.overflow = "";
        }
    }, 1200);
};

// ===================================================================================
// EKSEKUSI SETELAH HALAMAN SIAP (DOMContentLoaded)
// ===================================================================================
document.addEventListener("DOMContentLoaded", () => {
  // --- Inisialisasi Semua Modal ---
  const penelitianModalEl = document.getElementById("penelitianModal");
  const detailModalEl = document.getElementById("detailModal");
  const modalKonfirmasiVerifikasi = document.getElementById('modalKonfirmasiVerifikasi');
  const konfirmasiHapusModal = document.querySelector('.konfirmasi-hapus-overlay');
  
  const penelitianModalInstance = penelitianModalEl ? new bootstrap.Modal(penelitianModalEl) : null;
  const detailModalInstance = detailModalEl ? new bootstrap.Modal(detailModalEl) : null;
  const penelitianForm = document.getElementById("penelitianForm");

  // --- Fungsi untuk mengirim request verifikasi (AJAX) ---
  function sendVerifikasiRequest(status) {
    if (!currentVerifikasiId) return;
    const actionUrl = `/penelitian/${currentVerifikasiId}/verifikasi`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData();
    formData.append('status', status);

    fetch(actionUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        modalKonfirmasiVerifikasi.classList.remove('show');
        showSuccessModal('Berhasil!', data.message);
        setTimeout(() => { location.reload(); }, 1200);
      } else { alert('Terjadi kesalahan.'); }
    })
    .catch(error => console.error('Fetch Error:', error));
  }

  // --- Fungsi untuk mengirim request hapus (AJAX) ---
  function sendHapusRequest() {
    if (!currentHapusId) return;
    const actionUrl = `/penelitian/${currentHapusId}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(actionUrl, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const row = document.querySelector(`tr[data-row-id="${currentHapusId}"]`);
        if (row) row.remove();
        konfirmasiHapusModal.classList.remove('show');
        showSuccessModal('Berhasil!', data.message);
      } else {
        alert(data.message || 'Gagal menghapus data.');
      }
    })
    .catch(error => console.error('Error:', error));
  }
  
  // --- Fungsi untuk mengisi Form Edit & Detail ---
  function populateForm(data) { /* ... (kode lengkap dari jawaban sebelumnya) ... */ }
  function populateDetailModal(data) { /* ... (kode lengkap dari jawaban sebelumnya) ... */ }
  // (kode lengkap disalin di sini)
  function populateForm(a){penelitianForm.querySelector('[name="judul"]').value=a.judul,penelitianForm.querySelector('[name="jenis_karya"]').value=a.jenis_karya,penelitianForm.querySelector('[name="volume"]').value=a.volume,penelitianForm.querySelector('[name="jumlah_halaman"]').value=a.jumlah_halaman,penelitianForm.querySelector('[name="tanggal_terbit"]').value=a.tanggal_terbit?a.tanggal_terbit.substring(0,10):"",penelitianForm.querySelector('[name="publik"]').value=a.is_publik?"Ya":"Tidak",penelitianForm.querySelector('[name="isbn"]').value=a.isbn,penelitianForm.querySelector('[name="issn"]').value=a.issn,penelitianForm.querySelector('[name="doi"]').value=a.doi,penelitianForm.querySelector('[name="url"]').value=a.url,document.getElementById("penulis-ipb-list").innerHTML="",document.getElementById("penulis-luar-list").innerHTML="",document.getElementById("penulis-mahasiswa-list").innerHTML="",counters={ipb:0,luar:0,mahasiswa:0},a.penulis&&a.penulis.length>0&&a.penulis.forEach(t=>{let e;e="IPB"===t.tipe_penulis?"ipb":"Luar IPB"===t.tipe_penulis?"luar":"mahasiswa",addPenulis(e),"ipb"===e?document.querySelector(`#penulis-ipb-list .input-group:last-child select`).value=t.pegawai_id:"luar"===e?(document.querySelector(`#penulis-luar-list .input-group:last-child [name$="[nama]"]`).value=t.nama_penulis,document.querySelector(`#penulis-luar-list .input-group:last-child [name$="[afiliasi]"]`).value=t.afiliasi):document.querySelector(`#penulis-mahasiswa-list .input-group:last-child input`).value=t.nama_penulis}),""===document.getElementById("penulis-ipb-list").innerHTML&&addPenulis("ipb"),""===document.getElementById("penulis-luar-list").innerHTML&&addPenulis("luar"),""===document.getElementById("penulis-mahasiswa-list").innerHTML&&addPenulis("mahasiswa")}
  // GANTI FUNGSI LAMA ANDA DENGAN INI
// --- Fungsi untuk mengisi Modal Detail ---
function populateDetailModal(data) {
  // Fungsi helper untuk mengisi elemen atau menampilkan strip jika data kosong
  const setDetail = (id, value) => {
      const el = document.getElementById(id);
      if (el) el.textContent = value || '-';
  };

  setDetail('detail-judul', data.judul);
  setDetail('detail-jenis_karya', data.jenis_karya);
  setDetail('detail-volume', data.volume);
  setDetail('detail-jumlah_halaman', data.jumlah_halaman);
  
  const tanggalTerbitEl = document.getElementById('detail-tanggal_terbit');
  if (tanggalTerbitEl) {
      if (data.tanggal_terbit) {
          const date = new Date(data.tanggal_terbit);
          tanggalTerbitEl.textContent = date.toLocaleDateString('id-ID', {
              day: 'numeric',
              month: 'long',
              year: 'numeric'
          });
      } else {
          tanggalTerbitEl.textContent = '-';
      }
  }

  setDetail('detail-publik', data.is_publik ? 'Ya' : 'Tidak');
  setDetail('detail-isbn', data.isbn);
  setDetail('detail-issn', data.issn);
  setDetail('detail-doi', data.doi);

  const urlEl = document.getElementById('detail-url');
  if (urlEl) {
      urlEl.innerHTML = data.url ? `<a href="${data.url}" target="_blank">Lihat Tautan</a>` : '-';
  }

  const docEl = document.getElementById('detail-dokumen');
  if (docEl) {
      docEl.innerHTML = data.dokumen_path ? `<a href="/storage/${data.dokumen_path}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-file-alt me-2"></i>Lihat Dokumen</a>` : '<span class="text-muted">Tidak ada dokumen</span>';
  }
  
  // Reset dan isi daftar penulis
  ['ipb', 'luar', 'mahasiswa'].forEach(type => {
      document.getElementById(`detail-penulis-${type}-section`).style.display = 'none';
      document.getElementById(`detail-penulis-${type}-list`).innerHTML = '';
  });

  if (data.penulis && data.penulis.length > 0) {
      data.penulis.forEach(p => {
          let type, listEl, content = '';
          let namaPenulisHtml = '';
          let skLinkHtml = '';

          // Siapkan HTML untuk Nama Penulis
          if (p.tipe_penulis === 'IPB') {
              type = 'ipb';
              namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Penulis</small><p>${p.pegawai.nama_lengkap}</p></div>`;
          } else if (p.tipe_penulis === 'Luar IPB') {
              type = 'luar';
              namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Penulis</small><p>${p.nama_penulis} (${p.afiliasi || 'Tidak ada afiliasi'})</p></div>`;
          } else { // Mahasiswa
              type = 'mahasiswa';
              namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Mahasiswa</small><p>${p.nama_penulis}</p></div>`;
          }
          
          // Siapkan HTML untuk SK Penugasan (jika ada)
          // Jika tidak ada SK, buat div kosong agar layout tidak rusak
          if (p.sk_penugasan_path) {
              skLinkHtml = `
                  <div class="detail-item" style="border:none; padding:0;">
                      <small>SK Penugasan</small>
                      <p><a href="/storage/${p.sk_penugasan_path}" target="_blank">Lihat SK</a></p>
                  </div>`;
          } else if (p.tipe_penulis !== 'Mahasiswa') {
              skLinkHtml = '<div></div>'; // Placeholder untuk menjaga layout grid
          }

          // ================== PERUBAHAN UTAMA DI SINI ==================
          // Gabungkan menjadi satu baris entri penulis dengan layout grid 2 kolom
          content = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; width: 100%; border-bottom: 1px solid #e9ecef; margin-bottom: 1rem; padding-bottom: 1rem;">
                ${namaPenulisHtml}
                ${skLinkHtml}
            </div>
          `;
          // ===============================================================
          
          document.getElementById(`detail-penulis-${type}-section`).style.display = 'block';
          const listContainer = document.getElementById(`detail-penulis-${type}-list`);
          listContainer.style.display = 'block';
          listContainer.insertAdjacentHTML('beforeend', content);
      });
  }
}
  // --- Fungsi-fungsi pembuka Modal ---
  window.openModal = () => { /* ... (kode lengkap dari jawaban sebelumnya) ... */ };
  window.openEditModal = (id) => { /* ... (kode lengkap dari jawaban sebelumnya) ... */ };
  window.openDetailModal = (id) => { /* ... (kode lengkap dari jawaban sebelumnya) ... */ };
  // (kode lengkap disalin di sini)
  window.openModal=()=>{penelitianModalInstance&&(penelitianForm.reset(),penelitianForm.action="/penelitian",document.getElementById("form-method-placeholder").innerHTML="",document.getElementById("penelitianModalLabel").innerHTML='<i class="fas fa-plus-circle"></i> Tambah Data Penelitian',penelitianForm.querySelector('button[type="submit"]').textContent="Simpan Data",resetPenulisFields(),penelitianModalInstance.show())},window.openEditModal=a=>{penelitianModalInstance&&fetch(`/penelitian/${a}/edit`).then(a=>a.json()).then(t=>{penelitianForm.reset(),penelitianForm.action=`/penelitian/${a}`,document.getElementById("form-method-placeholder").innerHTML='<input type="hidden" name="_method" value="PATCH">',document.getElementById("penelitianModalLabel").innerHTML='<i class="fas fa-edit"></i> Edit Data Penelitian',penelitianForm.querySelector('button[type="submit"]').textContent="Update Data",populateForm(t),penelitianModalInstance.show()}).catch(a=>console.error("Error fetching data for edit:",a))},window.openDetailModal=a=>{detailModalInstance&&fetch(`/penelitian/${a}/edit`).then(a=>a.json()).then(t=>{populateDetailModal(t),detailModalInstance.show()}).catch(a=>console.error("Error fetching detail data:",a))};

  // --- Event listener untuk tombol Selesai di modal sukses ---
  document.getElementById("btnSelesai")?.addEventListener("click", () => {
      document.getElementById("modalBerhasil")?.classList.remove("show");
      location.reload();
  });

  // --- Penanganan event klik terpusat ---
  document.addEventListener('click', function(e) {
    
    // ================== PERBAIKAN LOGIKA DIMULAI DI SINI ==================
    
    // Cek jika klik ada di dalam MODAL HAPUS
    if (e.target.closest('.konfirmasi-hapus-overlay')) {
        const clickedButtonInHapusModal = e.target.closest('.btn-popup');
        if (clickedButtonInHapusModal) {
            if (clickedButtonInHapusModal.classList.contains('btn-hapus')) {
                sendHapusRequest();
            } else if (clickedButtonInHapusModal.classList.contains('btn-batal')) {
                konfirmasiHapusModal.classList.remove('show');
            }
        }
        return; // Hentikan pengecekan lebih lanjut jika klik sudah ditangani di sini
    }
    
    // Cek jika klik ada di dalam MODAL VERIFIKASI
    if (e.target.closest('#modalKonfirmasiVerifikasi')) {
        const clickedButtonInVerifModal = e.target.closest('.btn-popup');
        if (clickedButtonInVerifModal) {
            const buttonId = clickedButtonInVerifModal.id;
            if (buttonId === 'popupBtnTerima') { sendVerifikasiRequest('Sudah Diverifikasi'); } 
            else if (buttonId === 'popupBtnTolak') { sendVerifikasiRequest('Ditolak'); } 
            else if (buttonId === 'popupBtnKembali') { modalKonfirmasiVerifikasi.classList.remove('show'); }
        }
        return; // Hentikan pengecekan lebih lanjut
    }

    // Cek tombol AKSI di TABEL (Hapus & Verifikasi)
    const aksiBtn = e.target.closest('.btn-aksi');
    if (aksiBtn) {
        if (aksiBtn.classList.contains('btn-verifikasi')) {
            e.preventDefault();
            currentVerifikasiId = aksiBtn.dataset.id;
            currentVerifikasiJudul = aksiBtn.dataset.judul;
            modalKonfirmasiVerifikasi.classList.add('show');
        }
        if (aksiBtn.classList.contains('btn-hapus')) {
            e.preventDefault();
            currentHapusId = aksiBtn.dataset.id;
            konfirmasiHapusModal.classList.add('show');
        }
    }
  });
});