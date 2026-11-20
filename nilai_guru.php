<?php
session_start();
require_once 'koneksi.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Pastikan hanya guru yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    die("Halaman ini hanya bisa diakses oleh guru.");
}

$pesan = "";
$mode = $_GET['mode'] ?? '';

// HAPUS NILAI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
    $id = (int) $_POST['hapus_id'];

    $stmt = mysqli_prepare(
        $koneksi,
        "DELETE FROM nilai_rapor WHERE id = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: nilai_guru.php?pesan=hapus");
    exit;
}

// TAMBAH DAN EDIT NILAI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_nilai'])) {
    $id = (int) ($_POST['id'] ?? 0);
    $siswa_id = (int) $_POST['siswa_id'];
    $mapel_id = (int) $_POST['mapel_id'];
    $kkm = (float) $_POST['nilai_kkm'];
    $pengetahuan = (float) $_POST['nilai_pengetahuan'];
    $keterampilan = (float) $_POST['nilai_keterampilan'];

    if (
        $kkm < 0 || $kkm > 100 ||
        $pengetahuan < 0 || $pengetahuan > 100 ||
        $keterampilan < 0 || $keterampilan > 100
    ) {
        $pesan = "Nilai harus berada di antara 0 sampai 100.";
        $mode = $id > 0 ? 'edit' : 'tambah';
    } else {
        if ($id > 0) {
            $sql = "UPDATE nilai_rapor
                    SET siswa_id = ?, mapel_id = ?, nilai_kkm = ?,
                        nilai_pengetahuan = ?, nilai_keterampilan = ?
                    WHERE id = ?";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param(
                $stmt, "iidddi",
                $siswa_id, $mapel_id, $kkm,
                $pengetahuan, $keterampilan, $id
            );
        } else {
            $sql = "INSERT INTO nilai_rapor
                    (siswa_id, mapel_id, nilai_kkm,
                     nilai_pengetahuan, nilai_keterampilan)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param(
                $stmt, "iiddd",
                $siswa_id, $mapel_id, $kkm,
                $pengetahuan, $keterampilan
            );
        }

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: nilai_guru.php?pesan=simpan");
            exit;
        } else {
            $pesan = "Gagal menyimpan nilai: " . mysqli_error($koneksi);
            mysqli_stmt_close($stmt);
        }
    }
}

// PESAN BERHASIL
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] === 'simpan') {
        $pesan = "Nilai berhasil disimpan!";
    } elseif ($_GET['pesan'] === 'hapus') {
        $pesan = "Nilai berhasil dihapus!";
    }
}

// AMBIL DATA SISWA UNTUK FORM
$data_siswa = mysqli_query(
    $koneksi,
    "SELECT id, nama_siswa, kelas
     FROM siswa
     ORDER BY nama_siswa"
);

// AMBIL DATA MAPEL UNTUK FORM
$data_mapel = mysqli_query(
    $koneksi,
    "SELECT id, nama_mapel
     FROM mapel
     ORDER BY nama_mapel"
);

// DATA UNTUK EDIT / LIHAT
$detail = null;
if (in_array($mode, ['edit', 'lihat'], true) && isset($_GET['id'])) {
    $id_detail = (int) $_GET['id'];

    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT nilai_rapor.*,
                siswa.nama_siswa, siswa.kelas,
                mapel.nama_mapel
         FROM nilai_rapor
         JOIN siswa ON nilai_rapor.siswa_id = siswa.id
         JOIN mapel ON nilai_rapor.mapel_id = mapel.id
         WHERE nilai_rapor.id = ?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id_detail);
    mysqli_stmt_execute($stmt);
    $hasil_detail = mysqli_stmt_get_result($stmt);
    $detail = mysqli_fetch_assoc($hasil_detail);
    mysqli_stmt_close($stmt);
}

// DATA YANG DITAMPILKAN DI TABEL
$cari = trim($_GET['cari'] ?? '');

