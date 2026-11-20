<?php 
include 'navbar.php'; ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="card-title mb-0 fw-bold">Form Tambah user 2</h4>
                </div>
                
                <div class="card-body">
                    <form action="akasi_users.php" method="POST">
                        
                        <h5 class="fw-bold mb-4">Data Profil User 2</h5>
                        
                        <div class="mb-3">
                            <label for="nis" class="form-label">
                                Nomor Induk Siswa <span class="text-muted fw-normal ms-2">| Contoh: 12345678</span>
                            </label>
                            <input type="text" class="form-control" id="nis" name="nis">
                        </div>

                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">
                                Nama Lengkap<span class="text-muted fw-normal ms-2">| Contoh: Ujang A</span>
                            </label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa">
                        </div>

                        <div class="mb-3">
                            <label for="kelas" class="form-label">
                                Kelas Siswa <span class="text-muted fw-normal ms-2">| Contoh: XI-RPL-1</span>
                            </label>
                            <input type="text" class="form-control" id="kelas" name="kelas">
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Jenis Kelamin:</label>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L">
                                <label class="form-check-label" for="laki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="p">
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold mb-4">Data Kredensial Akun (Tabel Users)</h5>

                        <div class="mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username Akun | Contoh: ujang123">
           </div>
             <div class="mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password Akun | Contoh: password123">
              <input type="hidden" name="role"value="siswa">
               </div>
                  <button type="submit" name="tambah2" class="btn btn-primary">Simpan Data</button>
                    <a href="seluruh.php" class="btn btn-secondary">Kembali</a>
                     </form>
                     </div>
                    </div>
                   </div>
                </div>
            </div>

<?php if (isset($_POST['tambah2'])) : ?>

    <?php
    $nis           = $_POST['nis'] ?? '';
    $nama_siswa          = $_POST['nama_siswa'] ?? '';
    $kelas         = $_POST['kelas'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $username      = $_POST['username'] ?? '';
    $password      = $_POST['password'] ?? '';

    if (
        empty($nis) || 
        empty($nama_siswa) || 
        empty($kelas) || 
        empty($jenis_kelamin) || 
        empty($username) || 
        empty($password)
    ) : ?>
        <script>
            alert('Semua isi data dalam form wajib diisi!');
        </script>
    <?php else : ?>
        <h1>Output Dari FORM</h1>

        <?php
        echo "nis = " . $nis . "<br>";
        echo "nama_siswa = " . $nama_siswa . "<br>";
        echo "kelas = " . $kelas . "<br>";
        echo "jenis_kelamin = " . $jenis_kelamin . "<br><br><br>"; ?> 

    <?php endif ; ?>
    <?php endif ; ?>

    <?php require_once 'footer.php'; ?>