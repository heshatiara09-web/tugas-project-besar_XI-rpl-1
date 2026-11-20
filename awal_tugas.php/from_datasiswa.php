<?php require 'navbar.php'?>

<!--container-->
    <div class="container">

    <!-- card-->

 <div class="card">
  <div class="card-header">
    <strong>form tambah siswa</strong>
  </div>
  <div class="card-body">
    <form action name="" method="POST">
    <h5 class="card-title">Data profil siswa </h5>
    <p class="card-text"></p>

    <!--form-->

    <div class="form-floating mb-3">
  <input type="nis" class="form-control" name="nis" placeholder="32178906543">
  <label for="floatingInput">Nomor induk siswa | contoh 12345</label>
</div>
<div class="form-floating mb-3">
  <input type="nama" class="form-control" name="nama" placeholder="nama">
  <label for="floatingPassword">nama lengkap siswa | ujang kedu</label>
</div>
<div class="form-floating mb-5">
  <input type="kelas" class="form-control" name="kelas" placeholder="kelas">
  <label for="floatingPassword">kelas siswa | XI RPL-1</label>
</div>


    <!--radio-->
    <h7 class="card-title">jenis kelamin: </h7>
    <div class="form-check">
  <input value= "laki - laki" class="form-check-input" type="radio" name="kelamin" id="radioDefault1">
  <label class="form-check-label" for="radioDefault1">
    laki laki
  </label>
</div>
<div class="form-check mb-4">
  <input value= "perempuan" class="form-check-input" type="radio" name="kelamin" id="radioDefault2" checked>
  <label class="form-check-label" for="radioDefault2">
    perempuan
  </label>
</div>

<div class="mb-3">
  <h1>Data Kredensial Akun (Tabel Users)</h1>
  <label for="username" class="form-label"></label>
  <input type="text" class="form-control" name="username" placeholder="Username Akun | Contoh: ujang123">
    </div>

<div class="mb-3">
  <label for="pass" class="form-label"></label>
  <input type="password" class="form-control" name="pass" placeholder="Password Akun | Contoh: password123">
    </div>
<div class="mb-3">
<button type="submit" class="btn btn-primary btn-sm">Submit</button>
<button type="button" class="btn btn-secondary btn-sm">Kembali</button>
</div>
    </div>
   </div>
 
   <?php if (isset($_POST['kirim'])): ?>
  <h1>Output dari FORM</h1>
  <?php

  $nis              = $_POST['nis'];
  $nama             = $_POST['nama'];
  $kelas            = $_POST['kelas'];
  $kelamin          = $_POST['kelamin'];
  $username         = $_POST['username'];
  $password         = $_POST['pass'];

 echo "NIS = " . $nis . "<br>";
 echo "Nama = " . $nama . "<br>";
 echo "Kelas = " . $kelas . "<br>";
 echo "kelamin = " . $kelamin . "<br>";

?>
<?php endif; ?>
<?php require 'footer.php' ?>