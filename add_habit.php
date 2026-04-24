<?php
session_start();
include 'koneksi.php';

// Cek sesi login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user'];

// Ambil semua kategori untuk Dropdown (Pilihan)
$kategori_query = $conn->query("SELECT * FROM categories ORDER BY name ASC");

// Proses jika tombol submit ditekan
if(isset($_POST['submit'])){
    $habit_name = $_POST['habit_name'];
    $category_id = empty($_POST['category_id']) ? NULL : $_POST['category_id']; // Bisa tanpa kategori
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Simpan ke database (Pakai Prepared Statement agar aman dari serangan)
    $stmt = $conn->prepare("INSERT INTO habits (user_id, category_id, habit_name, description, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $category_id, $habit_name, $description, $date);
    
    if($stmt->execute()){
        header("Location: habits.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Habit | Premium Web3 Style</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ===== BACKGROUND & LAYOUT ===== */
        body { 
            background-color: #020617; /* Very Dark Blue/Black */
            color: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* ===== ANIMATED GLOWING ORBS (Efek Web Crypto) ===== */
        .orb-1, .orb-2 {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            animation: float 10s infinite alternate ease-in-out;
        }
        .orb-1 {
            width: 300px; height: 300px;
            background: rgba(56, 189, 248, 0.4); /* Cyan Glow */
            top: 10%; left: 15%;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: rgba(167, 139, 250, 0.3); /* Purple Glow */
            bottom: 10%; right: 10%;
            animation-delay: -5s;
        }
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(50px) scale(1.1); }
        }

        /* ===== GLASSMORPHISM CARD ===== */
        .crypto-card { 
            background: rgba(15, 23, 42, 0.4); 
            backdrop-filter: blur(20px); 
            border-radius: 24px; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            padding: 40px; 
            width: 100%; 
            max-width: 550px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); 
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1); 
            position: relative;
            z-index: 10;
        }
        @keyframes slideUp { 
            from { opacity: 0; transform: translateY(40px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        /* ===== TYPOGRAPHY ===== */
        .glow-title { 
            background: linear-gradient(to right, #38bdf8, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center; 
            font-weight: 700; 
            font-size: 28px;
            margin-bottom: 30px; 
            letter-spacing: 1px;
        }

        /* ===== INPUT FIELDS (NEON FOCUS) ===== */
        .form-label {
            color: #94a3b8;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        input, textarea, select { 
            background: rgba(30, 41, 59, 0.5) !important; 
            color: #e2e8f0 !important; 
            border: 1px solid rgba(255, 255, 255, 0.1) !important; 
            border-radius: 12px !important; 
            padding: 14px !important; 
            font-size: 15px !important;
            transition: all 0.3s ease !important;
        }
        input:focus, textarea:focus, select:focus { 
            background: rgba(30, 41, 59, 0.8) !important;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.3) !important; 
            border-color: #38bdf8 !important; 
            outline: none !important;
        }
        /* Style untuk option di dalam select (khusus dark mode) */
        option { background-color: #0f172a; color: #fff; }

        /* ===== BUTTONS (GLOW & HOVER) ===== */
        .btn-neon { 
            border: none; 
            padding: 14px; 
            border-radius: 12px; 
            font-weight: 600; 
            font-size: 16px;
            letter-spacing: 1px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            width: 100%; 
            margin-top: 15px; 
            color: white;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-gradient { 
            background: linear-gradient(135deg, #0ea5e9, #6366f1); 
            box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.8);
        }
        .btn-gradient:hover { 
            transform: translateY(-3px) scale(1.02); 
            box-shadow: 0 15px 25px -10px rgba(99, 102, 241, 1); 
            color: white;
        }
        
        .btn-outline-red { 
            background: transparent; 
            color: #f87171; 
            border: 1px solid rgba(248, 113, 113, 0.3); 
            text-decoration: none; 
            display: block; 
            text-align: center; 
        }
        .btn-outline-red:hover { 
            background: rgba(248, 113, 113, 0.1);
            border-color: #f87171;
            color: #fca5a5;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="orb-1"></div>
    <div class="orb-2"></div>

    <div class="crypto-card">
        <h3 class="glow-title">✨ Create New Habit</h3>
        
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">NAMA HABIT</label>
                <input type="text" name="habit_name" class="form-control" placeholder="Contoh: Belajar Smart Contract" required autocomplete="off">
            </div>

            <div class="mb-4">
                <label class="form-label">PILIH KATEGORI</label>
                <select name="category_id" class="form-control" style="cursor: pointer;">
                    <option value="">-- Tanpa Kategori --</option>
                    <?php while($kat = $kategori_query->fetch_assoc()): ?>
                        <option value="<?= $kat['id'] ?>"><?= $kat['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">DESKRIPSI (OPSIONAL)</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Tulis rincian aktivitasmu..."></textarea>
            </div>

            <div class="mb-5">
                <label class="form-label">TANGGAL MULAI</label>
                <input type="date" name="date" class="form-control" required style="cursor: pointer;">
            </div>

            <button type="submit" name="submit" class="btn-neon btn-gradient">SIMPAN HABIT 🚀</button>
            <a href="habits.php" class="btn-neon btn-outline-red mt-3">BATAL & KEMBALI</a>
        </form>
    </div>

</body>
</html>