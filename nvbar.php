<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? 'user';
$nama = $_SESSION['nama'] ?? 'admin';
$role = $_SESSION['role'] ?? '';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navbar SIPN</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        .navbar {
            background-color: #ffffff !important;
            border-bottom: 2px solid #bae6fd !important;
            box-shadow: 0 4px 20px rgba(56, 189, 248, 0.1);
            font-family: 'Poppins', sans-serif;
            padding: 12px 20px;
        }

        .navbar-brand {
            color: #0284c7 !important;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .navbar-brand:hover {
            color: #0369a1 !important;
        }

        .navbar-nav .nav-link {
            color: #334155 !important;
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #0284c7 !important;
            background-color: #e0f2fe;
        }

        .dropdown-menu {
            border: 2px solid #bae6fd;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(56, 189, 248, 0.15);
            padding: 8px;
            background-color: #ffffff;
        }

        .dropdown-item {
            color: #334155;
            font-weight: 500;
            border-radius: 10px;
            padding: 8px 14px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #e0f2fe;
            color: #0284c7;
            transform: translateX(3px);
        }

        .navbar form .form-control {
            border: 2px solid #bae6fd;
            border-radius: 12px;
            padding: 6px 14px;
            background-color: #f0f9ff;
            color: #334155;
            transition: all 0.3s ease;
        }

        .navbar form .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
            background-color: #ffffff;
        }

        .navbar form .btn-outline-success {
            border: 2px solid #38bdf8;
            color: #0284c7;
            background-color: #e0f2fe;
            border-radius: 12px;
            font-weight: 600;
            padding: 6px 16px;
            transition: all 0.2s ease;
        }

        .navbar form .btn-outline-success:hover {
            background-color: #38bdf8;
            color: #ffffff;
            border-color: #38bdf8;
            transform: translateY(-1px);
        }

        .dropdown-toggle.text-dark {
            color: #0c4a6e !important;
            font-weight: 600;
            background-color: #f0f9ff;
            border: 1.5px solid #bae6fd;
            border-radius: 14px;
            padding: 6px 14px !important;
        }

        .dropdown-toggle.text-dark:hover {
            background-color: #e0f2fe;
        }

        .navbar-toggler {
            border: 2px solid #bae6fd;
            border-radius: 10px;
            background-color: #f0f9ff;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        }

        @media (max-width: 991px) {
            .navbar form {
                margin-top: 10px;
            }

            .profile-area {
                margin-top: 12px;
                align-items: flex-start !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="dashboard.php">
                🌊 SIPN 🐬
            </a>

            <!-- Tombol menu HP -->
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Menu berdasarkan role -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="daftar_siswa.php">
                            Home
                        </a>
                    </li>

                    <?php if ($role === 'guru'): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="nilai_guru.php">
                                📚 Kelola Nilai
                            </a>
                        </li>

                    <?php elseif ($role === 'siswa'): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="nilai.php">
                                📖 Nilai Saya
                            </a>
                        </li>

                    <?php elseif ($role === 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="nilai.php">
                                📋 Nilai
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

                <!-- Pencarian dan profil -->
                <div class="d-flex align-items-center gap-3 profile-area">

                    <form class="d-flex" role="search" method="GET"
                        action="daftar_siswa.php">
                        <input class="form-control me-2"
                            type="search"
                            name="cari"
                            placeholder="Cari..."
                            aria-label="Cari">
                        <button class="btn btn-outline-success"
                            type="submit">
                            Cari
                        </button>
                    </form>

                    <!-- Dropdown profil -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-dark"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            ⚓ <?= htmlspecialchars($nama) ?>
                            (<?= htmlspecialchars($username) ?>)

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item" href="profil.php">
                                    👤 Profil
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="pengatur.php">
                                    ⚙️ Pengaturan
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider"
                                    style="border-color: #bae6fd;">
                            </li>

                            <li>
                                <a class="dropdown-item text-danger fw-semibold"
                                    href="logout.php">
                                    🚪 Logout
                                </a>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>