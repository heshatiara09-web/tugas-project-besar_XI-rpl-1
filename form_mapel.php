<?php
require_once 'koneksi.php';

// Cek ID mapel dari URL
if (!isset($_GET['id'])) {
    header("Location: mapel.php");
    exit;
}

$id_mapel = $_GET['id'];

// Ambil data mapel berdasarkan ID
$query_mapel = mysqli_prepare($koneksi, "SELECT * FROM mapel WHERE id = ?");
mysqli_stmt_bind_param($query_mapel, 'i', $id_mapel);
mysqli_stmt_execute($query_mapel);
$result_mapel = mysqli_stmt_get_result($query_mapel);
$data_mapel = mysqli_fetch_assoc($result_mapel);

// Jika data tidak ditemukan
if (!$data_mapel) {
    exit("Data mata pelajaran tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Mata Pelajaran</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mengarah ke aksi_edit_mapel.php menggunakan metode POST -->
                        <form action="aksi_edit_mapel.php" method="POST">
                            
                            <!-- Input hidden untuk mengirim ID mapel secara aman dengan prepared statement -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($data_mapel['id']); ?>">

                            <div class="mb-3">
                                <label for="kode_mapel" class="form-label">Kode Mata Pelajaran</label>
                                <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" value="<?= htmlspecialchars($data_mapel['kode_mapel']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" value="<?= htmlspecialchars($data_mapel['nama_mapel']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="guru_id" class="form-label">Guru Pengampu</label>
                                <select class="form-select" id="guru_id" name="guru_id" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php
                                    $query_guru = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while ($guru = mysqli_fetch_assoc($query_guru)) {
                                        $selected = ($guru['id'] == $data_mapel['guru_id']) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($guru['id']) . '" ' . $selected . '>' . htmlspecialchars($guru['nama']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="mapel.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>