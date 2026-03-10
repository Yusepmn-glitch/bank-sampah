const API_CEK = '/api/cek-status';

function getToken() {
    return localStorage.getItem('jwt_token');
}

async function fetchWithAuth(url, options = {}) {
    const token = getToken();
    const headers = {
        'Accept': 'application/json',
        'Authorization': token ? `Bearer ${token}` : '',
        'Content-Type': 'application/json',
        ...options.headers
    };

    const response = await fetch(url, { ...options, headers });
    
    if (response.status === 401) {
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user');
        window.location.href = '/login-vanilla';
        return;
    }
    
    return response;
}

const formCek = document.getElementById('form-cek');
const resultCard = document.getElementById('result-card');

if (formCek) {
    formCek.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!getToken()) {
            alert('Silakan login untuk mengecek status.');
            window.location.href = '/login-vanilla';
            return;
        }

        const inputKode = document.getElementById('kode_tiket');
        const kode = inputKode.value.trim();

        if (!kode) return;

        try {
            const response = await fetchWithAuth(API_CEK, {
                method: 'POST',
                body: JSON.stringify({ kode_tiket: kode })
            });

            const result = await response.json();

            if (response.ok && result.success) {
                const d = result.data;
                document.getElementById('res-kode').textContent = d.kode_tiket;
                document.getElementById('res-nama').textContent = d.nama;
                document.getElementById('res-jenis').textContent = d.jenis_sampah;
                document.getElementById('res-berat').textContent = d.berat + ' kg';
                document.getElementById('res-keterangan').textContent = d.keterangan || '–';

                const badgeEl = document.getElementById('res-status');
                badgeEl.textContent = d.status;
                badgeEl.className = 'badge badge-' + d.status.toLowerCase();

                resultCard.classList.add('show');
            } else {
                alert('❌ ' + (result.message || 'Data tidak ditemukan.'));
            }
        } catch (err) {
            alert('❌ Kesalahan koneksi.');
        }
    });
}
