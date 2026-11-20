<?php
session_start();
require_once 'koneksi.php';

// 1. Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = (int) $_SESSION['id'];

// 2. Ambil data sesuai role
$query = "SELECT users.username, users.role,
                 siswa.nama_siswa AS nama,
                 siswa.nis AS nomor_induk,
                 siswa.kelas AS kelas
          FROM users
          INNER JOIN siswa ON siswa.user_id = users.id
          WHERE users.id = ? AND users.role = 'siswa'";

if (($_SESSION['role'] ?? '') === 'guru') {
    $query = "SELECT users.username, users.role,
                     guru.nama AS nama,
                     guru.nip AS nomor_induk,
                     NULL AS kelas
              FROM users
              INNER JOIN guru ON guru.user_id = users.id
              WHERE users.id = ? AND users.role = 'guru'";
}

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// 3. Pastikan data ditemukan
if (!$user) {
    die("Data profil tidak ditemukan. Periksa data akun dan tabel database.");
}

// 4. Inisial avatar
$inisial = strtoupper(
    substr(trim($user['nama'] ?? 'U'), 0, 1)
);

$role = $user['role'];
$isSiswa = ($role === 'siswa');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIPN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            background-color: #e0f2fe;
            font-family: 'Poppins', sans-serif;
            color: #334155;
            min-height: 100vh;
        }

        .profile-container {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .judul-wrapper {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul-halaman {
            font-size: 32px;
            font-weight: 700;
            color: #0284c7;
            margin: 0;
        }

        .sub-judul {
            font-size: 14px;
            color: #0369a1;
            margin-top: 4px;
        }

        .card-profile {
            background: #fff;
            border-radius: 24px;
            border: 2px solid #bae6fd;
            box-shadow: 0 10px 30px rgba(56,189,248,.15);
            padding: 35px 30px;
            transition: all .3s ease;
        }

        .avatar-box {
            position: relative;
            display: inline-block;
            margin-bottom: 12px;
        }

        .avatar-circle {
            width: 95px;
            height: 95px;
            background: linear-gradient(135deg,#38bdf8,#0284c7);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(56,189,248,.4);
            border: 4px solid #f0f9ff;
        }

        .avatar-badge-icon {
            position: absolute;
            bottom: 0;
            right: -5px;
            background: #e0f2fe;
            border: 2px solid #38bdf8;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .nama-user {
            font-size: 24px;
            font-weight: 700;
            color: #0c4a6e;
            margin-bottom: 6px;
        }

        .role-badge {
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid #7dd3fc;
            display: inline-block;
        }

        .divider-custom {
            border: 0;
            height: 2px;
            background: linear-gradient(
                to right,
                rgba(186,230,253,.1),
                #bae6fd,
                rgba(186,230,253,.1)
            );
            margin: 25px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box {
            background-color: #f0f9ff;
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid #e0f2fe;
            margin-bottom: 12px;
        }

        .info-label {
            color: #0284c7;
            font-weight: 500;
            font-size: 14px;
        }

        .info-value {
            color: #334155;
            font-weight: 600;
            font-size: 15px;
            overflow-wrap: anywhere;
        }

        .btn-kembali {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1.5px solid #7dd3fc;
            border-radius: 14px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-kembali:hover {
            background-color: #bae6fd;
            color: #0c4a6e;
        }

        .btn-edit {
            background: linear-gradient(135deg,#38bdf8,#0284c7);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(56,189,248,.35);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg,#0284c7,#0369a1);
            color: #fff;
        }

        @media (max-width: 576px) {
            .card-profile {
                padding: 25px 18px;
            }

            .info-box {
                padding: 12px 15px;
            }

            .nama-user {
                font-size: 20px;
            }

            .judul-halaman {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<?php include 'nvbar.php'; ?>

<div class="container profile-container">

    <div class="judul-wrapper">
        <h1 class="judul-halaman">🌊 Profil Saya 🐬</h1>
        <p class="sub-judul">
            Informasi akun dan data diri yang sedang login
        </p>
    </div>

    <div class="card-profile">

        <div class="text-center">
            <div class="avatar-box">
                <div class="avatar-circle">
                    <?= htmlspecialchars($inisial); ?>
                </div>
                <span class="avatar-badge-icon">⚓</span>
            </div>

            <h3 class="nama-user">
                <?= htmlspecialchars($user['nama']); ?>
            </h3>

            <span class="role-badge">
                ✨ <?= htmlspecialchars(ucfirst($role)); ?>
            </span>
        </div>

        <hr class="divider-custom">

        <div class="mb-4">
            <div class="section-title">
                <span>🔑</span> Informasi Akun
            </div>

            <div class="info-box">
                <div class="row align-items-center">
                    <div class="col-sm-4 info-label">Username</div>
                    <div class="col-sm-8 info-value">
                        <?= htmlspecialchars($user['username']); ?>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="row align-items-center">
                    <div class="col-sm-4 info-label">Role Akses</div>
                    <div class="col-sm-8 info-value">
                        <span class="badge text-bg-info text-white rounded-pill px-3 py-1">
                            <?= htmlspecialchars(ucfirst($role)); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="section-title">
                <span><?= $isSiswa ? '🎓' : '👨‍🏫' ?></span>
                <?= $isSiswa ? 'Data Siswa' : 'Data Guru' ?>
            </div>

            <div class="info-box">
                <div class="row align-items-center">
                    <div class="col-sm-4 info-label">Nama Lengkap</div>
                    <div class="col-sm-8 info-value">
                        <?= htmlspecialchars($user['nama']); ?>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="row align-items-center">
                    <div class="col-sm-4 info-label">
                        <?= $isSiswa ? 'NIS (Nomor Induk)' : 'NIP (Nomor Induk)' ?>
                    </div>
                    <div class="col-sm-8 info-value">
                        <?= htmlspecialchars($user['nomor_induk'] ?? '-'); ?>
                    </div>
                </div>
            </div>

            <?php if ($isSiswa): ?>
                <div class="info-box">
                    <div class="row align-items-center">
                        <div class="col-sm-4 info-label">Kelas</div>
                        <div class="col-sm-8 info-value">
                            <?= htmlspecialchars($user['kelas'] ?? '-'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-2 gap-2">
            <a href="dashboard.php"
               class="btn btn-kembali text-decoration-none">
                ❮ Kembali
            </a>

            <a href="pengatur.php"
               class="btn btn-edit text-decoration-none">
                ✏️ Edit Profil
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once 'footer.php'; ?>

</body>
</html>