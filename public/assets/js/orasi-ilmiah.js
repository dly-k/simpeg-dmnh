document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById('modalDetailOrasiIlmiah');
  modal.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget; // Tombol yang diklik

    // Isi data ke detail modal
    document.getElementById('detail_orasi_pegawai').textContent = button.getAttribute('data-pegawai');
    document.getElementById('detail_orasi_litabmas').textContent = button.getAttribute('data-litabmas');
    document.getElementById('detail_orasi_kategori_pembicara').textContent = button.getAttribute('data-kategori');
    document.getElementById('detail_orasi_lingkup').textContent = button.getAttribute('data-lingkup');
    document.getElementById('detail_orasi_judul_makalah').textContent = button.getAttribute('data-judul');
    document.getElementById('detail_orasi_nama_pertemuan').textContent = button.getAttribute('data-pertemuan');
    document.getElementById('detail_orasi_penyelenggara').textContent = button.getAttribute('data-penyelenggara');
    document.getElementById('detail_orasi_tanggal_pelaksana').textContent = button.getAttribute('data-tanggal');
    document.getElementById('detail_orasi_bahasa').textContent = button.getAttribute('data-bahasa');

    // Bagian Dokumen
    document.getElementById('detail_orasi_jenis_dokumen').textContent = button.getAttribute('data-jenis-dokumen');
    document.getElementById('detail_orasi_nama_dokumen').textContent = button.getAttribute('data-nama-dokumen');
    document.getElementById('detail_orasi_nomor_dokumen').textContent = button.getAttribute('data-nomor-dokumen');

    let tautan = button.getAttribute('data-tautan');
    document.getElementById('detail_orasi_tautan').innerHTML = `<a href="${tautan}" target="_blank">${tautan}</a>`;

    // Viewer PDF
    let fileSrc = button.getAttribute('data-dokumen-src');
    document.getElementById('detail_orasi_document_viewer').setAttribute('src', fileSrc);
  });
});