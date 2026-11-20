<?php
/** @var mysqli $koneksi */
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id         = $_POST['id'] ?? '';
    $kode_mapel = $_POST['kode_mapel'] ?? '';
    $nama_mapel = $_POST['nama_mapel'] ?? '';
    $id_guru    = $_POST['guru_id'] ?? '';

    if (empty($id)) {
        echo "<script>alert('ID Mata Pelajaran tidak valid!'); window.location.href='mapel.php';</script>";
        exit;
    }

    $id         = mysqli_real_escape_string($koneksi, $id);
    $kode_mapel = mysqli_real_escape_string($koneksi, $kode_mapel);
    $nama_mapel = mysqli_real_escape_string($koneksi, $nama_mapel);

    // BILA GURU DIPILIH, PAKAI ID GURU. JIKA TIDAK DIPILIH, SET NILAI 'NULL'
    if (!empty($id_guru)) {
        $guru_id_sql = "'" . mysqli_real_escape_string($koneksi, $guru_id) . "'";
    } else {
        $guru_id_sql = "NULL"; // Mengisi NULL ke database jika guru tidak dipilih
    }

    // Query SQL Update (tanpa tanda kutip di $guru_id_sql karena sudah diatur di atas)
    $sql_update = "UPDATE mapel 
                   SET kode_mapel = '$kode_mapel', 
                       nama_mapel = '$nama_mapel', 
                       guru_id    = $guru_id_sql 
                   WHERE id = '$id'";

    $query_update = mysqli_query($koneksi, $sql_update);

    if ($query_update) {
        echo "<script>
                alert('Data mata pelajaran berhasil diperbarui!'); 
                window.location.href='mapel.php';
              </script>";
    } else {
        // Tampilkan pesan error MySQL asli jika gagal
        echo "<script>
                alert('Gagal memperbarui data: " . addslashes(mysqli_error($koneksi)) . "'); 
                window.location.href='mapel.php';
              </script>";
    }

} else {
    header("Location: mapel.php");
    exit;
}
?>