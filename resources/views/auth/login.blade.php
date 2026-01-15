<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Monitoring Tenaga Kerja</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: #f5f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card-login {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, 0.1);
            background: white;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="card-login">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Selamat Datang! 👋</h4>
            <p class="text-muted">Silakan login ke akun Anda</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>{{ $errors->first() }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Pastikan Session message (sukses reset password) muncul disini --}}
        @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <small>{{ Session::get('message') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="admin@bpjsketenagakerjaan.go.id" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3 form-password-toggle">
                {{-- BAGIAN YANG DIRUBAH ADA DISINI --}}
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="{{ route('forget.password.get') }}">Lupa Password?</a>
                </div>
                {{-- END BAGIAN YANG DIRUBAH --}}

                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="············" required>
                    {{-- Ikon Mata (Toggle) --}}
                    <span class="input-group-text cursor-pointer" id="togglePassword">
                        <i class="bx bx-hide"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Log in</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Pastikan script jalan setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {

            const toggleIcon = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (toggleIcon && passwordInput) {
                toggleIcon.addEventListener('click', function(e) {
                    // Mencegah perilaku default (jika ada)
                    e.preventDefault();

                    // 1. Cek tipe saat ini (password atau text?)
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';

                    // 2. Ubah tipe input
                    passwordInput.setAttribute('type', type);

                    // 3. Ubah Ikon (Ganti class bx-hide ke bx-show)
                    const icon = this.querySelector('i');
                    if (type === 'text') {
                        icon.classList.remove('bx-hide');
                        icon.classList.add('bx-show');
                    } else {
                        icon.classList.remove('bx-show');
                        icon.classList.add('bx-hide');
                    }
                });
            } else {
                console.error("Element ID 'password' atau 'togglePassword' tidak ditemukan!");
            }
        });
    </script>
</body>

</html>