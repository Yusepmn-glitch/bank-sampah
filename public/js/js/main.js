const API_CREATE = '../api/create_setoran.php';
const API_RIWAYAT = '../api/get_riwayat.php';

async function fetchRiwayat() {
  const tbody = document.getElementById('riwayat-tbody');
  if (!tbody) return;

  try {
    const res = await fetch(API_RIWAYAT);
    const result = await res.json();

    if (result.success && result.data.length > 0) {
      tbody.innerHTML = '';
      result.data.forEach(row => {
        const tr = document.createElement('tr');


        const waktu = new Date(row.created_at).toLocaleDateString('id-ID', {
          day: '2-digit',
          month: 'short',
          hour: '2-digit',
          minute: '2-digit'
        });

        const emojiMap = {
          'Plastik': '🧴', 'Kertas': '📰', 'Logam': '🔩',
          'Kaca': '🪟', 'Organik': '🌿', 'Lainnya': '📦'
        };
        const emoji = emojiMap[row.jenis_sampah] || '🗑️';

        tr.innerHTML = `
          <td>${row.nama}</td>
          <td>${emoji} ${row.jenis_sampah}</td>
          <td>${parseFloat(row.berat).toFixed(2).replace('.', ',')} kg</td>
          <td>${row.keterangan || '—'}</td>
          <td><span class="badge badge-${row.status.toLowerCase()}">${row.status}</span></td>
          <td style="font-size: .8rem">${waktu}</td>
        `;
        tbody.appendChild(tr);
      });
    } else {
      tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:32px;color:var(--text-body)">Belum ada data setoran terbaru.</td></tr>';
    }
  } catch (err) {
    console.error('Gagal memuat riwayat:', err);
    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:32px;color:var(--color-danger)">Gagal memuat data riwayat.</td></tr>';
  }
}

document.addEventListener('DOMContentLoaded', fetchRiwayat);

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

if (hamburger && navMenu) {
  hamburger.addEventListener('click', () => {
    const isOpen = navMenu.style.display === 'flex';
    navMenu.style.display = isOpen ? 'none' : 'flex';
    navMenu.style.flexDirection = 'column';
    navMenu.style.position = 'absolute';
    navMenu.style.top = '68px';
    navMenu.style.left = '0';
    navMenu.style.right = '0';
    navMenu.style.background = '#fffffe';
    navMenu.style.padding = '16px 24px';
    navMenu.style.boxShadow = '0 6px 24px rgba(9,64,103,.12)';
    navMenu.style.gap = '8px';
  });
}

const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.navbar-nav a');

window.addEventListener('scroll', () => {
  const scrollY = window.scrollY + 80;
  sections.forEach(section => {
    const top = section.offsetTop;
    const height = section.offsetHeight;
    const id = section.getAttribute('id');
    if (scrollY >= top && scrollY < top + height) {
      navLinks.forEach(a => {
        a.classList.remove('active');
        if (a.getAttribute('href') === '#' + id) a.classList.add('active');
      });
    }
  });
});

function showAlert(elementId, message, show = true) {
  const el = document.getElementById(elementId);
  if (!el) return;
  if (show) {
    el.textContent = message;
    el.classList.add('show');
  } else {
    el.textContent = '';
    el.classList.remove('show');
  }
}

const formSetoran = document.getElementById('form-setoran');

if (formSetoran) {
  formSetoran.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const spinner = document.getElementById('btn-spinner');
    const ticketBox = document.getElementById('ticket-box');
    const ticketCode = document.getElementById('ticket-code');

    showAlert('alert-success', '', false);
    showAlert('alert-error', '', false);
    ticketBox.classList.remove('show');

    btnSubmit.disabled = true;
    btnText.textContent = 'Mengirim...';
    spinner.classList.add('active');

    const formData = new FormData(formSetoran);

    try {
      const response = await fetch(API_CREATE, {
        method: 'POST',
        body: formData,
      });

      const result = await response.json();

      if (response.ok && result.success) {
        showAlert('alert-success', '✅ ' + result.message);

        ticketCode.textContent = result.data.kode_tiket;
        ticketBox.classList.add('show');

        formSetoran.reset();

      } else {

        let pesan = result.message || 'Terjadi kesalahan. Coba lagi.';
        if (result.errors && result.errors.length > 0) {
          pesan += '\n• ' + result.errors.join('\n• ');
        }
        showAlert('alert-error', '❌ ' + pesan);
      }

    } catch (err) {

      showAlert('alert-error', '❌ Tidak dapat terhubung ke server. Pastikan koneksi internet Anda dan server berjalan.');
      console.error('Fetch error:', err);
    } finally {

      btnSubmit.disabled = false;
      btnText.textContent = 'Kirim Setoran';
      spinner.classList.remove('active');
    }
  });
}

function animateCounter(element, target, duration = 1800, prefix = '', suffix = '') {
  const start = 0;
  const startTime = performance.now();

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    // Easing: easeOutExpo
    const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
    const current = Math.round(start + (target - start) * eased);
    element.textContent = prefix + current.toLocaleString('id-ID') + suffix;
    if (progress < 1) requestAnimationFrame(update);
  }
  requestAnimationFrame(update);
}

// Jalankan counter saat elemen masuk viewport (Intersection Observer)
const statsObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      animateCounter(document.getElementById('stat-total-setoran'), 2480, 1800, '', '');
      animateCounter(document.getElementById('stat-daur'), 1240, 1800, '', '');
      animateCounter(document.getElementById('stat-penarikan'), 89, 1600, '', '');
      statsObserver.disconnect(); // Jalankan hanya sekali
    }
  });
}, { threshold: 0.3 });

const statsSection = document.querySelector('.stats-section');
if (statsSection) statsObserver.observe(statsSection);
