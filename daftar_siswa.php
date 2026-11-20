<?php
require_once 'koneksi.php';

// Mengambil data siswa dari database
$sql = "SELECT
            users.username,
            users.role,
            siswa.nama_siswa,
            siswa.kelas
        FROM users
        INNER JOIN siswa ON users.id = siswa.user_id
        WHERE users.role = 'siswa'
        ORDER BY siswa.nama_siswa ASC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

$dataSiswa = [];

while ($row = mysqli_fetch_assoc($query)) {
    $dataSiswa[] = $row;
}

// Memanggil navbar milikmu
require_once 'nvbar.php';
?>

<!-- GOOGLE FONTS (POPPINS) & DATA TABLES CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css">

<style>
    body {
        background-color: #e0f2fe; /* Biru muda laut segar */
        font-family: 'Poppins', sans-serif;
        color: #334155;
    }

    /* CONTAINER UTAMA */
    .container-tabel {
        width: 90%;
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(56, 189, 248, 0.15);
        border: 2px solid #bae6fd;
    }

    /* JUDUL LUCU & EMOTICON LAUT */
    .judul-wrapper {
        text-align: center;
        margin-bottom: 25px;
    }

    .judul {
        font-size: 32px;
        font-weight: 700;
        color: #0284c7;
        letter-spacing: 0.5px;
        margin: 0;
        display: inline-block;
    }

    .sub-judul {
        font-size: 14px;
        color: #0369a1;
        margin-top: 5px;
    }

    /* CARD WRAPPER TABEL */
    .table-responsive {
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #e0f2fe;
    }

    /* TABEL STYLE */
    #tabelSiswa {
        margin-bottom: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* HEADER TABEL */
    #tabelSiswa thead th {
        background-color: #7dd3fc !important;
        color: #0c4a6e;
        font-weight: 600;
        padding: 16px 14px;
        border: none;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.8px;
    }

    /* ISI TABEL */
    #tabelSiswa tbody td {
        padding: 14px;
        border: none;
        border-bottom: 1px solid #f0f9ff;
        vertical-align: middle;
        font-size: 14px;
        color: #334155;
    }

    /* WARNA BARIS ZEBRA (BIRU PASTEL GELOMBANG) */
    #tabelSiswa tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    #tabelSiswa tbody tr:nth-child(even) {
        background-color: #f0f9ff;
    }

    /* NOMOR DENGAN CIRCLE/BADGE LUCU */
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

    /* BADGE ROLE LUCU */
    .role-badge {
        background-color: #e0f2fe;
        color: #0284c7;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #7dd3fc;
    }

    /* HOVER EFFECT DENGAN TRANSISI HALUS */
    #tabelSiswa tbody tr {
        transition: all 0.2s ease;
    }

    #tabelSiswa tbody tr:hover {
        background-color: #bae6fd !important;
        transform: translateY(-1px);
    }

    /* STYLE DATATABLES CONTROL (SEARCH & LENGTH) */
    .dt-container {
        padding: 10px 0;
    }

    .dt-container .dt-search input {
        border: 2px solid #bae6fd;
        border-radius: 12px;
        padding: 8px 14px;
        outline: none;
        transition: all 0.3s ease;
        background-color: #f0f9ff;
    }

    .dt-container .dt-search input:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
    }

    .dt-container .dt-length select {
        border: 2px solid #bae6fd;
        border-radius: 12px;
        padding: 8px 12px;
        outline: none;
        background-color: #f0f9ff;
    }

    /* PAGINATION LUCU */
    .dt-paging .dt-paging-button {
        border-radius: 10px !important;
        border: none !important;
        background: #e0f2fe !important;
        color: #0284c7 !important;
        margin: 0 2px;
        font-weight: 600;
    }

    .dt-paging .dt-paging-button.current {
        background: #38bdf8 !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(56, 189, 248, 0.4);
    }

    .dt-paging .dt-paging-button:hover:not(.current) {
        background: #bae6fd !important;
        color: #0369a1 !important;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .container-tabel {
            width: 95%;
            padding: 18px;
            margin: 20px auto;
            border-radius: 18px;
        }

        .judul {
            font-size: 22px;
        }
    }
</style>

<!-- TABEL SISWA -->
<div class="container-tabel">

    <div class="judul-wrapper">
        <h1 class="judul">
            🌊 Daftar Siswa Kelas XI RPL 1 🐬
        </h1>
        <p class="sub-judul">Data terintegrasi & selalu terbarui</p>
    </div>

    <div class="table-responsive">

        <table id="tabelSiswa" class="table align-middle">

            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Username</th>
                    <th class="text-center">Role</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;

                foreach ($dataSiswa as $data) {
                ?>
                    <tr>
                        <td class="text-center">
                            <span class="no-badge"><?= $no++ ?></span>
                        </td>

                        <td>
                            <strong><?= htmlspecialchars($data['username']) ?></strong>
                        </td>

                        <td class="text-center">
                            <span class="role-badge">
                                ⚓ <?= htmlspecialchars($data['role']) ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['nama_siswa'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['kelas'] ?? '') ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>

    </div>
</div>

<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    $('#tabelSiswa').DataTable({

        pageLength: 10,

        lengthMenu: [5, 10, 25, 50],

        ordering: true,

        searching: true,

        autoWidth: false,

        language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",

            search: "Cari data: ",

            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data",

            zeroRecords: "Data tidak ditemukan 🐬",

            emptyTable: "Belum ada data siswa",

            paginate: {
                previous: "❮",
                next: "❯"
            }
        }

    });

});
</script>

<?php require_once 'footer.php'; ?>