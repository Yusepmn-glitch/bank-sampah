  <section class="section form-section" id="setor">
    <div class="container">

      <div class="form-info">
        <span class="section-label">Setor Sampah</span>
        <h2 class="section-title">Isi Form Setoran Online</h2>
        <p>Tidak perlu membuat akun. Isi form berikut, kode tiket setoran akan dikirim otomatis sebagai bukti dan untuk
          melacak status Anda.</p>

        <ul class="info-list">
          <li>
            <div class="il-icon">🎫</div>
            <div>
              <h4>Kode Tiket Otomatis</h4>
              <p>Sistem membuat kode tiket unik setiap kali Anda menyetor. Simpan kode ini untuk cek status.</p>
            </div>
          </li>
          <li>
            <div class="il-icon">🔒</div>
            <div>
              <h4>Data Aman &amp; Terenkripsi</h4>
              <p>Seluruh data dikirim dengan aman menggunakan PDO Prepared Statement anti SQL Injection.</p>
            </div>
          </li>
          <li>
            <div class="il-icon">📱</div>
            <div>
              <h4>Cek Status Kapan Saja</h4>
              <p>Gunakan kode tiket Anda untuk memantau status setoran di halaman Cek Saldo Tabungan.</p>
            </div>
          </li>
        </ul>
      </div>

      <div>
        <div class="form-card">
          <form id="form-setoran" novalidate>

            <div class="form-group">
              <label for="nama">Nama Warga <span class="req">*</span></label>
              <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required
                autocomplete="name" />
            </div>

            <div class="form-group">
              <label for="jenis_sampah">Jenis Sampah <span class="req">*</span></label>
              <select id="jenis_sampah" name="jenis_sampah" required>
                <option value="">-- Pilih Jenis Sampah --</option>
                <option value="Plastik">🧴 Plastik</option>
                <option value="Kertas">📰 Kertas</option>
                <option value="Logam">🔩 Logam</option>
                <option value="Kaca">🪟 Kaca</option>
                <option value="Organik">🌿 Organik</option>
                <option value="Lainnya">📦 Lainnya</option>
              </select>
            </div>

            <div class="form-group">
              <label for="berat">Berat Sampah (kg) <span class="req">*</span></label>
              <input type="number" id="berat" name="berat" placeholder="Contoh: 2.5" step="0.01" min="0.01"
                max="9999.99" required />
            </div>

            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea id="keterangan" name="keterangan"
                placeholder="Deskripsi sampah, kondisi, atau catatan tambahan (opsional)"></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-submit" id="btn-submit">
              <span id="btn-text">Kirim Setoran</span>
              <div class="spinner" id="btn-spinner"></div>
            </button>

            <div class="alert alert-success" id="alert-success" role="alert"></div>
            <div class="alert alert-error" id="alert-error" role="alert"></div>

            <div class="ticket-box" id="ticket-box">
              <div>🎫 Kode Tiket Setoran Anda</div>
              <div class="ticket-code" id="ticket-code">—</div>
              <div class="ticket-note">Simpan kode ini! Gunakan untuk cek status setoran Anda.</div>
              <a href="{{ route('cek-status') }}" class="btn btn-outline"
                style="margin-top:14px;font-size:.88rem;padding:10px 20px;">
                Cek Status Sekarang →
              </a>
            </div>

          </form>
        </div>
      </div>

    </div>
  </section>
