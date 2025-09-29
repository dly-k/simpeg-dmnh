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
// FUNGSI PEMBUKA MODAL (DIDEFINISIKAN SECARA GLOBAL)
// ===================================================================================
window.openModal=()=>{
    const penelitianModalEl = document.getElementById("penelitianModal");
    const penelitianModalInstance = penelitianModalEl ? new bootstrap.Modal(penelitianModalEl) : null;
    const penelitianForm = document.getElementById("penelitianForm");
    
    if(penelitianModalInstance) {
        penelitianForm.reset();
        penelitianForm.action="/penelitian";
        document.getElementById("form-method-placeholder").innerHTML="";
        document.getElementById("penelitianModalLabel").innerHTML='<i class="fas fa-plus-circle"></i> Tambah Data Penelitian';
        penelitianForm.querySelector('button[type="submit"]').textContent="Simpan Data";
        resetPenulisFields();
        penelitianModalInstance.show();
    }
};
window.openEditModal=id=>{
    const penelitianModalEl = document.getElementById("penelitianModal");
    const penelitianModalInstance = penelitianModalEl ? new bootstrap.Modal(penelitianModalEl) : null;
    const penelitianForm = document.getElementById("penelitianForm");
    
    if(penelitianModalInstance) {
        fetch(`/penelitian/${id}/edit`).then(res => res.json()).then(data => {
            penelitianForm.reset();
            penelitianForm.action=`/penelitian/${id}`;
            document.getElementById("form-method-placeholder").innerHTML='<input type="hidden" name="_method" value="PATCH">';
            document.getElementById("penelitianModalLabel").innerHTML='<i class="fas fa-edit"></i> Edit Data Penelitian';
            penelitianForm.querySelector('button[type="submit"]').textContent="Update Data";
            populateForm(data);
            penelitianModalInstance.show();
        }).catch(err => console.error("Error fetching data for edit:", err));
    }
};
window.openDetailModal=id=>{
    const detailModalEl = document.getElementById("detailModal");
    const detailModalInstance = detailModalEl ? new bootstrap.Modal(detailModalEl) : null;

    if(detailModalInstance) {
        fetch(`/penelitian/${id}/edit`).then(res => res.json()).then(data => {
            populateDetailModal(data);
            detailModalInstance.show();
        }).catch(err => console.error("Error fetching detail data:", err));
    }
};

