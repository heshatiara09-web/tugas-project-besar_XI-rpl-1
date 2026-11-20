<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form3.php");
    exit;
}

// Ambil data dari form
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if ($username === '' || $password === '') {
    die("Username dan password wajib diisi.");
}

if (!in_array($role, ['admin', 'siswa', 'guru'], true)) {
    die("Role tidak valid.");
}

// Data khusus siswa dan guru
$nama_siswa = trim($_POST['nama_siswa'] ?? '');
$nis = trim($_POST['nis'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');

$nama_guru = trim($_POST['nama'] ?? '');
$nip = trim($_POST['nip'] ?? '');

$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';

if ($role === 'siswa') {
    if ($nama_siswa === '' || $nis === '' || $kelas === '') {
        die("nama_siswa, NIS, dan kelas wajib diisi.");
    }

    if (!in_array($jenis_kelamin, ['L', 'P'], true)) {
        die("Jenis kelamin tidak valid.");
    }
}

if ($role === 'guru') {
    if ($nama_guru === '' || $nip === '') {
        die("Nama guru dan NIP wajib diisi.");
    }

    if (!in_array($jenis_kelamin, ['L', 'P'], true)) {
        die("Jenis kelamin tidak valid.");
    }
}

// Cek username sudah digunakan atau belum
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id FROM users WHERE username = ?"
);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$hasil_username = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($hasil_username) > 0) {
    die("Username sudah digunakan. Silakan gunakan username lain.");
}
mysqli_stmt_close($stmt);

// Mulai transaksi agar data terkait tersimpan bersama
mysqli_begin_transaction($koneksi);

try {
    // Simpan akun ke tabel users
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO users (username, password, role)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $username,
        $password_hash,
        $role
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($koneksi));
    }

    $user_id = mysqli_insert_id($koneksi);
    mysqli_stmt_close($stmt);

    // Jika role siswa, simpan ke tabel siswa
    if ($role === 'siswa') {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO siswa
             (user_id, nama_siswa, nis, kelas, jenis_kelamin)
             VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "issss",
            $user_id,
            $nama_siswa,
            $nis,
            $kelas,
            $jenis_kelamin
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_close($stmt);
    }

    // Jika role guru, simpan ke tabel guru
    if ($role === 'guru') {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO guru
             (user_id, nama, nip, jenis_kelamin)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isss",
            $user_id,
            $nama_guru,
            $nip,
            $jenis_kelamin
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_error($koneksi));
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_commit($koneksi);

    // Arahkan ke halaman sesuai role
    if ($role === 'guru') {
        header("Location: tabel_guru.php");
    } elseif ($role === 'siswa') {
        header("Location: tabel.php");
    } else {
        header("Location:tabel.php");
    }

    exit;

} catch (Throwable $e) {
    mysqli_rollback($koneksi);

    die("Gagal menyimpan data: " . $e->getMessage());
}
?>