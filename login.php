<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Sekolah</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- GOOGLE FONTS (POPPINS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e0f2fe; /* Biru muda laut segar */
            font-family: 'Poppins', sans-serif;
            color: #334155;
        }

        /* KARTU LOGIN LUCU & HALUS */
        .login-card {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            border-radius: 24px !important;
            border: 2px solid #bae6fd !important;
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.15);
            padding: 40px 30px !important;
        }

        /* JUDUL LOGIN */
        .login-title {
            color: #0284c7;
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 0.5px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #0369a1;
            margin-top: -15px;
            margin-bottom: 25px;
            text-align: center;
        }

        /* LABEL FORM */
        .form-label {
            color: #0369a1 !important;
            font-weight: 600;
            font-size: 13px !important;
        }

        /* INPUT FORM */
        .form-control {
            border: 2px solid #bae6fd;
            border-radius: 12px;
            padding: 10px 14px;
            background-color: #f0f9ff;
            color: #334155;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
            background-color: #ffffff;
        }

        /* TOMBOL LOGIN */
        .btn-primary {
            background: linear-gradient(135deg, #38bdf8, #0284c7) !important;
            border: none !important;
            border-radius: 14px !important;
            padding: 11px !important;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.35);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0284c7, #0369a1) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.4);
        }

        /* LINK REGISTER */
        a.text-decoration-none {
            color: #0284c7;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        a.text-decoration-none:hover {
            color: #0369a1;
            text-decoration: underline !important;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="card shadow-sm login-card">
        <h3 class="text-center mb-2 login-title">🌊 Login 🐬</h3>
        <p class="login-subtitle">Silakan masuk ke akun Anda</p>

        <form action="aksi_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 my-2">Masuk ⚓</button>
        </form>

        <div class="text-center mt-4">
            <small class="text-muted">Belum memiliki akun? <a href="register.php" class="text-decoration-none">Register</a></small>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>