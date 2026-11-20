<?php
session_start();
include 'koneksi.php';

// Cek login siswa
if (!isset($_SESSION['id']) || ($_SESSION['role'] ?? '') !== 'siswa') {
    header("Location: login.php");
    exit;
}

$cari = $_GET['cari'] ?? '';

// Ambil data siswa
$sql = "SELECT
            u.username,
            u.role,
            s.nama_siswa,
            s.kelas
        FROM users u
        INNER JOIN siswa s ON s.user_id = u.id
        WHERE u.role = 'siswa'
          AND s.kelas = 'XI RPL 1'
          AND (u.username LIKE ? OR s.nama_siswa LIKE ?)
        ORDER BY s.nama_siswa ASC";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    die("Query error: " . mysqli_error($koneksi));
}

$keyword = "%$cari%";

mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Panggil navbar milik guru
include 'nvbar.php';
?>

<?php require 'footer.php'; ?>