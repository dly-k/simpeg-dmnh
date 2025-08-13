// === Inisialisasi Setelah Halaman Dimuat ===
document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    startClock();
    initKerjasamaPage();
    initDeleteModal();
});

// === Logika Sidebar ===
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    if (toggleSidebarBtn && sidebar && overlay) {
        toggleSidebarBtn.addEventListener('click', function() {
            const isMobile = window.innerWidth <= 991;
            if (isMobile) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show', sidebar.classList.contains('show'));
            } else {
                sidebar.classList.toggle('hidden');
            }
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
}

// === Logika Jam & Tanggal ===
function startClock() {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    function updateTime() {
        if (!dateEl || !timeEl) return;
        
        const now = new Date();
        const dateOpts = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            timeZone: 'Asia/Jakarta' 
        };
        
        const timeOpts = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: false, 
            timeZone: 'Asia/Jakarta' 
        };

        dateEl.textContent = now.toLocaleDateString('id-ID', dateOpts);
        timeEl.textContent = now.toLocaleTimeString('id-ID', timeOpts).replace(/\./g, ':');
    }

    updateTime();
    setInterval(updateTime, 1000);
}

// === Data & Logika Halaman Kerjasama ===
const kerjasamaData = [
    { 
        id: 'mou001', 
        judul: 'Pengembangan Model Hutan Tanaman Cerdas Iklim', 
        mitra: 'Dinas Kehutanan Provinsi Jawa Barat', 
        noDoc: 'MoU/001/AI/24', 
        tglDoc: '2024-04-10', 
        tmt: '2024-05-01', 
        tst: '2025-05-01', 
        departemen: 'Manajemen Hutan', 
        ketua: 'Dr. Anton Jaya Puspita', 
        anggota: ['Dr. Budi Santoso', 'Ir. Rina Melati, M.Sc.'], 
        lokasi: 'Bogor', 
        dana: 150000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/example.pdf' 
    },
    { 
        id: 'mou002', 
        judul: 'Pengembangan Teknologi Irigasi Hemat Air', 
        mitra: 'Balai Besar Pengembangan Irigasi Nasional', 
        noDoc: 'MoU/002/TI/24', 
        tglDoc: '2024-06-12', 
        tmt: '2024-07-01', 
        tst: '2025-07-01', 
        departemen: 'Teknik Pertanian', 
        ketua: 'Prof. Sri Wahyuni', 
        anggota: ['Dr. Adi Nugroho', 'Ir. Ratna Dewi, M.Eng.'], 
        lokasi: 'Yogyakarta', 
        dana: 200000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/irigasi.pdf' 
    },
    { 
        id: 'mou003', 
        judul: 'Riset Inovasi Pupuk Organik Berbasis Limbah Pertanian', 
        mitra: 'PT Pupuk Nusantara', 
        noDoc: 'MoU/003/PO/24', 
        tglDoc: '2024-03-20', 
        tmt: '2024-04-01', 
        tst: '2025-04-01', 
        departemen: 'Agroteknologi', 
        ketua: 'Dr. Hendri Kusuma', 
        anggota: ['Ir. Lestari Anggraeni, M.Sc.', 'Dr. Surya Wijaya'], 
        lokasi: 'Surabaya', 
        dana: 175000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/pupuk.pdf' 
    },
    { 
        id: 'mou004', 
        judul: 'Program Peningkatan Produktivitas Kopi Arabika', 
        mitra: 'Asosiasi Petani Kopi Gayo', 
        noDoc: 'MoU/004/KOPI/24', 
        tglDoc: '2024-05-05', 
        tmt: '2024-06-01', 
        tst: '2025-06-01', 
        departemen: 'Agribisnis', 
        ketua: 'Dr. Rahmat Fauzi', 
        anggota: ['Dr. Laila Nurhasanah', 'Ir. Fajar Pratama, M.Sc.'], 
        lokasi: 'Aceh Tengah', 
        dana: 220000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/kopi.pdf' 
    },
    { 
        id: 'mou005', 
        judul: 'Pengembangan Sistem Pemantauan Kualitas Air Sungai', 
        mitra: 'Dinas Lingkungan Hidup Kota Bandung', 
        noDoc: 'MoU/005/AIR/24', 
        tglDoc: '2024-02-15', 
        tmt: '2024-03-01', 
        tst: '2025-03-01', 
        departemen: 'Teknik Lingkungan', 
        ketua: 'Prof. Bambang Sutopo', 
        anggota: ['Ir. Mega Putri, M.Eng.', 'Dr. Arif Wibowo'], 
        lokasi: 'Bandung', 
        dana: 195000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/air.pdf' 
    },
    { 
        id: 'mou006', 
        judul: 'Pengembangan Sistem Smart Greenhouse Berbasis IoT', 
        mitra: 'PT AgriTech Indonesia', 
        noDoc: 'MoU/006/SGH/24', 
        tglDoc: '2024-07-18', 
        tmt: '2024-08-01', 
        tst: '2025-08-01', 
        departemen: 'Teknologi Informasi', 
        ketua: 'Dr. Siti Maryam', 
        anggota: ['Dr. Agus Widodo', 'Ir. Nanda Fitria, M.Cs.'], 
        lokasi: 'Malang', 
        dana: 250000000, 
        jenis: 'MoU', 
        dokumen_path: 'assets/pdf/greenhouse.pdf' 
    }
];


