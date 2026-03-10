<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Bank Sampah Desa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container" style="max-width: 500px; margin-top: 50px;">
        <div class="form-card" style="padding: 40px;">
            <div class="text-center" style="margin-bottom: 30px;">
                <h2 class="section-title">Daftar Akun Baru</h2>
                <p>Mulai kelola sampah Anda secara digital</p>
            </div>
            
            <form id="register-form">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-full" id="btn-register">
                    <span id="btn-text">Daftar</span>
                    <div class="spinner" id="btn-spinner"></div>
                </button>
                
                <div class="alert alert-error" id="register-alert-error" style="margin-top: 15px;"></div>
                
                <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                    Sudah punya akun? <a href="{{ route('login-vanilla') }}" style="color: var(--color-primary);">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const API_REGISTER = '/api/auth/register';
        
        document.getElementById('register-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-register');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            const alert = document.getElementById('register-alert-error');
            
            alert.classList.remove('show');
            btn.disabled = true;
            btnText.textContent = 'Memproses...';
            spinner.classList.add('active');
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch(API_REGISTER, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    localStorage.setItem('jwt_token', result.token);
                    localStorage.setItem('user', JSON.stringify(result.data));
                    window.location.href = '/';
                } else if (response.status === 422) {
                    // Validation Errors
                    let errorHtml = '<strong>❌ Validasi Gagal:</strong><ul style="margin-top:5px; text-align:left;">';
                    for (const field in result.errors) {
                        result.errors[field].forEach(err => {
                            errorHtml += `<li>${err}</li>`;
                        });
                    }
                    errorHtml += '</ul>';
                    alert.innerHTML = errorHtml;
                    alert.classList.add('show');
                } else {
                    alert.textContent = '❌ ' + (result.message || 'Pendaftaran gagal.');
                    alert.classList.add('show');
                }
            } catch (err) {
                alert.textContent = '❌ Gagal terhubung ke server.';
                alert.classList.add('show');
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Daftar';
                spinner.classList.remove('active');
            }
        });
    </script>
</body>
</html>
