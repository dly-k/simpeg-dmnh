document.getElementById('Lembaga_Sertifikasi').addEventListener('change', function() {
  const lainnyaInput = document.getElementById('Lembaga_Sertifikasi_Lainnya');
  if (this.value === 'lainnya') {
    lainnyaInput.style.display = 'block';
  } else {
    lainnyaInput.style.display = 'none';
    lainnyaInput.value = '';
  }
});

// == Peningkatan Datepicker ==
document.querySelectorAll('input[type="date"]').forEach((el) => {
    el.style.cursor = "pointer";
    el.addEventListener("click", function () {
    this.showPicker && this.showPicker();
    });
});

function toggleLainnyaEdit(select){
let input = document.getElementById("Edit_Lembaga_Sertifikasi_Lainnya");
if(select.value === "lainnya"){
    input.style.display = "block";
} else {
    input.style.display = "none";
}
}

document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modalDetailSertifikatKompetensi');
  
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    // Ambil data-* dari tombol
    const nama = button.getAttribute('data-nama');
    const kegiatan = button.getAttribute('data-kegiatan');
    const judul = button.getAttribute('data-judul');
    const noReg = button.getAttribute('data-no-reg');
    const noSk = button.getAttribute('data-no-sk');
    const tahun = button.getAttribute('data-tahun');
    const tmt = button.getAttribute('data-tmt');
    const tst = button.getAttribute('data-tst');
    const bidang = button.getAttribute('data-bidang');
    const lembaga = button.getAttribute('data-lembaga');
    const dokumen = button.getAttribute('data-dokumen');

    // Masukkan ke dalam modal
    modal.querySelector('#detail_sertifikat_nama').textContent = nama;
    modal.querySelector('#detail_sertifikat_kegiatan').textContent = kegiatan;
    modal.querySelector('#detail_sertifikat_judul').textContent = judul;
    modal.querySelector('#detail_sertifikat_no_reg').textContent = noReg;
    modal.querySelector('#detail_sertifikat_no_sk').textContent = noSk;
    modal.querySelector('#detail_sertifikat_tahun').textContent = tahun;
    modal.querySelector('#detail_sertifikat_tmt').textContent = tmt;
    modal.querySelector('#detail_sertifikat_tst').textContent = tst;
    modal.querySelector('#detail_sertifikat_bidang').textContent = bidang;
    modal.querySelector('#detail_sertifikat_lembaga').textContent = lembaga;

    // Dokumen viewer
    const viewer = modal.querySelector('#detail_sertifikat_document_viewer');
    viewer.src = dokumen || "";
  });
});