function initKerjasamaPage() {
    renderKerjasamaTable();
    setupUploadArea();
    
    const kerjasamaModalEl = document.getElementById('kerjasamaModal');
    const tableBody = document.getElementById('kerjasamaTableBody');

    // Logika untuk Modal Tambah/Edit
    if (kerjasamaModalEl) {
        kerjasamaModalEl.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const modalTitle = kerjasamaModalEl.querySelector('.modal-title');
            const form = kerjasamaModalEl.querySelector('form');
            
            if (button && button.classList.contains('btn-edit-row')) {
                const itemId = button.dataset.id;
                const itemData = kerjasamaData.find(item => item.id === itemId);
                
                if (itemData) {
                    modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Kerjasama';
                    form.reset();
                    
                    // Isi form dengan data yang ada
                    for (const key in itemData) {
                        if (key !== 'anggota') {
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) input.value = itemData[key];
                        }
                    }
                    
                    setupAnggotaList(itemData.anggota || []);
                }
            } else {
                modalTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Kerjasama';
                form.reset();
                setupAnggotaList([]);
            }
            
            // Reset area upload
            const uploadArea = kerjasamaModalEl.querySelector('.upload-area');
            if (uploadArea && typeof uploadArea.reset === 'function') {
                uploadArea.reset();
            }
        });
    }

    // Event Delegation untuk tabel
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            const targetButton = e.target.closest('button.btn-aksi');
            if (!targetButton) return;

            const itemId = targetButton.dataset.id;
            const itemData = kerjasamaData.find(item => item.id === itemId);
            if (!itemData) return;

            // Tombol Lihat Detail
            if (targetButton.classList.contains('btn-lihat-detail')) {
                fillDetailModal(itemData);
            }
            
            // Tombol Hapus
            if (targetButton.classList.contains('btn-delete-row')) {
                e.preventDefault();
                showDeleteModal(itemData, targetButton.closest('tr'));
            }
        });
    }

    // Logika untuk Tambah/Hapus Anggota
    const anggotaListContainer = document.getElementById('anggota-list');
    if (anggotaListContainer) {
        anggotaListContainer.addEventListener('click', function(e) {
            const addButton = e.target.closest('.btn-add-anggota');
            const removeButton = e.target.closest('.btn-remove-anggota');

            if (addButton) {
                addAnggotaRow(addButton);
            }
            
            if (removeButton) {
                removeButton.parentElement.remove();
            }
        });
    }
}

