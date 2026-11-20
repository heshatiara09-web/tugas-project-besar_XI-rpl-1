<?php
session_start();

// 1. Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_siacad_smk");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$username_login = $_SESSION['username'];

// 3. Ambil data profil siswa yang sedang login
$query_siswa = mysqli_query($koneksi, "SELECT siswa.*, users.username FROM siswa JOIN users ON siswa.user_id = users.id WHERE users.username = '$username_login'");
$siswa = mysqli_fetch_assoc($query_siswa);

if (!$siswa) {
    echo "Data siswa tidak ditemukan!";
    exit;
}

$id_siswa = $siswa['id']; // Mengambil id unik siswa

// 4. Ambil data nilai berdasarkan siswa_id dan gabungkan dengan tabel mapel
$query_nilai = mysqli_query($koneksi, "SELECT nilai_rapor.*, mapel.nama_mapel FROM nilai_rapor JOIN mapel ON nilai_rapor.mapel_id = mapel.id WHERE nilai_rapor.siswa_id = '$id_siswa'");

$total_rerata = 0;
$jumlah_mapel = 0;
$data_nilai = [];

while ($row = mysqli_fetch_assoc($query_nilai)) {
    // Hitung rata-rata per mapel (Pengetahuan + Keterampilan / 2)
    $rerata_mapel = ($row['nilai_pengetahuan'] + $row['nilai_keterampilan']) / 2;
    $row['rerata_mapel'] = $rerata_mapel;
    
    // Tentukan keterangan
    $row['keterangan'] = !empty($row['Keterangan']) ? $row['Keterangan'] : (($rerata_mapel >= $row['nilai_kkm']) ? 'Lulus' : 'Remidi');
    
    $total_rerata += $rerata_mapel;
    $jumlah_mapel++;
    
    $data_nilai[] = $row;
}

