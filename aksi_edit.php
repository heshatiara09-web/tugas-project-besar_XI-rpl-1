<?php

 include_once 'template/nvbar.php';

include_once 'koneksi.php';







$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; //menangkap id dari url yang dikirimkan dari halaman user.php ketika tombol edit di klik, id ini akan digunakan untuk menampilkan data yang sesuai dengan id tersebut pada form edit user, dengan method $_GET

if ($id > 0) {
    $query = "SELECT * FROM user WHERE id=$id"; //menampilkan semua data dari tabel user dengan id yang kita pilih atau sesuai
    $result = mysqli_query($koneksi, $query); //menjalankan query ke database dengan fungsi mysqli_query, dengan parameter koneksi dan query yang sudah kita buat sebelumnya
    $user = mysqli_fetch_assoc($result); //mengambil hasil query dan menyimpannya dalam bentuk array asosiatif, sehingga kita bisa mengakses data user dengan menggunakan nama kolom sebagai indeks, misalnya $user['nama'] untuk mendapatkan nama user yang akan diedit
    
    if (!$user) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='user.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='user.php';</script>";
    exit;
}

?>





