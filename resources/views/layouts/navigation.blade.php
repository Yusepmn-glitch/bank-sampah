<nav class="navbar" id="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fffffe" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" />
                    <path d="M10 11v6M14 11v6" />
                </svg>
            </div>
            <div class="logo-text">
                Bank Sampah Desa
                <span>Sukaresik Digital</span>
            </div>
        </a>

        <ul class="navbar-nav" id="nav-menu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('home') }}#setor">Setor Sampah</a></li>
            <li><a href="{{ route('cek-status') }}" class="{{ request()->routeIs('cek-status') ? 'active' : '' }}">Cek Saldo</a></li>
            <li><a href="{{ route('admin.panel') }}" id="nav-item-admin" style="display: none;">Admin Panel</a></li>
            <li id="nav-item-logout" style="display: none;">
                <a href="#" id="btn-logout-vanilla">Logout</a>
            </li>
            <li id="nav-item-login">
                <a href="{{ route('login-vanilla') }}">Login</a>
            </li>
            <li id="nav-item-register">
                <a href="{{ route('register-vanilla') }}">Register</a>
            </li>
        </ul>

        <div class="nav-actions">
            <span id="user-greeting" style="margin-right: 15px; color: var(--text-headline); font-weight: 500; display: none;"></span>
            <a href="{{ route('login-vanilla') }}" class="btn btn-outline" id="action-login" style="margin-right: 10px;">Login</a>
            <a href="{{ route('register-vanilla') }}" class="btn btn-primary" id="action-register">Register</a>
            <button class="btn btn-primary" id="action-logout" style="display: none;">Logout</button>
        </div>

        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<script>
    function updateAuthUI() {
        const token = localStorage.getItem('jwt_token');
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        const loginItems = [document.getElementById('nav-item-login'), document.getElementById('nav-item-register'), document.getElementById('action-login'), document.getElementById('action-register')];
        const logoutItems = [document.getElementById('nav-item-logout'), document.getElementById('action-logout'), document.getElementById('user-greeting'), document.getElementById('nav-item-admin')];
        
        if (token) {
            loginItems.forEach(el => el && (el.style.display = 'none'));
            logoutItems.forEach(el => el && (el.style.display = 'inline-block'));
            if (document.getElementById('user-greeting')) {
                document.getElementById('user-greeting').textContent = `Halo, ${user.name || 'User'}!`;
            }
        } else {
            loginItems.forEach(el => el && (el.style.display = 'inline-block'));
            logoutItems.forEach(el => el && (el.style.display = 'none'));
        }
    }

    function logout() {
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user');
        window.location.href = '/login-vanilla';
    }

    document.getElementById('btn-logout-vanilla')?.addEventListener('click', (e) => {
        e.preventDefault();
        logout();
    });
    document.getElementById('action-logout')?.addEventListener('click', logout);

    document.addEventListener('DOMContentLoaded', updateAuthUI);
</script>
