<?php
/** @var mysqli $koneksi */
// Buat Sambungin file ini ke database lewat koneksi.php
require_once 'koneksi.php';

//buat ngambil data dari form dan amanin password
// Pakai Null Coalescing (??) biar nggak error kalau ada kolom yang nggak diisi
$nis           = $_POST['nis'] ?? '';
$nip           = $_POST['nip'] ?? '';
$nama          = $_POST['nama'] ?? '';
$nama_siswa    = $_POST['nama_siswa'] ?? '';
$kelas         = $_POST['kelas'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$username      = $_POST['username'] ?? '';
$pass          = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : ''; // Password diacak/dihash biar aman
$role          = $_POST['role'] ?? 'siswa';

//buat nyimpen data akun utama ke tabel 'users'
$sql_users = "INSERT INTO users(id, username, password, role, created_at) VALUES ('','$username','$pass','$role',now())";
$query = mysqli_query($koneksi, $sql_users);

//Cek apakah simpan akun ke tabel 'users' berhasil
if ($query) {
    // ambil ID akun yang baru aja dibuat buat disambungin ke data detail
    $id_terakhir = mysqli_insert_id($koneksi);

    //Proses disimpan kalau role-nya 'siswa'
    if ($role == 'siswa') {
        $sql_siswa = "INSERT INTO siswa (id, nis, nama_siswa, kelas, jenis_kelamin, user_id) VALUES ('','$nis','$nama_siswa','$kelas','$jenis_kelamin','$id_terakhir')";
        $query_siswa = mysqli_query($koneksi, $sql_siswa);

        // ngasih notifikasi berhasil/gagal lalu balik ke halaman tabel.php
        if ($query_siswa) {
            echo "<script>alert('data berhasil disimpan!'); window.location.href='tabel.php';</script>";  
        } else {
            echo "<script>alert('gagal menyimpan data siswa: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='tabel.php';</script>";  
        }

    //Proses disimpan kalau role-nya 'guru'
    } else if ($role == 'guru') {
        $sql_guru = "INSERT INTO guru (id, nip, nama, jenis_kelamin, user_id) VALUES ('','$nip','$nama','$jenis_kelamin','$id_terakhir')";
        $query_guru = mysqli_query($koneksi, $sql_guru);

        //Kasih notifikasi berhasil/gagal lalu balik ke halaman tabel.php
        if ($query_guru) {
            echo "<script>alert('data berhasil disimpan!'); window.location.href='tabel_guru.php';</script>";  
        } else {
            echo "<script>alert('gagal menyimpan data guru: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='tabel.php';</script>";  
        }

    //Kalau role-nya 'admin', cukup simpan ke tabel 'users' aja
    } else {
        echo "<script>alert('data berhasil disimpan!'); window.location.href='tabel.php';</script>";  
    }

     //Kalau dari awal simpan ke tabel 'users' udah gagal
} else {
    echo "<script>alert('gagal menyimpan data kedalam tabel users: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='tabel.php';</script>";  
}
?>