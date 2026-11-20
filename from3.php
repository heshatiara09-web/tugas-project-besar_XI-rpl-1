<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Dinamis</title>
    <!-- LINK BOOTSTRAP CSS (Supaya tampilan rapi dan komponen jalan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .box-siswa,
        .box-guru,
        .box-jk {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

    <?php 
    // LINK NAVBAR: Memanggil menu navigasi atas
    require_once "navbar.php"; 
    ?>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">

                        <!-- LINK AKSI: Mengirim data ke file aksi_tambah_user.php -->
                        <form action="akasi_users.php" method="POST">
                            <h4 class="fw-bold mb-3 text-primary">Data Kredensial Akun</h4>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Contoh: ujang123" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Contoh: password123" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label small fw-semibold">Pilih Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <!-- INPUT KHUSUS SISWA -->
                            <div class="mb-3 box-siswa">
                                <label class="form-label small fw-semibold">Nama Siswa</label>
                                <input type="text" class="form-control" name="nama_siswa" placeholder="Masukkan nama siswa">
                            </div>

                            <div class="mb-3 box-siswa">
                                <label class="form-label small fw-semibold">NIS</label>
                                <input type="text" class="form-control" name="nis" placeholder="Masukkan NIS">
                            </div>

                            <div class="mb-3 box-siswa">
                                <label class="form-label small fw-semibold">Kelas</label>
                                <input type="text" class="form-control" name="kelas" placeholder="Contoh: XII RPL 1">
                            </div>

                            <!-- INPUT KHUSUS GURU -->
                            <div class="mb-3 box-guru">
                                <label class="form-label small fw-semibold">Nama Guru</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama guru">
                            </div>

                            <div class="mb-3 box-guru">
                                <label class="form-label small fw-semibold">NIP</label>
                                <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP">
                            </div>

                            <!-- INPUT JENIS KELAMIN -->
                            <div class="mb-3 box-jk">
                                <label class="form-label small fw-semibold">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <!-- Tombol Aksi & Link Tombol Kembali -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- LINK KEMBALI -->
                                <a href="tabel.php" class="btn btn-secondary btn-sm px-3">Kembali</a>
                                <button type="submit" name="tambah2" class="btn btn-primary btn-sm px-4">Simpan Data</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk memunculkan input dinamis -->
    <script>
        document.getElementById('role').addEventListener('change', function () {
            let role = this.value;
            let boxSiswa = document.querySelectorAll('.box-siswa');
            let boxGuru = document.querySelectorAll('.box-guru');
            let boxJk = document.querySelector('.box-jk');

            boxSiswa.forEach(el => el.style.display = 'none');
            boxGuru.forEach(el => el.style.display = 'none');
            boxJk.style.display = 'none';

            if (role === 'siswa') {
                boxSiswa.forEach(el => el.style.display = 'block');
                boxJk.style.display = 'block';
            } else if (role === 'guru') {
                boxGuru.forEach(el => el.style.display = 'block');
                boxJk.style.display = 'block';
            }
        });
    </script>

    <!-- LINK BOOTSTRAP JS BUNDLE (Wajib agar navbar & dropdown berfungsi normal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php require_once 'footer.php'; ?>