// Hitung rata-rata total keseluruhan nilai rapor
$rata_rata_keseluruhan = ($jumlah_mapel > 0) ? number_format($total_rerata / $jumlah_mapel, 2) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa - Aplikasi Sekolah</title>
    
    <!-- Bootstrap 5 CSS CDN (Opsional untuk utilitas) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- GOOGLE FONTS (POPPINS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e0f2fe; /* Biru muda laut segar */
            margin: 0;
            padding: 0 0 40px 0;
            color: #334155;
        }

        /* CONTAINER UTAMA */
        .container {
            max-width: 950px;
            background: #ffffff;
            margin: 35px auto;
            border: 2px solid #bae6fd;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.15);
            padding: 35px;
        }

        .text-center { text-align: center; }
        
        h2.page-title { 
            font-size: 28px; 
            font-weight: 700;
            margin-bottom: 5px; 
            color: #0284c7; 
        }

        .student-name { 
            font-size: 20px; 
            font-weight: 700; 
            color: #0c4a6e;
            margin-bottom: 6px; 
        }

        .student-info { 
            font-size: 14px; 
            color: #0369a1; 
            margin-bottom: 25px;
            background-color: #f0f9ff;
            display: inline-block;
            padding: 6px 18px;
            border-radius: 20px;
            border: 1.5px solid #bae6fd;
        }

        /* CARD RATA-RATA */
        .card-average {
            max-width: 320px;
            margin: 0 auto 35px auto;
            border: 2px solid #bae6fd;
            border-radius: 20px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            text-align: center;
            padding: 22px;
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.12);
        }

        .card-average .title-avg { 
            font-size: 15px; 
            font-weight: 700; 
            color: #0369a1; 
            margin-bottom: 8px; 
        }

        .card-average .value-avg { 
            font-size: 42px; 
            font-weight: 700;
            color: #0284c7; 
        }

        /* TABLE BOX */
        .table-box { 
            border: 2px solid #bae6fd; 
            border-radius: 18px; 
            padding: 24px; 
            background: #fff; 
        }

        .table-title { 
            font-size: 18px; 
            font-weight: 700; 
            color: #0369a1;
            margin-bottom: 18px; 
        }

        .table-controls { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 18px; 
            font-size: 14px; 
            color: #334155;
        }

        .table-controls select, .table-controls input { 
            padding: 7px 12px; 
            border: 2px solid #bae6fd; 
            border-radius: 12px; 
            font-size: 14px; 
            background-color: #f0f9ff;
            color: #334155;
            outline: none;
            transition: all 0.3s ease;
        }

        .table-controls select:focus, .table-controls input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
            background-color: #fff;
        }

        /* TABEL STYLE */
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-bottom: 18px; 
            font-size: 14px; 
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid #bae6fd;
        }

        th, td { 
            border-bottom: 1.5px solid #f0f9ff; 
            border-right: 1.5px solid #f0f9ff;
            padding: 12px 14px; 
            text-align: left; 
        }

        th:last-child, td:last-child {
            border-right: none;
        }

        th { 
            background-color: #7dd3fc !important; 
            color: #0c4a6e; 
            font-weight: 600; 
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) { 
            background-color: #f0f9ff; 
        }

        tr:hover {
            background-color: #bae6fd !important;
            transition: background-color 0.2s ease;
        }

        /* BADGE KETERANGAN LULUS / REMIDI */
        .badge-lulus {
            background-color: #d1fae5;
            color: #065f46;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .badge-remidi {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        /* PAGINATION */
        .pagination-container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            font-size: 14px; 
            color: #64748b; 
            margin-top: 20px; 
        }

        .pagination-buttons span { 
            padding: 6px 14px; 
            border: 1.5px solid #bae6fd; 
            border-radius: 10px; 
            background-color: #f0f9ff; 
            margin-left: 4px; 
            font-weight: 600;
            color: #0284c7;
        }

        .pagination-buttons .active { 
            background-color: #38bdf8; 
            color: #fff; 
            border-color: #38bdf8; 
            box-shadow: 0 3px 10px rgba(56, 189, 248, 0.4);
        }

        @media (max-width: 768px) {
            .container {
                width: 92%;
                padding: 20px;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>

    <!-- Memanggil Navbar -->
    <?php include 'nvbar.php'; ?>

<div class="container">
    <div class="text-center">
        <h2 class="page-title">🌊 Nilai Siswa 🐬</h2>
        <div class="student-name"><?php echo htmlspecialchars($siswa['nama_siswa']); ?></div>
        <div class="student-info">
            NIS: <b><?php echo htmlspecialchars($siswa['nis']); ?></b> &nbsp;|&nbsp; Kelas: <b><?php echo htmlspecialchars($siswa['kelas']); ?></b>
        </div>
    </div>

    <div class="card-average">
        <div class="title-avg">✨ Rata-rata Nilai Keseluruhan</div>
        <div class="value-avg"><?php echo $rata_rata_keseluruhan; ?></div>
    </div>

    <div class="table-box">
        <div class="table-title">📚 Daftar Nilai Rapor</div>
        
        <div class="table-controls">
            <div>
                Tampilkan 
                <select>
                    <option value="10">10</option>
                </select> 
                data per halaman
            </div>
            <div>
                Cari: <input type="text" placeholder="Cari mapel...">
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Mata Pelajaran</th>
                    <th class="text-center">KKM</th>
                    <th class="text-center">Pengetahuan</th>
                    <th class="text-center">Keterampilan</th>
                    <th class="text-center">Rata-rata</th>
                    <th class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data_nilai) > 0): ?>
                    <?php $no = 1; foreach ($data_nilai as $nilai): ?>
                    <tr>
                        <td class="text-center font-weight-bold"><?php echo $no++; ?></td>
                        <td><strong><?php echo htmlspecialchars($nilai['nama_mapel']); ?></strong></td>
                        <td class="text-center"><?php echo htmlspecialchars($nilai['nilai_kkm']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($nilai['nilai_pengetahuan']); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($nilai['nilai_keterampilan']); ?></td>
                        <td class="text-center"><b><?php echo number_format($nilai['rerata_mapel'], 2); ?></b></td>
                        <td class="text-center">
                            <?php if ($nilai['keterangan'] === 'Lulus'): ?>
                                <span class="badge-lulus">✨ Lulus</span>
                            <?php else: ?>
                                <span class="badge-remidi">⚠️ Remidi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 25px; color: #64748b;">Belum ada data nilai untuk siswa ini. 🐬</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination-container">
            <div>Menampilkan halaman 1 dari 1</div>
            <div class="pagination-buttons">
                <span style="color: #94a3b8; background: #f8fafc;">Sebelumnya</span>
                <span class="active">1</span>
                <span style="color: #94a3b8; background: #f8fafc;">Selanjutnya</span>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php';?>

</body>
</html>