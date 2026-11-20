<?php
require_once "koneksi.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        mysqli_begin_transaction($koneksi);

        // 1. Hapus data di tabel siswa terlebih dahulu jika ada
        $stmt_siswa = mysqli_prepare($koneksi, "DELETE FROM siswa WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt_siswa, "i", $id);
        mysqli_stmt_execute($stmt_siswa);

        // 2. Hapus data di tabel guru terlebih dahulu jika ada
        $stmt_guru = mysqli_prepare($koneksi, "DELETE FROM guru WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt_guru, "i", $id);
        mysqli_stmt_execute($stmt_guru);

        // 3. Setelah bersih dari tabel anak, hapus data di tabel users
        $stmt_user = mysqli_prepare($koneksi, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt_user, "i", $id);
        mysqli_stmt_execute($stmt_user);

        // Simpan permanen
        mysqli_commit($koneksi);
        
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='tabel.php';</script>";
        exit;

    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Gagal hapus data: " . addslashes($e->getMessage()) . "'); window.location.href='tabel.php';</script>";
    }

} else {
    echo "<script>alert('ID tidak valid'); window.location.href='tabel.php';</script>";
}
?>