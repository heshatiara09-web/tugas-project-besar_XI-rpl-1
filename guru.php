<?php
// 1. Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "db_siacad_smk");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// 2. Ambil data guru, users, dan mapel menggunakan JOIN & LEFT JOIN sesuai struktur database
$query = mysqli_query($koneksi, "SELECT guru.*, users.username, users.role, mapel.nama_mapel 
                                 FROM guru 
                                 JOIN users ON guru.user_id = users.id 
                                 LEFT JOIN mapel ON mapel.guru_id = guru.id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Guru - Aplikasi Sekolah</title>
    
    <!-- Bootstrap 5 CSS CDN (Opsional untuk utilitas grid) -->
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
            padding: 0;
            color: #334155;
        }

        /* CONTAINER UTAMA */
        .container {
            max-width: 1050px;
            background: #ffffff;
            margin: 35px auto;
            border: 2px solid #bae6fd;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.15);
            padding: 35px;
        }

        .text-center {
            text-align: center;
        }

        h2.page-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #0284c7;
        }

        /* KONTROL TABEL (SEARCH & LENGTH) */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
            background-color: #ffffff;
        }

        .table-controls input {
            width: 220px;
        }

        /* STYLING TABEL */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 14px;
            border-radius: 12px;
            overflow: hidden;
            border: 1.5px solid #bae6fd;
        }

        th, td {
            border-bottom: 1.5px solid #f0f9ff;
            border-right: 1.5px solid #f0f9ff;
            padding: 14px 16px;
            text-align: left;
            vertical-align: middle;
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

        /* NOMOR BADGE & ROLE BADGE */
        .no-badge {
            display: inline-block;
            width: 28px;
            height: 28px;
            line-height: 28px;
            background-color: #bae6fd;
            color: #0369a1;
            border-radius: 50%;
            text-align: center;
            font-weight: 600;
            font-size: 13px;
        }

        .role-badge {
            background-color: #e0f2fe;
            color: #0284c7;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #7dd3fc;
        }

        /* PAGINASI */
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
            text-decoration: none;
            color: #0284c7;
            border-radius: 10px;
            margin-left: 4px;
            background-color: #f0f9ff;
            font-weight: 600;
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

<!-- Memanggil Navbar agar bisa diklik untuk pindah halaman -->
<?php include 'nvbar.php'; ?>

<div class="container">
    <div class="text-center">
        <h2 class="page-title">🌊 Daftar Guru 🐬</h2>
    </div>

    <div class="table-controls">
        <div>
            Tampilkan 
            <select>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select> 
            data per halaman
        </div>
        <div>
            Cari: <input type="text" placeholder="Cari guru...">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 70px;" class="text-center">No ↕</th>
                <th>Username ↕</th>
                <th>Role ↕</th>
                <th>Nama ↕</th>
                <th>Mapel ↕</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td class="text-center"><span class="no-badge"><?php echo $no++; ?></span></td>
                <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                <td>
                    <span class="role-badge">⚓ <?php echo htmlspecialchars($row['role']); ?></span>
                </td>
                <td><?php echo htmlspecialchars($row['nama'] ?? $row['nama_guru'] ?? '-'); ?></td>
                <!-- Menampilkan nama mapel yang terhubung lewat guru_id -->
                <td><span class="text-primary fw-semibold"><?php echo htmlspecialchars($row['nama_mapel'] ?? '-'); ?></span></td>
            </tr>
            <?php 
                }
            } else { 
            ?>
            <tr>
                <td colspan="5" class="text-center" style="padding: 25px; color: #64748b;">Belum ada data guru di database. 🐬</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="pagination-container">
        <div>Menampilkan halaman 1 dari 1</div>
        <div class="pagination-buttons">
            <span style="color: #94a3b8; background: #f8fafc; cursor: not-allowed;">Sebelumnya</span>
            <span class="active">1</span>
            <span style="color: #94a3b8; background: #f8fafc; cursor: not-allowed;">Selanjutnya</span>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

</body>
</html>