const API_CEK = '../api/cek_status.php';

const statusBadgeMap = {
    'Menunggu': 'badge-menunggu',
    'Diproses': 'badge-diproses',
    'Selesai': 'badge-selesai',
    'Ditolak': 'badge-ditolak',
};

function getBadgeClass(status) {
    return statusBadgeMap[status] || 'badge-menunggu';
}

function formatTanggal(datetimeStr) {
    if (!datetimeStr) return '–';
    const date = new Date(datetimeStr);
    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}

function showAlert(id, message, show = true) {
    const el = document.getElementById(id);
    if (!el) return;
    if (show) {
        el.textContent = message;
        el.classList.add('show');
    } else {
        el.textContent = '';
        el.classList.remove('show');
    }
}

const formCek = document.getElementById('form-cek');
const resultCard = document.getElementById('result-card');

if (formCek) {
    formCek.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btnCek = document.getElementById('btn-cek');
        const btnText = document.getElementById('btn-cek-text');
        const spinner = document.getElementById('btn-cek-spinner');
        const inputKode = document.getElementById('kode_tiket');

        const kode = inputKode.value.trim();

        // Sembunyikan alert dan result sebelumnya
        showAlert('cek-alert-error', '', false);
        resultCard.classList.remove('show');

        // Validasi sederhana di sisi client
        if (!kode) {
            showAlert('cek-alert-error', '❌ Kode tiket wajib diisi.');
            inputKode.focus();
            return;
        }

        // Loading state
        btnCek.disabled = true;
        btnText.textContent = 'Mencari...';
        spinner.classList.add('active');

        try {
            // Kirim request GET ke API PHP dengan query string
            const url = `${API_CEK}?kode_tiket=${encodeURIComponent(kode)}`;
            const response = await fetch(url, { method: 'GET' });
            const result = await response.json();

            if (response.ok && result.success) {
                // ✅ Data ditemukan – tampilkan result card
                const d = result.data;

                document.getElementById('res-kode').textContent = d.kode_tiket;
                document.getElementById('res-nama').textContent = d.nama;
                document.getElementById('res-jenis').textContent = d.jenis_sampah;
                document.getElementById('res-berat').textContent = d.berat + ' kg';
                document.getElementById('res-keterangan').textContent = d.keterangan || '–';
                document.getElementById('res-created').textContent = formatTanggal(d.created_at);

                // Render badge status
                const badgeEl = document.getElementById('res-status');
                badgeEl.textContent = d.status;
                badgeEl.className = 'badge ' + getBadgeClass(d.status);

                resultCard.classList.add('show');

            } else if (response.status === 404) {
                // ❌ Kode tiket tidak ditemukan
                showAlert('cek-alert-error', '❌ Kode tiket tidak ditemukan. Periksa kembali kode tiket Anda.');
            } else {
                // ❌ Error lainnya
                showAlert('cek-alert-error', '❌ ' + (result.message || 'Terjadi kesalahan.'));
            }

        } catch (err) {
            showAlert('cek-alert-error', '❌ Tidak dapat terhubung ke server. Pastikan server berjalan.');
            console.error('Fetch error:', err);
        } finally {
            btnCek.disabled = false;
            btnText.textContent = 'Cek Status';
            spinner.classList.remove('active');
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const kodeParam = params.get('kode');
    const inputKode = document.getElementById('kode_tiket');
    if (kodeParam && inputKode) {
        inputKode.value = kodeParam;

        document.getElementById('form-cek')?.dispatchEvent(new Event('submit'));
    }
});
