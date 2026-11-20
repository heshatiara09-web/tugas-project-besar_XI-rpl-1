<?php
require_once 'koneksi.php';

// Query diperbarui agar mengambil id dari tabel users secara spesifik[cite: 1]
$sql = "SELECT users.id, users.username, users.role,
        COALESCE(siswa.nama_siswa, guru.nama) AS nama
        FROM users
        LEFT JOIN siswa ON siswa.user_id = users.id
        LEFT JOIN guru ON guru.user_id = users.id
        ORDER BY users.id DESC";

// Menjalankan query[cite: 1]
$hasil = mysqli_query($koneksi, $sql);

// Menyiapkan array data[cite: 1]
$data1 = [];

if ($hasil) {
    while ($row = mysqli_fetch_assoc($hasil)) {
        $data1[] = $row;
    }
} else {
    echo "Query gagal: " . mysqli_error($koneksi);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Linky</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS (untuk mempertahankan gaya tabel Anda) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        sidebar: {
                            border: '#93C5FD',
                            active: '#E2EEFF',
                            hover: '#F3F8FF',
                            badge: '#3B82F6',
                            text: '#1E293B',
                            subtext: '#94A3B8'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F4F7FB;
            background-image: radial-gradient(#CBD5E1 0.75px, transparent 0.75px);
            background-size: 16px 16px;
            margin: 0;
        }

        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), 
                        padding 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-transition {
            transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-row">

    <!-- 1. SIDEBAR COMPONENT (Bisa di-include terpisah via: include 'sidebar.php';) -->
    <div class="sidebar-component p-3 flex-shrink-0">
        <aside class="sidebar-element sidebar-transition w-[280px] h-[calc(100vh-1.5rem)] bg-white rounded-[28px] border-[2.5px] border-sidebar-border p-4 flex flex-col justify-between shadow-sm sticky top-3 select-none">
            
            <!-- TOP SECTION -->
            <div class="flex flex-col gap-3">
                <!-- HEADER / BRAND LOGO (Klik untuk Toggle Melebar/Mengecil) -->
                <div class="sidebar-brand-header flex items-center justify-between px-3 py-2 cursor-pointer hover:bg-sidebar-hover rounded-xl transition-colors duration-200"
                     title="Klik untuk Toggle Collapsed/Expanded">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="text-black flex-shrink-0">
                            <i data-lucide="sparkles" class="w-6 h-6 stroke-[1.8]"></i>
                        </div>
                        <span class="sidebar-text font-bold text-lg text-sidebar-text tracking-tight whitespace-nowrap fade-transition">
                            Linky
                        </span>
                    </div>
                    <div class="sidebar-text fade-transition text-gray-600">
                        <i data-lucide="chevron-down" class="sidebar-chevron w-5 h-5 transition-transform duration-300"></i>
                    </div>
                </div>

                <div class="h-[1px] bg-gray-200 my-1 mx-1"></div>

                <!-- MAIN NAVIGATION LINKS -->
                <nav class="flex flex-col gap-1.5 no-scrollbar overflow-y-auto max-h-[420px]">
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl bg-sidebar-active text-sidebar-text font-medium transition-all duration-200">
                        <i data-lucide="user-circle-2" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Profile</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="home" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Home</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center justify-between px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <div class="flex items-center gap-3.5">
                            <i data-lucide="bell" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                            <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Notification</span>
                        </div>
                        <span class="sidebar-badge bg-sidebar-badge text-white text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-[20px]">
                            12
                        </span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="bookmark" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Book mark</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="message-square" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Messages</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="moon" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Do not disturb</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="contrast" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Theme</span>
                    </a>
                </nav>
            </div>

            <!-- BOTTOM SECTION -->
            <div class="flex flex-col gap-3">
                <nav class="flex flex-col gap-1.5">
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-sidebar-hover font-medium transition-all duration-200">
                        <i data-lucide="settings" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Setting</span>
                    </a>
                    <a href="#" class="nav-item group relative flex items-center gap-3.5 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-red-50 hover:text-red-600 font-medium transition-all duration-200">
                        <i data-lucide="log-out" class="w-[22px] h-[22px] flex-shrink-0 stroke-[1.8] text-gray-800 group-hover:text-red-600"></i>
                        <span class="sidebar-text whitespace-nowrap text-sm fade-transition">Log out</span>
                    </a>
                </nav>

                <div class="h-[1px] bg-gray-200 my-1 mx-1"></div>

                <!-- USER PROFILE FOOTER -->
                <div class="flex items-center gap-3 px-2 py-1.5 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150" 
                         alt="User profile avatar" 
                         class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-200"
                         onerror="this.src='https://placehold.co/100x100/E2EEFF/1E293B?text=U'" />
                    <div class="sidebar-text flex flex-col min-w-0 fade-transition">
                        <span class="text-sm font-bold text-sidebar-text truncate leading-tight">User name</span>
                        <span class="text-xs text-sidebar-subtext truncate leading-tight mt-0.5">User@gmail.com</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- 2. MAIN CONTENT AREA (TABEL DATA SISWA) -->
    <main class="flex-1 p-6 md:p-8 overflow-y-auto">
        <div class="container-fluid bg-white p-6 rounded-4 shadow-sm border border-gray-200">
            <h1 class="fw-normal display-5 mb-3">Data Siswa</h1>
            <hr class="border border-dark border-2 opacity-100 mb-4">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col">Nama</th>
                            <th scope="col" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data1) > 0) { ?>
                            <?php $no = 1; ?>
                            <?php foreach ($data1 as $user) { ?>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= htmlspecialchars($user['username'] ?? ''); ?></td>
                                    <td><?= htmlspecialchars($user['role'] ?? ''); ?></td>
                                    <td><?= htmlspecialchars($user['nama'] ?? '-'); ?></td>
                                    <td>
                                        <a href="form_edit.php?id=<?= urlencode($user['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="aksi_hapus.php?id=<?= urlencode($user['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada data.[cite: 1]</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php 
        // Memanggil footer jika ada file terpisah
        if (file_exists('footer.php')) {
            include 'footer.php'; 
        }
        ?>
    </main>

    <!-- SCRIPTS INTERAKSI SIDEBAR -->
    <script>
    (function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        const containers = document.querySelectorAll('.sidebar-component');
        const currentContainer = containers[containers.length - 1];
        if (!currentContainer) return;

        const sidebar = currentContainer.querySelector('.sidebar-element');
        const brandHeader = currentContainer.querySelector('.sidebar-brand-header');
        const texts = currentContainer.querySelectorAll('.sidebar-text');
        const badge = currentContainer.querySelector('.sidebar-badge');
        const chevron = currentContainer.querySelector('.sidebar-chevron');
        const navItems = currentContainer.querySelectorAll('.nav-item');

        let isCollapsed = false;

        function toggleSidebar() {
            isCollapsed = !isCollapsed;

            if (isCollapsed) {
                sidebar.classList.remove('w-[280px]');
                sidebar.classList.add('w-[76px]');

                texts.forEach(el => {
                    el.classList.add('opacity-0', 'invisible', 'w-0', 'absolute');
                });

                if (badge) {
                    badge.classList.add('opacity-0', 'invisible', 'absolute');
                }

                if (chevron) {
                    chevron.style.transform = 'rotate(-90deg)';
                }
            } else {
                sidebar.classList.remove('w-[76px]');
                sidebar.classList.add('w-[280px]');

                texts.forEach(el => {
                    el.classList.remove('opacity-0', 'invisible', 'w-0', 'absolute');
                });

                if (badge) {
                    badge.classList.remove('opacity-0', 'invisible', 'absolute');
                }

                if (chevron) {
                    chevron.style.transform = 'rotate(0deg)';
                }
            }
        }

        if (brandHeader) {
            brandHeader.addEventListener('click', toggleSidebar);
        }

        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                navItems.forEach(nav => {
                    nav.classList.remove('bg-sidebar-active');
                    nav.classList.add('hover:bg-sidebar-hover');
                });
                this.classList.add('bg-sidebar-active');
                this.classList.remove('hover:bg-sidebar-hover');
            });
        });
    })();
    </script>
</body>
</html>