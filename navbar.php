<?php
//if (session_status() === PHP_SESSION_NONE) {
    //session_start();
//}

$username = $_SESSION['username'] ?? 'user';
$nama = $_SESSION['nama'] ?? 'admin';
$role = $_SESSION['role'] ?? '';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latihan Navbar</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <!-- GOOGLE FONTS (POPPINS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* TEMA LAUT BIRU MUDA UNTUK NAVBAR */
        .navbar {
            background-color: #ffffff !important;
            border-bottom: 2px solid #bae6fd !important;
            box-shadow: 0 4px 20px rgba(56, 189, 248, 0.1);
            font-family: 'Poppins', sans-serif;
            padding: 12px 20px;
        }

        /* BRAND / LOGO */
        .navbar-brand {
            color: #0284c7 !important;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.5px;
        }

        .navbar-brand:hover {
            color: #0369a1 !important;
        }

        /* LINK NAVBAR */
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

        /* DROPDOWN MENU STYLE */
        .dropdown-menu {
            border: 2px solid #bae6fd;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(56, 189, 248, 0.15);
            padding: 8px;
            background-color: #ffffff;
            animation: fadeIn 0.2s ease;
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

        /* SEARCH INPUT */
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

        /* SEARCH BUTTON */
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

        /* PROFIL USER DI KANAN */
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

        /* TOGGLER MOBILE */
        .navbar-toggler {
            border: 2px solid #bae6fd;
            border-radius: 10px;
            background-color: #f0f9ff;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Brand / Logo -->
            <a class="navbar-brand fw-bold" href="#">🌊 Navbar 🐬</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menu Utama di Kiri -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_siswa.php">Home</a>
                    </li>

                    <!-- Dropdown User -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="tabel.php">Daftar User</a></li>
                            <li><a class="dropdown-item" href="seluruh.php">Daftar Seluruh</a></li>
                            <li><a class="dropdown-item" href="from1.php">Daftar Admin</a></li>
                            <li><a class="dropdown-item" href="from2.php">Daftar Siswa</a></li>
                            <li><a class="dropdown-item" href="from3.php">Daftar Guru</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Siswa -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Siswa
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="daftar_siswa.php">Daftar Siswa</a></li>
                            <li><a class="dropdown-item" href="from2.php">Tambah Siswa</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Guru -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Guru
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="daftar_guru.php">Daftar Guru</a></li>
                            <li><a class="dropdown-item" href="from3.php">Tambah Guru</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Mapel -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mapel
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="tambah_mapel.php">Daftar Mapel</a></li>
                            <li><a class="dropdown-item" href="mapel.php">Tambah Mapel</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Mengajar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mengajar
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Data Mengajar</a></li>
                        </ul>
                    </li>

                    <!-- Menu Dinamis Berdasarkan Role -->
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashbord_admin.php">Dashboard</a>
                        </li>
                    <?php elseif ($role === 'guru'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="nilai.php">Nilai</a>
                        </li>
                    <?php elseif ($role === 'siswa'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="nilai.php">Nilai Saya</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Form Pencarian & Profil di Kanan -->
                <div class="d-flex align-items-center gap-3">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Cari..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Cari</button>
                    </form>

                    <!-- Dropdown Profil / Admin -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ⚓ <?php echo htmlspecialchars($nama); ?> (<?php echo htmlspecialchars($username); ?>)
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profil.php">👤 Profil</a></li>
                            <li><a class="dropdown-item" href="pengatur.php">⚙️ Pengaturan</a></li>
                            <li><hr class="dropdown-divider" style="border-color: #bae6fd;"></li>
                            <li><a class="dropdown-item text-danger fw-semibold" href="logout.php">🚪 Logout</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gepN89oc7kPSqU42B9lrf2N2pxu7SgSGsV3R0Hj4VdQ0w5k3D3jWmE4bq6xPzQ" crossorigin="anonymous"></script>
</body>

</html>