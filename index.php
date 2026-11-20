<?php
session_start();

// jika BELUM login, tendang ke login.php
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
} 

// ambil role user yang akan login 
$role = $_SESSION['role'] ?? '';

// cek role user kemudian arahkan ke halaman sesuai role
switch ($role) {
    case 'admin' :
        header("Location: tabel.php");
        exit;

    case 'guru' :
        header("Location: guru.php");
        exit;

    case 'siswa' :
        header("Location: daftar_siswa.php");
        exit;

    default:
        // jika role aneh, hapus session
        session_destroy();
        header("Location: login.php");
        exit;
}
?>