function initDeleteModal() {
    const modal = document.getElementById('modalKonfirmasiHapus');
    const btnKonfirmasi = document.getElementById('btnKonfirmasiHapus');
    const btnBatal = document.getElementById('btnBatalHapus');

    let currentItemToDelete = null;
    let currentRowElement = null;

    // Fungsi untuk menampilkan modal hapus dengan animasi
    window.showDeleteModal = function(itemData, rowElement) {
        currentItemToDelete = itemData;
        currentRowElement = rowElement;

        if (modal) {
            // Pastikan modal terlihat dulu (display flex) tapi belum ada animasi
            modal.style.display = 'flex';

            // Sedikit delay supaya CSS transition bisa ke-trigger
            requestAnimationFrame(() => {
                modal.classList.add('show');
            });

            document.body.style.overflow = 'hidden';
        }
    };

    // Fungsi untuk menyembunyikan modal dengan animasi
    function hideDeleteModal() {
        if (modal) {
            // Hapus class show untuk memicu fade-out
            modal.classList.remove('show');

            // Tunggu transisi selesai sebelum benar-benar sembunyikan
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300); // sesuai transition: 0.3s di CSS
        }
        currentItemToDelete = null;
        currentRowElement = null;
    }

    // Event tombol konfirmasi hapus
    if (btnKonfirmasi) {
        btnKonfirmasi.addEventListener('click', function() {
            if (currentItemToDelete && currentRowElement) {
                currentRowElement.remove();
                showToast('success', `Data "${currentItemToDelete.judul}" berhasil dihapus`);
                hideDeleteModal();
            }
        });
    }

    // Event tombol batal
    if (btnBatal) {
        btnBatal.addEventListener('click', hideDeleteModal);
    }

    // Klik di luar modal untuk menutup
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideDeleteModal();
            }
        });
    }

    // Tekan ESC untuk menutup
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            hideDeleteModal();
        }
    });
}


// === Fungsi Helper ===

function renderKerjasamaTable() {
    const tableBody = document.getElementById('kerjasamaTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = kerjasamaData.map((item, index) => {
        const danaFormatted = new Intl.NumberFormat('id-ID', { 
            style: 'currency', 
            currency: 'IDR', 
            minimumFractionDigits: 0 
        }).format(item.dana);

        return `
        <tr>
            <td class="text-center">${index + 1}</td>
            <td class="text-start" style="min-width: 250px;">${item.judul}</td>
            <td class="text-start">${item.mitra}</td>
            <td class="text-center">${item.noDoc}</td>
            <td class="text-center">${formatDate(item.tglDoc)}</td>
            <td class="text-start">
                <b>Ketua:</b> ${item.ketua}<br>
                <b>Anggota:</b> ${item.anggota.join(', ')}
            </td>
            <td class="text-center">${item.lokasi}</td>
            <td class="text-end">${danaFormatted}</td>
            <td class="text-center"><span class="badge text-bg-light border">${item.jenis}</span></td>
            <td class="text-center">
                <a href="${item.dokumen_path || '#'}" target="_blank" class="btn btn-sm btn-info text-white">
                    Lihat
                </a>
            </td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-aksi btn-lihat-detail" 
                        data-id="${item.id}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalDetailKerjasama"
                        data-judul="${item.judul}"
                        data-mitra="${item.mitra}"
                        data-nodoc="${item.noDoc}"
                        data-tgldoc="${item.tglDoc}"
                        data-tmt="${item.tmt}"
                        data-tst="${item.tst}"
                        data-departemen="${item.departemen}"
                        data-lokasi="${item.lokasi}"
                        data-dana="${danaFormatted}"
                        data-jenis="${item.jenis}"
                        data-dokumen_path="${item.dokumen_path || ''}">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-aksi btn-edit-row" 
                        data-id="${item.id}" 
                        data-bs-toggle="modal" 
                        data-bs-target="#kerjasamaModal">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-aksi btn-delete-row" 
                        data-id="${item.id}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        `;
    }).join('');
}

