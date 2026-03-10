const API_RESOURCE = '/api/setoran';
const API_AUTH_ME = '/api/auth/me';

// Utility to get JWT Token
function getToken() {
    return localStorage.getItem('jwt_token');
}

const API_AUTH_REFRESH = '/api/auth/refresh';

// Global Fetch Wrapper with JWT
async function fetchWithAuth(url, options = {}) {
    let token = getToken();
    const headers = {
        'Accept': 'application/json',
        'Authorization': token ? `Bearer ${token}` : '',
        ...options.headers
    };

    let response = await fetch(url, { ...options, headers });
    
    // If 401 (Unauthorized), try to refresh token once
    if (response.status === 401 && !options._retry) {
        try {
            const refreshRes = await fetch(API_AUTH_REFRESH, {
                method: 'POST',
                headers: { 
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            const refreshData = await refreshRes.json();

            if (refreshRes.ok && refreshData.success) {
                // Save new token
                token = refreshData.access_token;
                localStorage.setItem('jwt_token', token);
                
                // Retry original request with new token
                return fetchWithAuth(url, { 
                    ...options, 
                    _retry: true, 
                    headers: { ...options.headers, 'Authorization': `Bearer ${token}` } 
                });
            }
        } catch (err) {
            console.error('Refresh token failed:', err);
        }

        // If refresh fails or not successful, logout
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user');
        window.location.href = '/login-vanilla';
        return;
    }
    
    return response;
}

async function fetchRiwayat() {
    const tbody = document.getElementById('riwayat-tbody');
    if (!tbody) return;

    try {
        const res = await fetchWithAuth(API_RESOURCE);
        if (!res) return;
        const result = await res.json();

        if (result.success && result.data.length > 0) {
            tbody.innerHTML = '';
            result.data.forEach(row => {
                const tr = document.createElement('tr');
                const waktu = new Date(row.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit'
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
                    <td><span class="badge badge-${row.status.toLowerCase()}">${row.status}</span></td>
                    <td style="font-size: .8rem">${waktu}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editSetoran(${row.id})">✏️</button>
                        <button class="btn-action btn-delete" onclick="deleteSetoran(${row.id})">🗑️</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:32px;">Data tidak ditemukan atau Anda perlu login.</td></tr>';
        }
    } catch (err) {
        console.error('Gagal memuat riwayat:', err);
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:32px;color:red;">Gagal memuat data.</td></tr>';
    }
}

async function deleteSetoran(id) {
    if (!confirm('Yakin ingin menghapus data ini?')) return;
    
    try {
        const res = await fetchWithAuth(`${API_RESOURCE}/${id}`, { method: 'DELETE' });
        const result = await res.json();
        if (result.success) {
            alert('✅ Berhasil dihapus');
            fetchRiwayat();
        } else {
            alert('❌ Gagal menghapus: ' + result.message);
        }
    } catch (err) {
        alert('❌ Terjadi kesalahan saat menghapus.');
    }
}

// Edit functionality would open a modal or populate the form
async function editSetoran(id) {
    // For simplicity in this demo, we'll just prompt for a new status
    const newStatus = prompt('Masukkan status baru (Menunggu, Diproses, Selesai, Ditolak):');
    if (!newStatus) return;
    
    try {
        const res = await fetchWithAuth(`${API_RESOURCE}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: newStatus })
        });
        const result = await res.json();
        if (result.success) {
            alert('✅ Berhasil diperbarui');
            fetchRiwayat();
        } else {
            alert('❌ Gagal memperbarui: ' + result.message);
        }
    } catch (err) {
        alert('❌ Terjadi kesalahan saat memperbarui.');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchRiwayat();
    
    // Auth Check for landing page actions
    const formSetoran = document.getElementById('form-setoran');
    if (formSetoran) {
        formSetoran.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!getToken()) {
                alert('Silakan login terlebih dahulu untuk menyetor sampah.');
                window.location.href = '/login-vanilla';
                return;
            }

            const btnSubmit = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            
            btnSubmit.disabled = true;
            btnText.textContent = 'Mengirim...';
            spinner.classList.add('active');

            const formData = new FormData(formSetoran);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetchWithAuth(API_RESOURCE, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert('✅ Setoran Berhasil! Kode Tiket: ' + result.data.kode_tiket);
                    formSetoran.reset();
                    fetchRiwayat();
                } else {
                    alert('❌ Gagal: ' + (result.message || 'Terjadi kesalahan.'));
                }
            } catch (err) {
                alert('❌ Kesalahan koneksi.');
            } finally {
                btnSubmit.disabled = false;
                btnText.textContent = 'Kirim Setoran';
                spinner.classList.remove('active');
            }
        });
    }
});
