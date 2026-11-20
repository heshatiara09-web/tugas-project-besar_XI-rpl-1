<?php
require_once 'koneksi.php';

session_start(); // memulai session

$user = $_POST['username'];
$pass = $_POST['password'];

$sql = "SELECT users.*, COALESCE(siswa.nama_siswa, guru.nama) AS nama, siswa.kelas
FROM users
LEFT JOIN siswa ON users.id = siswa.user_id
LEFT JOIN guru ON users.id = guru.user_id
WHERE users.username = '$user'
";

$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);


if ($user && password_verify($pass, $data['password'])) {
   // var_dump($query);
   // exit;
    // membuat variabel session
    $_SESSION['id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama'] = $data['nama']; 
    $_SESSION['role'] = $data['role'];
    $_SESSION['kelas'] = $data['kelas'];
    $_SESSION['login'] = true;


    // beralih ke halaman index
    header("location: index.php");
    exit;
} else {
    echo "<script>
    alert('username atau password salah !');
    window.location='login.php';
    </script>";
}
?>