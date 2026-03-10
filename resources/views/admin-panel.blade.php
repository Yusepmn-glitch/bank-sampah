<x-app-layout>
    <div class="container" style="margin-top: 50px; margin-bottom: 100px;">
        <div class="text-center" style="margin-bottom: 40px;">
            <h1 class="section-title">Panel Admin Bank Sampah</h1>
            <p class="section-sub">Kelola data setoran sampah warga secara real-time</p>
        </div>

        <div class="riwayat-table-wrap">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Tiket</th>
                        <th>Nasabah</th>
                        <th>Jenis Sampah</th>
                        <th>Berat</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="admin-tbody">
                    <tr><td colspan="8" style="text-align:center;padding:50px;">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Editing (Simple Version) -->
    <div id="edit-modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div class="form-card" style="max-width:400px; margin: 100px auto; background:white;">
            <h3 style="margin-bottom:20px;">Ubah Status Setoran</h3>
            <input type="hidden" id="edit-id">
            <div class="form-group">
                <label>Pilih Status Baru</label>
                <select id="edit-status">
                    <option value="Menunggu">Menunggu</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="btn btn-primary" onclick="saveStatus()" style="flex:1;">Simpan</button>
                <button class="btn btn-outline" onclick="closeModal()" style="flex:1;">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</x-app-layout>
