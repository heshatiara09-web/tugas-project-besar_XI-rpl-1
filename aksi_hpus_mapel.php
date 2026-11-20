<?php
/** @var mysqli $koneksi */

// 1. PANGGIL FILE KONEKSI
// Manggil file 'koneksi.php' biar file ini terhubung ke database MySQL
require_once "koneksi.php";

// 2. AMBIL ID DARI URL
// $_GET['id'] ini didapat dari link URL tombol Delete di file tabel mapel (contoh: aksi_hapus_mapel.php?id=5)
if (isset($_GET['id'])) {
    // intval() dipake buat mastiin nilai ID murni berupa angka (mencegah celah keamanan)
    $id = intval($_GET['id']);

    // 3. CEK APAKAH DATA MAPELNYA ADA DI DATABASE
    // Perintah SQL ini ngecek apakah ID mapel tersebut benar-benar terdaftar di tabel 'mapel'
    $query_cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE id = $id");
    
    // mysqli_fetch_assoc() ngambil hasil query di atas jadi array
    $data = mysqli_fetch_assoc($query_cek);

    // Kalau datanya ketemu di tabel 'mapel':
    if ($data) {
        // 4. ATUR PERINTAH HAPUS UNTUK TABEL 'mapel'
        $sql = "DELETE FROM mapel WHERE id = $id";

        // 5. JALANIN PROSES HAPUS DAN BALIKIN KE HALAMAN TABEL MAPEL
        if (mysqli_query($koneksi, $sql)) {
            // Kalau berhasil, munculin pop-up terus balik ke file tabel mapel (sesuaikan nama file tabelnya, misal: mapel.php atau index.php)
            echo "<script>
                    alert('Data mapel berhasil dihapus'); 
                    window.location.href = 'mapel.php';
                  </script>";
            exit();
        } else {
            // Kalau gagal, munculin pop-up error terus balik ke file tabel mapel
            echo "<script>
                    alert('Gagal menghapus data mapel'); 
                    window.location.href = 'mapel.php';
                  </script>";
            exit();
        }

    // Kalau ID-nya gak ditemukan di tabel 'mapel':
    } else {
        echo "<script>
                alert('Data mapel tidak ditemukan'); 
                window.location.href = 'mapel.php';
              </script>";
        exit();
    }

// Kalau ada yang coba buka file ini langsung tanpa lewat link hapus (tanpa bawa ID di URL):
} else {
    // Memindahkan layar secara otomatis ke file tabel mapel
    header("Location: smapel.php");
    exit();
}
?>