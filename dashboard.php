<?php
// ============================
// SESSION LOGIN
// ============================
session_start();

// jika belum login, lempar ke login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Habit Tracker</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS CUSTOM -->
    <link rel="stylesheet" href="style.css">

    <style>
        /* animasi muncul */
        .fade-in {
            animation: fadeIn 1s ease;
        }

        /* card statistik */
        .stat-card {
            text-align: center;
            padding: 20px;
            border-radius: 16px;
        }

        /* judul kecil */
        .stat-title {
            font-size: 14px;
            color: #94a3b8;
        }

        /* angka */
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #f1f5f9;
        }

        /* jarak */
        .top-space {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="container mt-5 fade-in">

    <!-- ============================
         HEADER
    ============================ -->
    <div class="card p-4 shadow-lg mb-4">

        <h3 style="color:#f1f5f9;">Dashboard</h3>
        <p style="color:#94a3b8;">
            Selamat datang di Habit Tracker 👋
        </p>

    </div>

    <!-- ============================
         STATISTIK (DUMMY)
         (biar kelihatan keren)
    ============================ -->
    <div class="row">

        <div class="col-md-4">
            <div class="card stat-card shadow">
                <div class="stat-title">Total Habit</div>
                <div class="stat-value">0</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow">
                <div class="stat-title">Hari Ini</div>
                <div class="stat-value">0</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow">
                <div class="stat-title">Aktif</div>
                <div class="stat-value">0</div>
            </div>
        </div>

    </div>

    <!-- ============================
         MENU UTAMA
    ============================ -->
    <div class="card p-4 shadow-lg top-space">

        <h5 style="color:#cbd5f5;">Menu</h5>

        <div class="d-flex gap-2 mt-3">

            <!-- ke halaman habit -->
            <a href="habits.php" class="btn btn-success">
                Kelola Habit
            </a>

            <!-- logout -->
            <a href="logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</div>

</body>
</html>