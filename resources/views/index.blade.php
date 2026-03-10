<x-app-layout>
  <section class="hero" id="beranda">
    <div class="container">

      <div class="hero-content">
        <div class="hero-badge">
          <span class="dot"></span>
          Layanan Digital Aktif
        </div>

        <h1 class="hero-title">
          Kelola Sampah Jadi
          <span class="highlight">Tabungan</span>,<br>
          Mudah &amp; Bermanfaat
        </h1>

        <p class="hero-subtitle">
          Warga dapat menyetor sampah, mendapatkan saldo tabungan,
          dan memantau riwayat setoran secara online dari mana saja.
        </p>

        <div class="hero-actions">
          @guest
            <a href="{{ route('register-vanilla') }}" class="btn btn-primary">
              Mulai Menabung Sekarang
            </a>
            <a href="{{ route('login-vanilla') }}" class="btn btn-outline">
              Masuk ke Akun
            </a>
          @else
            <a href="#setor" class="btn btn-primary">
                Setor Sampah
            </a>
            <a href="{{ route('admin.panel') }}" class="btn btn-outline">
                Ke Dashboard Admin
            </a>
          @endguest
        </div>
      </div>

      <div class="hero-illustration">
        <!-- SVG content preserved from original design -->
        <div class="illus-bg">
          <div class="hero-float-card card-1">
            <div class="fc-icon" style="background:rgba(61,169,252,.15)">♻️</div>
            <div>
              <div style="font-size:.72rem;color:var(--text-body)">Total Didaur Ulang</div>
              <div>1.240 kg</div>
            </div>
          </div>
          <!-- SVG Illus Main -->
          <svg class="illus-main" viewBox="0 0 400 280" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="200" cy="260" rx="200" ry="30" fill="rgba(9,64,103,.07)" />
            <rect x="240" y="110" width="120" height="120" rx="4" fill="#fffffe" stroke="#90b4ce" stroke-width="1.5" />
            <polygon points="240,110 300,70 360,110" fill="#3da9fc" opacity=".85" />
            <rect x="266" y="170" width="30" height="60" rx="4" fill="#d8eefe" />
            <rect x="310" y="145" width="35" height="30" rx="3" fill="#d8eefe" />
            <rect x="255" y="120" width="90" height="20" rx="3" fill="#094067" />
            <text x="300" y="133" text-anchor="middle" fill="#fffffe" font-size="7" font-family="Inter,sans-serif" font-weight="700">BANK SAMPAH</text>
            <rect x="268" y="172" width="26" height="58" rx="3" fill="#094067" opacity=".8" />
            <circle cx="292" cy="201" r="2" fill="#3da9fc" />
            <rect x="40" y="185" width="28" height="45" rx="4" fill="#3da9fc" />
            <rect x="74" y="190" width="28" height="40" rx="4" fill="#90b4ce" />
            <rect x="108" y="195" width="28" height="35" rx="4" fill="#ef4565" opacity=".7" />
            <text x="54" y="238" text-anchor="middle" fill="#094067" font-size="6.5" font-family="Inter,sans-serif">Plastik</text>
            <text x="88" y="238" text-anchor="middle" fill="#094067" font-size="6.5" font-family="Inter,sans-serif">Kertas</text>
            <text x="122" y="238" text-anchor="middle" fill="#094067" font-size="6.5" font-family="Inter,sans-serif">Logam</text>
            <circle cx="160" cy="135" r="18" fill="#f2c14e" />
            <rect x="145" y="153" width="30" height="45" rx="8" fill="#3da9fc" />
            <line x1="145" y1="168" x2="125" y2="155" stroke="#3da9fc" stroke-width="10" stroke-linecap="round" />
            <ellipse cx="116" cy="150" rx="14" ry="16" fill="#d8eefe" stroke="#90b4ce" stroke-width="1.5" />
            <path d="M112 134 Q116 128 120 134" stroke="#90b4ce" stroke-width="1.5" stroke-linecap="round" />
            <line x1="152" y1="198" x2="148" y2="220" stroke="#094067" stroke-width="8" stroke-linecap="round" />
            <line x1="168" y1="198" x2="172" y2="220" stroke="#094067" stroke-width="8" stroke-linecap="round" />
            <circle cx="154" cy="130" r="2" fill="#094067" />
            <circle cx="166" cy="130" r="2" fill="#094067" />
            <path d="M154 140 Q160 145 166 140" stroke="#094067" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="220" cy="130" r="18" fill="#fdba74" />
            <rect x="205" y="148" width="30" height="45" rx="8" fill="#094067" />
            <rect x="232" y="155" width="18" height="22" rx="2" fill="#fffffe" stroke="#90b4ce" stroke-width="1" />
            <line x1="235" y1="161" x2="247" y2="161" stroke="#90b4ce" stroke-width="1" />
            <line x1="235" y1="165" x2="247" y2="165" stroke="#90b4ce" stroke-width="1" />
            <line x1="235" y1="169" x2="244" y2="169" stroke="#90b4ce" stroke-width="1" />
            <line x1="212" y1="193" x2="208" y2="220" stroke="#094067" stroke-width="8" stroke-linecap="round" />
            <line x1="228" y1="193" x2="232" y2="220" stroke="#094067" stroke-width="8" stroke-linecap="round" />
            <circle cx="214" cy="126" r="2" fill="#094067" />
            <circle cx="226" cy="126" r="2" fill="#094067" />
            <path d="M214 136 Q220 141 226 136" stroke="#094067" stroke-width="1.5" stroke-linecap="round" />
            <rect x="203" y="114" width="34" height="8" rx="3" fill="#094067" />
            <rect x="207" y="108" width="26" height="8" rx="3" fill="#094067" />
            <path d="M178 162 Q192 172 202 162" stroke="#3da9fc" stroke-width="2" stroke-dasharray="4 3" stroke-linecap="round" fill="none" />
            <polygon points="202,158 208,165 196,165" fill="#3da9fc" />
            <circle cx="368" cy="165" r="22" fill="rgba(52,199,89,.3)" />
            <circle cx="355" cy="175" r="16" fill="rgba(52,199,89,.35)" />
            <rect x="360" y="187" width="8" height="23" rx="3" fill="#6b7280" />
          </svg>
          <div class="hero-float-card card-2">
            <div class="fc-icon" style="background:rgba(52,199,89,.15)">✅</div>
            <div>
              <div style="font-size:.72rem;color:var(--text-body)">Tiket Berhasil</div>
              <div style="color:#3da9fc">TKT-2024-000042</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Other sections preserved -->
  @include('sections.panduan')
  @include('sections.stats')
  @include('sections.setor')
  @include('sections.riwayat')

  <footer class="footer" id="kontak">
    <!-- Footer content preserved -->
  </footer>
</x-app-layout>
