<?php
session_start();

// 1. Koneksi database
$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_siacad_smk"
);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. Cek login
if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location='login.php';
    </script>";
    exit;
}

$username_login = $_SESSION['username'];
$role = $_SESSION['role'] ?? '';

// 3. Ambil data berdasarkan role
if ($role === 'siswa') {
    $sql = "SELECT siswa.*, users.username
            FROM siswa
            JOIN users ON siswa.user_id = users.id
            WHERE users.username = ?";

} elseif ($role === 'guru') {
    $sql = "SELECT guru.*, users.username
            FROM guru
            JOIN users ON guru.user_id = users.id
            WHERE users.username = ?";

} else {
    die("Halaman ini khusus siswa dan guru.");
}

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $username_login);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Data profil tidak ditemukan di database.");
}

$pesan = "";

// 4. Proses simpan
if (isset($_POST['simpan'])) {
    $username_baru = trim($_POST['username']);
    $password_baru = $_POST['password'];

    if ($username_baru === '') {
        $pesan = "Username tidak boleh kosong!";
    } else {
        // Cek username sudah digunakan akun lain atau belum
        $cek = mysqli_prepare(
            $koneksi,
            "SELECT id FROM users
             WHERE username = ? AND id != ?"
        );

        mysqli_stmt_bind_param(
            $cek,
            "si",
            $username_baru,
            $user['user_id']
        );

        mysqli_stmt_execute($cek);
        $hasil_cek = mysqli_stmt_get_result($cek);

        if (mysqli_num_rows($hasil_cek) > 0) {
            $pesan = "Username sudah digunakan!";
        } else {
            // Update data profil sesuai role
            if ($role === 'siswa') {
                $nis = $user['nis'];
                $nama = trim($_POST['nama_siswa']);
                $kelas = trim($_POST['kelas']);
                $jk = $_POST['jenis_kelamin'];

                $update = mysqli_prepare(
                    $koneksi,
                    "UPDATE siswa
                     SET nama_siswa = ?, kelas = ?,
                         jenis_kelamin = ?
                     WHERE nis = ? AND user_id = ?"
                );

                mysqli_stmt_bind_param(
                    $update,
                    "ssssi",
                    $nama,
                    $kelas,
                    $jk,
                    $nis,
                    $user['user_id']
                );

            } else {
                $nip = $user['nip'];
                $nama = trim($_POST['nama_guru']);
                $jk = $_POST['jenis_kelamin'];

                $update = mysqli_prepare(
                    $koneksi,
                    "UPDATE guru
                     SET nama = ?, jenis_kelamin = ?
                     WHERE nip = ? AND user_id = ?"
                );

                mysqli_stmt_bind_param(
                    $update,
                    "sssi",
                    $nama,
                    $jk,
                    $nip,
                    $user['user_id']
                );
            }

            if (mysqli_stmt_execute($update)) {
                // Update username dan password akun
                if ($password_baru !== '') {
                    $password_hash = password_hash(
                        $password_baru,
                        PASSWORD_DEFAULT
                    );

                    $akun = mysqli_prepare(
                        $koneksi,
                        "UPDATE users
                         SET username = ?, password = ?
                         WHERE id = ?"
                    );

                    mysqli_stmt_bind_param(
                        $akun,
                        "ssi",
                        $username_baru,
                        $password_hash,
                        $user['user_id']
                    );
                } else {
                    $akun = mysqli_prepare(
                        $koneksi,
                        "UPDATE users
                         SET username = ?
                         WHERE id = ?"
                    );

                    mysqli_stmt_bind_param(
                        $akun,
                        "si",
                        $username_baru,
                        $user['user_id']
                    );
                }

                if (mysqli_stmt_execute($akun)) {
                    $_SESSION['username'] = $username_baru;

                    echo "<script>
                        alert('Data berhasil diperbarui!');
                        window.location='pengatur.php';
                    </script>";
                    exit;
                } else {
                    $pesan = "Gagal memperbarui akun.";
                }
            } else {
                $pesan = "Gagal memperbarui profil.";
            }
        }
    }

    // Pertahankan username dan isi form setelah gagal
    if ($pesan !== '') {
        $user['username'] = $username_baru;

        if ($role === 'siswa') {
            $user['nama_siswa'] = $_POST['nama_siswa'];
            $user['kelas'] = $_POST['kelas'];
        } else {
            $user['nama'] = $_POST['nama_guru'];
        }

        $user['jenis_kelamin'] = $_POST['jenis_kelamin'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pengaturan Akun - SIPN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0f2fe;
            margin: 0;
            padding: 0 0 40px;
            color: #334155;
        }

        .container {
            max-width: 700px;
            background: #fff;
            margin: 35px auto;
            border: 2px solid #bae6fd;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(56,189,248,.15);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg,#f0f9ff,#e0f2fe);
            padding: 20px 25px;
            border-bottom: 2px solid #bae6fd;
            font-size: 20px;
            font-weight: 700;
            color: #0284c7;
            text-align: center;
        }

        .form-body {
            padding: 30px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0369a1;
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 2px dashed #bae6fd;
            padding-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #0284c7;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #bae6fd;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 14px;
            background-color: #f0f9ff;
            color: #334155;
        }

        .form-control:focus {
            border-color: #38bdf8;
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(56,189,248,.25);
        }

        .form-control[readonly] {
            background-color: #e2e8f0;
            border-color: #cbd5e1;
        }

        .radio-group {
            margin-top: 8px;
            background-color: #f0f9ff;
            border: 2px solid #bae6fd;
            padding: 10px 14px;
            border-radius: 12px;
        }

        .radio-group label {
            display: inline-block;
            margin-right: 20px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
        }

        .radio-group input {
            accent-color: #0284c7;
            margin-right: 5px;
        }

        .btn-container {
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 11px 22px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg,#38bdf8,#0284c7);
            color: #fff;
            flex: 1;
        }

        .btn-secondary {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1.5px solid #7dd3fc;
        }

        @media (max-width: 768px) {
            .container {
                width: 92%;
                margin: 20px auto;
            }

            .form-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<?php include 'nvbar.php'; ?>

<div class="container">
    <div class="form-header">
        ⚙️ Pengaturan Akun
        (<?= $role === 'siswa' ? 'Siswa' : 'Guru' ?>)
    </div>

    <div class="form-body">

        <?php if ($pesan !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="section-title">
                👤 Data Profil User
            </div>

            <?php if ($role === 'siswa'): ?>

                <div class="mb-3">
                    <label>NIS:</label>
                    <input type="text" class="form-control"
                           value="<?= htmlspecialchars($user['nis']) ?>"
                           readonly>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_siswa"
                           class="form-control"
                           value="<?= htmlspecialchars($user['nama_siswa']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Kelas:</label>
                    <input type="text" name="kelas"
                           class="form-control"
                           value="<?= htmlspecialchars($user['kelas']) ?>"
                           required>
                </div>

            <?php else: ?>

                <div class="mb-3">
                    <label>NIP:</label>
                    <input type="text" class="form-control"
                           value="<?= htmlspecialchars($user['nip']) ?>"
                           readonly>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_guru"
                           class="form-control"
                           value="<?= htmlspecialchars($user['nama']) ?>"
                           required>
                </div>

            <?php endif; ?>

            <div class="mb-3">
                <label>Jenis Kelamin:</label>

                <div class="radio-group">
                    <label>
                        <input type="radio"
                               name="jenis_kelamin" value="L"
                            <?= $user['jenis_kelamin'] === 'L'
                                ? 'checked' : '' ?>>
                        Laki-laki
                    </label>

                    <label>
                        <input type="radio"
                               name="jenis_kelamin" value="P"
                            <?= $user['jenis_kelamin'] === 'P'
                                ? 'checked' : '' ?>>
                        Perempuan
                    </label>
                </div>
            </div>

            <div class="section-title">
                🔑 Data Kredensial Akun
            </div>

            <div class="mb-3">
                <label>Username:</label>
                <input type="text" name="username"
                       class="form-control"
                       value="<?= htmlspecialchars($user['username']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Password Baru:</label>
                <input type="password" name="password"
                       class="form-control"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>

            <div class="btn-container">
                <a href="dashboard.php"
                   class="btn btn-secondary">
                    ❮ Kembali
                </a>

                <button type="submit" name="simpan"
                        class="btn btn-primary">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>

</body>
</html>