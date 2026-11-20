<?php
// Hubungkan ke database
require_once 'koneksi.php';

// Aktifkan pelaporan error MySQLi untuk mendeteksi kendala query
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Pastikan data dikirim melalui metode POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Ambil data dari form
        $kode_mapel = trim($_POST['kode_mapel']);
        $nama_mapel = trim($_POST['nama_mapel']);
        $guru_id    = trim($_POST['guru_id']);

        // Validasi sederhana agar tidak kosong
        if (empty($kode_mapel) || empty($nama_mapel) || empty($guru_id)) {
            echo "<script>alert('Semua kolom wajib diisi!'); window.history.back();</script>";
            exit();
        }

        // Query INSERT ke tabel mapel
        // Pastikan nama kolom di database Anda sesuai: kode_mapel, nama_mapel, dan guru_id
        $stmt = mysqli_prepare($koneksi, "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssi", $kode_mapel, $nama_mapel, $guru_id);
        mysqli_stmt_execute($stmt);

        // Jika berhasil, munculkan alert dan arahkan kembali ke halaman mapel.php
        echo "<script>alert('Data mata pelajaran berhasil disimpan!'); window.location.href='mapel.php';</script>";
        exit();

    } else {
        // Jika file diakses langsung di URL tanpa lewat form submit
        header("Location: mapel.php");
        exit();
    }

} catch (Exception $e) {
    // Menangkap error database (misalnya duplikat kode mapel)
    echo "<script>alert('Gagal menyimpan data: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
}
?>