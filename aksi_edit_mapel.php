<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id         = $_POST['id'] ?? null;
    $kode_mapel = $_POST['kode_mapel'] ?? '';
    $nama_mapel = $_POST['nama_mapel'] ?? '';
    $guru_id    = $_POST['guru_id'] ?? '';

    if (!$id) {
        exit("ID mapel tidak ditemukan.");
    }

    // Query update
    $query = "UPDATE mapel SET kode_mapel = ?, nama_mapel = ?, guru_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    
    // PERBAIKAN DI SINI:
    // Format string 'ssii' harus berada di urutan pertama setelah $stmt, 
    // diikuti oleh variabel-variabelnya secara berurutan:
    // 's' untuk kode_mapel (string)
    // 's' untuk nama_mapel (string)
    // 'i' untuk guru_id (integer)
    // 'i' untuk id (integer)
    mysqli_stmt_bind_param($stmt, 'ssii', $kode_mapel, $nama_mapel, $guru_id, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: mapel.php?status=sukses");
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: mapel.php");
    exit;
}