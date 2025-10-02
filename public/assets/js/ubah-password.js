document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("ubahPasswordForm");
  const modalElement = document.getElementById("modalBerhasil");

  // Hentikan eksekusi jika elemen penting tidak ditemukan
  if (!form || !modalElement) {
    console.error("Formulir atau elemen modal tidak ditemukan. Skrip dihentikan.");
    return;
  }

  // Custom modal handler since it's not a Bootstrap modal
  const successModal = {
    show: () => modalElement.classList.add('show'),
    hide: () => modalElement.classList.remove('show')
  };

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...`;
    
    // Hapus semua pesan error sebelumnya
    form.querySelectorAll('.error-message').forEach(el => el.innerHTML = '');
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    const formData = new FormData(form);
    const csrfToken = formData.get('_token');
    let response;

    try {
      response = await fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {
          "X-CSRF-TOKEN": csrfToken,
          "Accept": "application/json",
        },
      });

      if (response.ok) {
        // ---- ALUR SUKSES ----
        document.getElementById("berhasil-title").textContent = "Perubahan Berhasil";
        document.getElementById("berhasil-subtitle").textContent = "Password Anda telah berhasil diperbarui.";
        
        successModal.show();
        
        const successAudio = new Audio("/assets/sounds/success.mp3");
        successAudio.play().catch(e => console.warn("Gagal memutar suara:", e));
        
        form.reset();

        // Tunggu 1 detik lalu paksa logout
        setTimeout(() => {
          const logoutForm = document.createElement('form');
          logoutForm.method = 'POST';
          logoutForm.action = '/logout';
          logoutForm.innerHTML = `<input type="hidden" name="_token" value="${csrfToken}">`;
          document.body.appendChild(logoutForm);
          logoutForm.submit();
        }, 1000);

      } else if (response.status === 422) {
        // ---- ALUR VALIDASI GAGAL ----
        const data = await response.json();
        Object.keys(data.errors).forEach(key => {
          const input = form.querySelector(`[name="${key}"]`);
          if (input) {
            input.classList.add('is-invalid');
            const errorDiv = document.getElementById(`${input.id}-error`);
            if (errorDiv) {
              errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${data.errors[key][0]}`;
            }
          }
        });
      } else {
        throw new Error('Server merespons dengan status error.');
      }
    } catch (error) {
      console.error("Fetch error:", error);
      alert("Tidak dapat terhubung ke server. Periksa koneksi internet Anda.");
    } finally {
      // Aktifkan kembali tombol HANYA jika terjadi kegagalan
      if (!response || !response.ok) {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
      }
    }
  });
});