// ===================================================================================
// EKSEKUSI SETELAH HALAMAN SIAP (DOMContentLoaded)
// ===================================================================================
document.addEventListener("DOMContentLoaded", () => {
  // --- Inisialisasi Variabel Modal ---
  const modalKonfirmasiVerifikasi = document.getElementById('modalKonfirmasiVerifikasi');
  const konfirmasiHapusModal = document.querySelector('.konfirmasi-hapus-overlay');
  
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
  
  // --- Fungsi untuk mengisi Form Edit ---
  // (Fungsi ini hanya akan dipanggil oleh openEditModal yang sudah global)
  window.populateForm=function(data){
      const penelitianForm = document.getElementById("penelitianForm");
      penelitianForm.querySelector('[name="judul"]').value=data.judul;
      penelitianForm.querySelector('[name="jenis_karya"]').value=data.jenis_karya;
      penelitianForm.querySelector('[name="volume"]').value=data.volume;
      penelitianForm.querySelector('[name="jumlah_halaman"]').value=data.jumlah_halaman;
      penelitianForm.querySelector('[name="tanggal_terbit"]').value=data.tanggal_terbit?data.tanggal_terbit.substring(0,10):"";
      penelitianForm.querySelector('[name="publik"]').value=data.is_publik?"Ya":"Tidak";
      penelitianForm.querySelector('[name="isbn"]').value=data.isbn;
      penelitianForm.querySelector('[name="issn"]').value=data.issn;
      penelitianForm.querySelector('[name="doi"]').value=data.doi;
      penelitianForm.querySelector('[name="url"]').value=data.url;
      document.getElementById("penulis-ipb-list").innerHTML="";
      document.getElementById("penulis-luar-list").innerHTML="";
      document.getElementById("penulis-mahasiswa-list").innerHTML="";
      counters={ipb:0,luar:0,mahasiswa:0};
      
      if(data.penulis && data.penulis.length > 0) {
        data.penulis.forEach(p => {
            let type = p.tipe_penulis === "IPB" ? "ipb" : (p.tipe_penulis === "Luar IPB" ? "luar" : "mahasiswa");
            addPenulis(type);
            if (type === "ipb") {
                document.querySelector(`#penulis-ipb-list .input-group:last-child select`).value = p.pegawai_id;
            } else if (type === "luar") {
                document.querySelector(`#penulis-luar-list .input-group:last-child [name$="[nama]"]`).value = p.nama_penulis;
                document.querySelector(`#penulis-luar-list .input-group:last-child [name$="[afiliasi]"]`).value = p.afiliasi;
            } else {
                document.querySelector(`#penulis-mahasiswa-list .input-group:last-child input`).value = p.nama_penulis;
            }
        });
      }

      if(document.getElementById("penulis-ipb-list").innerHTML === "") addPenulis("ipb");
      if(document.getElementById("penulis-luar-list").innerHTML === "") addPenulis("luar");
      if(document.getElementById("penulis-mahasiswa-list").innerHTML === "") addPenulis("mahasiswa");
  }

  // --- Fungsi untuk mengisi Modal Detail ---
  // (Fungsi ini hanya akan dipanggil oleh openDetailModal yang sudah global)
  window.populateDetailModal=function(data) {
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
            tanggalTerbitEl.textContent = date.toLocaleDate-String('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
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
    
    ['ipb', 'luar', 'mahasiswa'].forEach(type => {
        document.getElementById(`detail-penulis-${type}-section`).style.display = 'none';
        document.getElementById(`detail-penulis-${type}-list`).innerHTML = '';
    });

    if (data.penulis && data.penulis.length > 0) {
        data.penulis.forEach(p => {
            let type, content = '', namaPenulisHtml = '', skLinkHtml = '';

            if (p.tipe_penulis === 'IPB') {
                type = 'ipb';
                namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Penulis</small><p>${p.pegawai.nama_lengkap}</p></div>`;
            } else if (p.tipe_penulis === 'Luar IPB') {
                type = 'luar';
                namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Penulis</small><p>${p.nama_penulis} (${p.afiliasi || 'Tidak ada afiliasi'})</p></div>`;
            } else {
                type = 'mahasiswa';
                namaPenulisHtml = `<div class="detail-item" style="border:none; padding:0;"><small>Nama Mahasiswa</small><p>${p.nama_penulis}</p></div>`;
            }
            
            if (p.sk_penugasan_path) {
                skLinkHtml = `<div class="detail-item" style="border:none; padding:0;"><small>SK Penugasan</small><p><a href="/storage/${p.sk_penugasan_path}" target="_blank">Lihat SK</a></p></div>`;
            } else if (p.tipe_penulis !== 'Mahasiswa') {
                skLinkHtml = '<div></div>';
            }

            content = `<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; width: 100%; border-bottom: 1px solid #e9ecef; margin-bottom: 1rem; padding-bottom: 1rem;">${namaPenulisHtml}${skLinkHtml}</div>`;
            
            document.getElementById(`detail-penulis-${type}-section`).style.display = 'block';
            const listContainer = document.getElementById(`detail-penulis-${type}-list`);
            listContainer.style.display = 'block';
            listContainer.insertAdjacentHTML('beforeend', content);
        });
    }
  }

  // --- Event listener untuk tombol Selesai di modal sukses ---
  document.getElementById("btnSelesai")?.addEventListener("click", () => {
      document.getElementById("modalBerhasil")?.classList.remove("show");
      location.reload();
  });

  // --- Penanganan event klik terpusat untuk aksi di tabel dan modal---
  document.addEventListener('click', function(e) {
    if (e.target.closest('.konfirmasi-hapus-overlay')) {
        const clickedButtonInHapusModal = e.target.closest('.btn-popup');
        if (clickedButtonInHapusModal) {
            if (clickedButtonInHapusModal.classList.contains('btn-hapus')) {
                sendHapusRequest();
            } else if (clickedButtonInHapusModal.classList.contains('btn-batal')) {
                konfirmasiHapusModal.classList.remove('show');
            }
        }
        return;
    }
    
    if (e.target.closest('#modalKonfirmasiVerifikasi')) {
        const clickedButtonInVerifModal = e.target.closest('.btn-popup');
        if (clickedButtonInVerifModal) {
            const buttonId = clickedButtonInVerifModal.id;
            if (buttonId === 'popupBtnTerima') { sendVerifikasiRequest('Sudah Diverifikasi'); } 
            else if (buttonId === 'popupBtnTolak') { sendVerifikasiRequest('Ditolak'); } 
            else if (buttonId === 'popupBtnKembali') { modalKonfirmasiVerifikasi.classList.remove('show'); }
        }
        return;
    }

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

  // --- Fungsi untuk Filter Otomatis ---
  const filterForm = document.getElementById('filter-form');
  if (filterForm) {
      const debounce = (func, delay) => {
          let timeoutId;
          const cancel = () => clearTimeout(timeoutId);
          const debounced = (...args) => {
              clearTimeout(timeoutId);
              timeoutId = setTimeout(() => {
                  func.apply(this, args);
              }, delay);
          };
          debounced.cancel = cancel;
          return debounced;
      };

      const debouncedSubmit = debounce(() => {
          filterForm.submit();
      }, 500);

      filterForm.querySelectorAll('.filter-select').forEach(select => {
          select.addEventListener('change', () => {
              filterForm.submit();
          });
      });

      const searchInput = filterForm.querySelector('.search-input');
      if (searchInput) {
          searchInput.addEventListener('keyup', (event) => {
              if (event.key === 'Enter') {
                  debouncedSubmit.cancel?.();
                  filterForm.submit();
              } else {
                  debouncedSubmit();
              }
          });
      }
  }
});