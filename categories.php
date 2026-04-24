<?php
session_start();
include 'koneksi.php';

// Proteksi halaman
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

// Query untuk mengambil kategori beserta jumlah habit di dalamnya
$query = "SELECT categories.id, categories.name, COUNT(habits.id) as total_habits 
          FROM categories 
          LEFT JOIN habits ON categories.id = habits.category_id 
          GROUP BY categories.id
          ORDER BY categories.id DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori | Premium Crypto Style</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===== GLOBAL SETUP ===== */
        body { 
            background-color: #020617; 
            color: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            padding-bottom: 50px;
        }

        /* ===== BACKGROUND GLOW (ORBS) ===== */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            animation: float 15s infinite alternate ease-in-out;
        }
        .orb-purple { width: 450px; height: 450px; background: rgba(167, 139, 250, 0.15); top: -10%; left: -5%; }
        .orb-pink { width: 400px; height: 400px; background: rgba(244, 114, 182, 0.15); bottom: -10%; right: -5%; }
        @keyframes float { 0% { transform: translate(0, 0); } 100% { transform: translate(40px, 60px); } }

        /* ===== HEADER SECTION ===== */
        .page-header {
            padding: 60px 0 40px;
            text-align: center;
            animation: fadeInDown 0.8s ease;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .glow-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(to right, #a78bfa, #f472b6, #fb923c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        /* ===== ACTION BUTTONS ===== */
        .btn-crypto {
            border: none;
            padding: 12px 25px;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-add { background: linear-gradient(135deg, #8b5cf6, #d946ef); color: white; box-shadow: 0 10px 20px -5px rgba(217, 70, 239, 0.5); }
        .btn-back { background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); }
        .btn-crypto:hover { transform: translateY(-3px); box-shadow: 0 15px 30px -5px rgba(217, 70, 239, 0.6); color: white; }

        /* ===== GLASS TABLE CARD ===== */
        .table-container {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table { color: #e2e8f0; margin-bottom: 0; vertical-align: middle; }
        .table thead th { 
            border-bottom: 1px solid rgba(255,255,255,0.1); 
            color: #94a3b8; 
            font-weight: 500; 
            text-transform: uppercase; 
            font-size: 12px; 
            letter-spacing: 1px;
            padding: 20px;
        }
        .table tbody td { border-bottom: 1px solid rgba(255,255,255,0.05); padding: 20px; }
        
        .table tbody tr { transition: all 0.3s ease; }
        .table tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* ===== CUSTOM ELEMENTS ===== */
        .category-name { font-weight: 600; font-size: 18px; color: #f8fafc; }
        
        .badge-count {
            background: rgba(167, 139, 250, 0.15);
            color: #c4b5fd;
            border: 1px solid rgba(167, 139, 250, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        /* Action Icons */
        .action-link {
            width: 38px; height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-edit { background: rgba(250, 204, 21, 0.1); color: #facc15; }
        .btn-edit:hover { background: #facc15; color: #020617; }
        .btn-del { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-del:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

    <div class="orb orb-purple"></div>
    <div class="orb orb-pink"></div>

    <div class="container">
        <header class="page-header">
            <h1 class="glow-title">Category Matrix</h1>
            <p class="text-secondary">Kelompokkan rutinitasmu agar lebih terstruktur dan mudah dianalisis.</p>
            
            <div class="mt-4 d-flex justify-content-center gap-3">
                <a href="dashboard.php" class="btn-crypto btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <a href="add_categories.php" class="btn-crypto btn-add">
                    <i class="fa-solid fa-folder-plus"></i> New Category
                </a>
            </div>
        </header>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Matrix</th>
                            <th>Category Name</th>
                            <th>Usage Stats</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result->num_rows > 0): ?>
                            <?php 
                            $no = 1;
                            while($row = $result->fetch_assoc()): 
                            ?>
                                <tr>
                                    <td style="color:#64748b; font-weight: 600;">#00<?= $no++ ?></td>
                                    <td>
                                        <i class="fa-solid fa-layer-group me-2" style="color: #a78bfa;"></i>
                                        <span class="category-name"><?= htmlspecialchars($row['name']) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge-count">
                                            <i class="fa-solid fa-chart-pie me-1"></i>
                                            <?= $row['total_habits'] ?> Habits Linked
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit_category.php?id=<?= $row['id'] ?>" class="action-link btn-edit" title="Edit Category">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $row['id'] ?>)" class="action-link btn-del" style="border:none;" title="Delete Category">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    <i class="fa-solid fa-folder-open d-block mb-3" style="font-size: 40px; opacity: 0.5;"></i>
                                    No categories found in the matrix. Create one now!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Habit yang menggunakan kategori ini akan berubah menjadi 'Uncategorized' (Aman, tidak ikut terhapus).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#0f172a',
                color: '#f8fafc'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_category.php?id=' + id;
                }
            })
        }
    </script>

</body>
</html>