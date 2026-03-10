const API_RESOURCE = '/api/setoran';

function getToken() {
    return localStorage.getItem('jwt_token');
}

async function fetchWithAuth(url, options = {}) {
    const token = getToken();
    const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`,
        ...options.headers
    };
    const response = await fetch(url, { ...options, headers });
    if (response.status === 401) {
        window.location.href = '/login-vanilla';
        return;
    }
    return response;
}

async function loadAdminData() {
    const tbody = document.getElementById('admin-tbody');
    try {
        const res = await fetchWithAuth(API_RESOURCE);
        const result = await res.json();

        if (result.success) {
            tbody.innerHTML = '';
            result.data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.id}</td>
                    <td style="font-weight:700; color:var(--color-primary)">${row.kode_tiket}</td>
                    <td>${row.nama}</td>
                    <td>${row.jenis_sampah}</td>
                    <td>${row.berat} kg</td>
                    <td><span class="badge badge-${row.status.toLowerCase()}">${row.status}</span></td>
                    <td style="font-size:0.8rem">${new Date(row.created_at).toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="openEdit(${row.id}, '${row.status}')">✏️</button>
                        <button class="btn-action btn-delete" onclick="deleteData(${row.id})">🗑️</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    } catch (err) {
        tbody.innerHTML = '<tr><td colspan="8" style="color:red">Gagal memuat data.</td></tr>';
    }
}

function openEdit(id, status) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-status').value = status;
    document.getElementById('edit-modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('edit-modal').style.display = 'none';
}

async function saveStatus() {
    const id = document.getElementById('edit-id').value;
    const status = document.getElementById('edit-status').value;

    try {
        const res = await fetchWithAuth(`${API_RESOURCE}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        });
        const result = await res.json();
        if (result.success) {
            alert('✅ Status berhasil diperbarui');
            closeModal();
            loadAdminData();
        }
    } catch (err) {
        alert('❌ Gagal memperbarui status');
    }
}

async function deleteData(id) {
    if (!confirm('Hapus data ini secara permanen?')) return;
    try {
        const res = await fetchWithAuth(`${API_RESOURCE}/${id}`, { method: 'DELETE' });
        const result = await res.json();
        if (result.success) {
            alert('✅ Data terhapus');
            loadAdminData();
        }
    } catch (err) {
        alert('❌ Gagal menghapus data');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (!getToken()) {
        window.location.href = '/login-vanilla';
    } else {
        loadAdminData();
    }
});