function fillDetailModal(itemData) {
    const setText = (id, value) => {
        const element = document.getElementById(id);
        if (element) element.textContent = value || '-';
    };

    const danaFormatted = new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0 
    }).format(itemData.dana);

    setText('detail_kerjasama_judul', itemData.judul);
    setText('detail_kerjasama_mitra', itemData.mitra);
    setText('detail_kerjasama_no_dokumen', itemData.noDoc);
    setText('detail_kerjasama_tgl_dokumen', formatDate(itemData.tglDoc));
    setText('detail_kerjasama_tmt', formatDate(itemData.tmt));
    setText('detail_kerjasama_tst', formatDate(itemData.tst));
    setText('detail_kerjasama_departemen', itemData.departemen);
    setText('detail_ketua', itemData.ketua);
    
    const anggotaListEl = document.getElementById('detail_anggota_list');
    if (anggotaListEl) {
        anggotaListEl.innerHTML = itemData.anggota && itemData.anggota.length > 0 
            ? itemData.anggota.map(a => `<li>${a}</li>`).join('')
            : '<li>-</li>';
    }
    
    setText('detail_kerjasama_lokasi', itemData.lokasi);
    setText('detail_kerjasama_dana', danaFormatted);
    setText('detail_kerjasama_jenis', itemData.jenis);
    
    const docViewer = document.getElementById('detail_kerjasama_document_viewer');
    if (docViewer) docViewer.setAttribute('src', itemData.dokumen_path || '');
}

function setupAnggotaList(members = []) {
    const listContainer = document.getElementById('anggota-list');
    if (!listContainer) return;
    
    listContainer.innerHTML = '';
    members.forEach(member => {
        listContainer.appendChild(createAnggotaRow(member, false));
    });
    listContainer.appendChild(createAnggotaRow('', true));
}

function createAnggotaRow(name = '', isAdder = false) {
    const row = document.createElement('div');
    row.className = 'input-group mb-2';
    row.innerHTML = `
        <input type="text" class="form-control" placeholder="Nama Anggota" value="${name}">
        <button class="btn ${isAdder ? 'btn-outline-success btn-add-anggota' : 'btn-outline-danger btn-remove-anggota'}" type="button">
            ${isAdder ? '+' : '-'}
        </button>
    `;
    return row;
}

function addAnggotaRow(addButton) {
    const row = addButton.parentElement;
    const input = row.querySelector('input');
    
    if (input.value.trim() === '') {
        input.focus();
        return;
    }
    
    addButton.outerHTML = '<button class="btn btn-outline-danger btn-remove-anggota" type="button">-</button>';
    
    const listContainer = document.getElementById('anggota-list');
    if (listContainer) {
        listContainer.appendChild(createAnggotaRow('', true));
        listContainer.lastElementChild.querySelector('input').focus();
    }
}

function setupUploadArea() {
    document.querySelectorAll('.upload-area').forEach(uploadArea => {
        const fileInput = uploadArea.querySelector('input[type="file"]');
        const uploadText = uploadArea.querySelector('p');
        
        if (!fileInput || !uploadText) return;
        
        const originalText = uploadText.innerHTML;
        
        uploadArea.addEventListener('click', () => fileInput.click());
        
        fileInput.addEventListener('change', function() {
            uploadText.textContent = this.files.length > 0 
                ? this.files[0].name 
                : originalText;
        });
        
        uploadArea.reset = function() {
            uploadText.innerHTML = originalText;
            fileInput.value = '';
        };
    });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
}

function showToast(type, message) {
    // Implementasi toast notification sesuai library/framework yang digunakan
    console.log(`${type}: ${message}`);
    alert(message); // Fallback sederhana
}