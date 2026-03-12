<x-app-layout>
    <section class="section cek-hero">
        <div class="container">
            <div class="text-center" style="margin-bottom: 8px;">
                <span class="section-label">Cek Status</span>
                <h1 class="section-title">Cek Status Setoran &amp; Saldo</h1>
                <p class="section-sub">
                    Masukkan kode tiket setoran Anda untuk melihat status terkini dan
                    informasi tabungan sampah Anda.
                </p>
            </div>

            <div class="cek-form-wrap">
                <div class="form-card" style="background: var(--bg-card); border-radius: var(--radius-lg); padding: 36px; box-shadow: var(--shadow-md);">
                    <form id="form-cek" novalidate>
                        <div class="form-group">
                            <label for="kode_tiket">Kode Tiket Setoran</label>
                            <input type="text" id="kode_tiket" name="kode_tiket" placeholder="Contoh: TKT-2024-000001"
                                autocomplete="off" style="text-transform: uppercase; letter-spacing: .05em;" />
                        </div>

                        <button type="submit" class="btn btn-primary btn-submit" id="btn-cek">
                            <span id="btn-cek-text">Cek Status</span>
                            <div class="spinner" id="btn-cek-spinner"></div>
                        </button>

                        <div class="alert alert-error" id="cek-alert-error" role="alert"></div>
                    </form>

                    <div class="result-card" id="result-card">
                        <div class="result-header">
                            <div>
                                <div style="font-size:.78rem;color:var(--text-body);margin-bottom:4px;">KODE TIKET</div>
                                <div class="result-kode" id="res-kode">—</div>
                            </div>
                            <span class="badge" id="res-status">—</span>
                        </div>

                        <div class="result-grid">
                            <div class="result-item">
                                <label>Nama Warga</label>
                                <span id="res-nama">—</span>
                            </div>
                            <div class="result-item">
                                <label>Jenis Sampah</label>
                                <span id="res-jenis">—</span>
                            </div>
                            <div class="result-item">
                                <label>Berat Sampah</label>
                                <span id="res-berat">—</span>
                            </div>
                            <div class="result-item">
                                <label>Total Saldo (Berat)</label>
                                <span id="res-saldo" style="color: var(--color-primary); font-weight: bold;">—</span>
                            </div>
                            <div class="result-item">
                                <label>Waktu Setor</label>
                                <span id="res-created">—</span>
                            </div>
                            <div class="result-item" style="grid-column: 1 / -1;">
                                <label>Keterangan</label>
                                <span id="res-keterangan">—</span>
                            </div>
                        </div>

                        <div style="margin-top:24px; padding-top:20px; border-top:1px solid rgba(144,180,206,.25); text-align:center">
                            <p style="font-size:.85rem;color:var(--text-body);margin-bottom:12px;">
                                Ingin melakukan setoran baru?
                            </p>
                            <a href="{{ route('home') }}#setor" class="btn btn-primary" style="display:inline-flex;">
                                Setor Sampah Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <!-- Footer content if needed or use layout footer -->
    </footer>

    <script src="{{ asset('js/status.js') }}"></script>
</x-app-layout>
