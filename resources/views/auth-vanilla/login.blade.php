<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bank Sampah Desa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <div class="form-card" style="padding: 40px;">
            <div class="text-center" style="margin-bottom: 30px;">
                <h2 class="section-title">Login Warga/Admin</h2>
                <p>Masuk untuk mengelola setoran sampah Anda</p>
            </div>
            
            <form id="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="******" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-full" id="btn-login">
                    <span id="btn-text">Masuk</span>
                    <div class="spinner" id="btn-spinner"></div>
                </button>
                
                <div class="alert alert-error" id="login-alert-error" style="margin-top: 15px;"></div>
                
                <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                    Belum punya akun? <a href="{{ route('register-vanilla') }}" style="color: var(--color-primary);">Daftar di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const API_LOGIN = '/api/auth/login';
        
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-login');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            const alert = document.getElementById('login-alert-error');
            
            alert.classList.remove('show');
            btn.disabled = true;
            btnText.textContent = 'Memproses...';
            spinner.classList.add('active');
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch(API_LOGIN, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    localStorage.setItem('jwt_token', result.access_token);
                    localStorage.setItem('user', JSON.stringify(result.user));
                    window.location.href = '/';
                } else if (response.status === 422) {
                    let msg = '❌ Validasi Gagal: ' + Object.values(result.errors).flat().join(', ');
                    alert.textContent = msg;
                    alert.classList.add('show');
                } else {
                    alert.textContent = '❌ ' + (result.message || 'Email atau password salah.');
                    alert.classList.add('show');
                }
            } catch (err) {
                alert.textContent = '❌ Gagal terhubung ke server.';
                alert.classList.add('show');
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Masuk';
                spinner.classList.remove('active');
            }
        });
    </script>
</body>
</html>
