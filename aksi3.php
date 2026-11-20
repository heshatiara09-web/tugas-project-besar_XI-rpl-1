<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php';

if (isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitasi data input umum
    $uss           = mysqli_real_escape_string($koneksi, trim($_POST['username'] ?? ''));
    $role          = mysqli_real_escape_string($koneksi, trim($_POST['role'] ?? ''));
    $jenis_kelamin = mysqli_real_escape_string($koneksi, trim($_POST['jenis_kelamin'] ?? ''));
    $pw_raw        = $_POST['password'] ?? '';
    
    // Hash password demi keamanan
    $pw            = !empty($pw_raw) ? password_hash($pw_raw, PASSWORD_DEFAULT) : '';

    // 1. Validasi Input Wajib
    if (empty($uss) || empty($pw_raw) || empty($role)) {
        echo "<script>alert('Username, Password, dan Role wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // 2. Cek apakah Username sudah pernah terdaftar di tabel users
    $cek_username = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$uss'");
    if (!$cek_username) {
        die("Query Error (Cek Username): " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username sudah terpakai! Silakan gunakan username lain.'); window.history.back();</script>";
        exit;
    }

    // Mulai Transaksi Database agar penyimpanan data sinkron
    mysqli_begin_transaction($koneksi);

    try {
        // 3. Simpan ke tabel utama (`users`)
        $sql_usr   = "INSERT INTO users (username, password, role, created_at) VALUES ('$uss', '$pw', '$role', NOW())";
        $query_usr = mysqli_query($koneksi, $sql_usr);

        if (!$query_usr) {
            throw new Exception("Gagal simpan ke tabel users: " . mysqli_error($koneksi));
        }

        // Ambil ID otomatis (Auto Increment) dari baris user yang baru saja dibuat
        $id_terakhir = mysqli_insert_id($koneksi);

        // 4. Percabangan penyimpanan data tambahan berdasarkan Role
        if ($role === 'siswa') {
            $nis   = mysqli_real_escape_string($koneksi, trim($_POST['nis'] ?? ''));
            $kelas = mysqli_real_escape_string($koneksi, trim($_POST['kelas'] ?? ''));

            // Menggunakan tabel smk_siswa
            $sql_siswa   = "INSERT INTO siswa (nis, nama_siswa, kelas, jenis_kelamin, user_id) 
                            VALUES ('$nis', '$uss', '$kelas', '$jenis_kelamin', '$id_terakhir')";
            $query_siswa = mysqli_query($koneksi, $sql_siswa);

            if (!$query_siswa) {
                throw new Exception("Gagal simpan ke tabel smk_siswa: " . mysqli_error($koneksi));
            }

        } else if ($role === 'guru') {
            $nip = mysqli_real_escape_string($koneksi, trim($_POST['nip'] ?? ''));

            // Menggunakan tabel smk_guru
            $sql_guru   = "INSERT INTO guru (nip, nama_siswa, jenis_kelamin, user_id) 
                           VALUES ('$nip', '$uss', '$jenis_kelamin', '$id_terakhir')";
            $query_guru = mysqli_query($koneksi, $sql_guru);

            if (!$query_guru) {
                throw new Exception("Gagal simpan ke tabel guru: " . mysqli_error($koneksi));
            }
        }

        // Jika semua query sukses, commit ke database
        mysqli_commit($koneksi);

        echo "<script>alert('Data user ($role) berhasil disimpan!'); window.location.href='tabel.php';</script>";
        exit;

    } catch (Exception $e) {
        // Jika ada error pada tabel siswa/guru, batalkan input di smk_users
        mysqli_rollback($koneksi);
        echo "<script>alert('Terjadi kesalahan: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }

} else {
    header("Location: tambah_user.php");
    exit;
}
?>