<?php
require_once 'koneksi.php';

// Cek ID mapel dari URL
if (!isset($_GET['id'])) {
    header("Location: mapel.php");
    exit;
}

$id_mapel = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data mapel
$query_mapel = mysqli_query(
    $koneksi,
    "SELECT * FROM mapel WHERE id = '$id_mapel'"
);

$data_mapel = mysqli_fetch_assoc($query_mapel);

// Jika data tidak ditemukan
if (!$data_mapel) {
    echo "Data mata pelajaran tidak ditemukan.";
    exit;
}

require_once 'navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Form Edit Mata Pelajaran</h5>
        </div>

        <div class="card-body">
            <h4 class="mb-4">Edit Data Mata Pelajaran</h4>

            <form action="aksi_edit_mapel.php" method="POST">

                <input type="hidden" name="id"
                    value="<?= htmlspecialchars($data_mapel['id']); ?>">

                <div class="mb-3">
                    <label for="kode_mapel" class="form-label">
                        Kode Mata Pelajaran
                    </label>

                    <input type="text"
                        class="form-control"
                        id="kode_mapel"
                        name="kode_mapel"
                        value="<?= htmlspecialchars($data_mapel['kode_mapel']); ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="nama_mapel" class="form-label">
                        Nama Mata Pelajaran
                    </label>

                    <input type="text"
                        class="form-control"
                        id="nama_mapel"
                        name="nama_mapel"
                        value="<?= htmlspecialchars($data_mapel['nama_mapel']); ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="guru_id" class="form-label">
                        Pilih Guru
                    </label>

                    <select class="form-select"
                        id="guru_id"
                        name="guru_id"
                        required>

                        <option value="">Pilih Guru...</option>

                        <?php
                        $query_guru = mysqli_query(
                            $koneksi,
                            "SELECT * FROM guru"
                        );

                        while ($guru = mysqli_fetch_assoc($query_guru)) {
                            $selected = (
                                $guru['id'] == $data_mapel['guru_id']
                            ) ? 'selected' : '';

                            echo '<option value="' .
                                htmlspecialchars($guru['id']) . '" ' .
                                $selected . '>' .
                                htmlspecialchars($guru['nama']) .
                                '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="mapel.php" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>