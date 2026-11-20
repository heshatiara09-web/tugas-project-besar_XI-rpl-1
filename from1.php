<?php include 'koneksi.php';
     include 'navbar.php' ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Form Tambah User (Admin)</h3>
            
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title mb-3">Data Kredensial Akun</h4>

                    <!-- ACTION DIUBAH KE aksi3.php -->
                    <form action="aksi3.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username Akun</label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh: ujang123" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Akun</label>
                            <input type="password" name="password" class="form-control" placeholder="Contoh: password123" required>
                        </div>
                        
                        <!-- Tambahkan hidden role jika form ini khusus admin -->
                        <input type="hidden" name="role" value="admin">

                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
                            <a href="seluruh.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?php require_once 'footer.php'; ?>