$sql = "SELECT nilai_rapor.*,
               siswa.nama_siswa, siswa.kelas,
               mapel.nama_mapel
        FROM nilai_rapor
        JOIN siswa ON nilai_rapor.siswa_id = siswa.id
        JOIN mapel ON nilai_rapor.mapel_id = mapel.id";

if ($cari !== '') {
    $sql .= " WHERE siswa.nama_siswa LIKE ?
              OR siswa.kelas LIKE ?
              OR mapel.nama_mapel LIKE ?";
}

$sql .= " ORDER BY siswa.kelas, siswa.nama_siswa, mapel.nama_mapel";

$stmt_tabel = mysqli_prepare($koneksi, $sql);

if ($cari !== '') {
    $kata_cari = "%$cari%";
    mysqli_stmt_bind_param(
        $stmt_tabel, "sss",
        $kata_cari, $kata_cari, $kata_cari
    );
}

mysqli_stmt_execute($stmt_tabel);
$data_nilai = mysqli_stmt_get_result($stmt_tabel);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Nilai Siswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e0f2fe;
            color: #334155;
        }

        .container-nilai {
            max-width: 1200px;
            margin: 35px auto;
            padding: 30px;
            background: white;
            border: 2px solid #bae6fd;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(2, 132, 199, 0.12);
        }

        .judul {
            text-align: center;
            color: #0284c7;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .table thead th {
            background: #7dd3fc;
            color: #0c4a6e;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-biru {
            background: #0284c7;
            color: white;
        }

        .btn-biru:hover {
            background: #0369a1;
            color: white;
        }

        .form-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 15px;
            padding: 22px;
            margin-bottom: 25px;
        }

        @media (max-width: 768px) {
            .container-nilai {
                margin: 15px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<?php include 'nvbar.php'; ?>

<div class="container-nilai">

    <h2 class="judul">📚 Kelola Nilai Siswa</h2>

    <?php if ($pesan !== ''): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <?php if (in_array($mode, ['tambah', 'edit'], true)): ?>

        <div class="form-box">
            <h4 class="mb-3">
                <?= $mode === 'edit' ? 'Edit Nilai Siswa' : 'Tambah Nilai Siswa' ?>
            </h4>

            <?php if ($mode === 'edit' && !$detail): ?>
                <div class="alert alert-danger">Data nilai tidak ditemukan.</div>
            <?php else: ?>

                <form method="POST" action="nilai_guru.php">
                    <input type="hidden" name="simpan_nilai" value="1">
                    <input type="hidden" name="id"
                           value="<?= (int) ($detail['id'] ?? 0) ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <select name="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php while ($s = mysqli_fetch_assoc($data_siswa)): ?>
                                <option value="<?= (int) $s['id'] ?>"
                                    <?= (isset($detail['siswa_id']) &&
                                        $detail['siswa_id'] == $s['id'])
                                        ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['nama_siswa']) ?>
                                    - <?= htmlspecialchars($s['kelas']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <?php while ($m = mysqli_fetch_assoc($data_mapel)): ?>
                                <option value="<?= (int) $m['id'] ?>"
                                    <?= (isset($detail['mapel_id']) &&
                                        $detail['mapel_id'] == $m['id'])
                                        ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m['nama_mapel']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nilai KKM</label>
                        <input type="number" name="nilai_kkm"
                               class="form-control" min="0" max="100"
                               step="0.01" required
                               value="<?= htmlspecialchars($detail['nilai_kkm'] ?? '75') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nilai Pengetahuan</label>
                        <input type="number" name="nilai_pengetahuan"
                               class="form-control" min="0" max="100"
                               step="0.01" required
                               value="<?= htmlspecialchars($detail['nilai_pengetahuan'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nilai Keterampilan</label>
                        <input type="number" name="nilai_keterampilan"
                               class="form-control" min="0" max="100"
                               step="0.01" required
                               value="<?= htmlspecialchars($detail['nilai_keterampilan'] ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-biru">Simpan</button>
                    <a href="nilai_guru.php" class="btn btn-secondary">Batal</a>
                </form>

            <?php endif; ?>
        </div>

    <?php elseif ($mode === 'lihat'): ?>

        <?php if ($detail): ?>
            <div class="form-box">
                <h4>Detail Nilai Siswa</h4>
                <p><b>Nama:</b> <?= htmlspecialchars($detail['nama_siswa']) ?></p>
                <p><b>Kelas:</b> <?= htmlspecialchars($detail['kelas']) ?></p>
                <p><b>Mata Pelajaran:</b> <?= htmlspecialchars($detail['nama_mapel']) ?></p>
                <p><b>KKM:</b> <?= htmlspecialchars($detail['nilai_kkm']) ?></p>
                <p><b>Pengetahuan:</b> <?= htmlspecialchars($detail['nilai_pengetahuan']) ?></p>
                <p><b>Keterampilan:</b> <?= htmlspecialchars($detail['nilai_keterampilan']) ?></p>

                <?php
                $rerata_detail = (
                    (float) $detail['nilai_pengetahuan'] +
                    (float) $detail['nilai_keterampilan']
                ) / 2;
                ?>
                <p><b>Rata-rata:</b> <?= number_format($rerata_detail, 2) ?></p>
                <p><b>Keterangan:</b>
                    <?= $rerata_detail >= (float) $detail['nilai_kkm']
                        ? 'Lulus' : 'Remidi' ?>
                </p>

                <a href="nilai_guru.php" class="btn btn-secondary">Kembali</a>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">Data nilai tidak ditemukan.</div>
            <a href="nilai_guru.php" class="btn btn-secondary">Kembali</a>
        <?php endif; ?>

    <?php else: ?>

        <div class="d-flex flex-wrap justify-content-between gap-3 mb-3">
            <a href="nilai_guru.php?mode=tambah" class="btn btn-biru">
                + Tambah Nilai
            </a>

            <form method="GET" action="nilai_guru.php" class="d-flex gap-2">
                <input type="text" name="cari" class="form-control"
                       placeholder="Cari siswa, kelas, mapel..."
                       value="<?= htmlspecialchars($cari) ?>">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                <a href="nilai_guru.php" class="btn btn-outline-secondary">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>KKM</th>
                        <th>Pengetahuan</th>
                        <th>Keterampilan</th>
                        <th>Rata-rata</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($data_nilai) > 0):
                    while ($n = mysqli_fetch_assoc($data_nilai)):
                        $rerata = (
                            (float) $n['nilai_pengetahuan'] +
                            (float) $n['nilai_keterampilan']
                        ) / 2;
                        $lulus = $rerata >= (float) $n['nilai_kkm'];
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($n['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($n['kelas']) ?></td>
                        <td><?= htmlspecialchars($n['nama_mapel']) ?></td>
                        <td><?= htmlspecialchars($n['nilai_kkm']) ?></td>
                        <td><?= htmlspecialchars($n['nilai_pengetahuan']) ?></td>
                        <td><?= htmlspecialchars($n['nilai_keterampilan']) ?></td>
                        <td><?= number_format($rerata, 2) ?></td>
                        <td>
                            <span class="badge <?= $lulus ? 'bg-success' : 'bg-danger' ?>">
                                <?= $lulus ? 'Lulus' : 'Remidi' ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <a class="btn btn-sm btn-info text-white"
                                   href="nilai_guru.php?mode=lihat&id=<?= (int) $n['id'] ?>">
                                    Lihat
                                </a>

                                <a class="btn btn-sm btn-warning"
                                   href="nilai_guru.php?mode=edit&id=<?= (int) $n['id'] ?>">
                                    Edit
                                </a>

                                <form method="POST" action="nilai_guru.php"
                                      onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                    <input type="hidden" name="hapus_id"
                                           value="<?= (int) $n['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="10" class="text-center p-4">
                            Belum ada data nilai siswa.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>

<?php require_once 'footer.php'; ?>

</body>
</html>