<?php
// ============================
// SESSION & KONEKSI
// ============================
session_start();
include 'koneksi.php';

// cek login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

// ============================
// PROSES SIMPAN DATA
// ============================
if(isset($_POST['submit'])){

    // ambil input
    $habit = $_POST['habit'];
    $desc  = $_POST['desc'];
    $date  = $_POST['date'];
    $user  = $_SESSION['user'];

    // prepared statement (aman)
    $stmt = $conn->prepare("INSERT INTO habits (user_id, habit_name, description, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user, $habit, $desc, $date);

    // jalankan
    $stmt->execute();

    // kembali ke halaman utama
    header("Location: habits.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Habit</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        .fade-in {
            animation: fadeIn 0.8s ease;
        }

        .form-card {
            max-width: 500px;
            margin: auto;
        }

        label {
            color: #cbd5f5;
        }
    </style>
</head>

<body>

<div class="container mt-5 fade-in">

    <!-- CARD FORM -->
    <div class="card p-4 shadow form-card">

        <h3 style="color:#f1f5f9;">Tambah Habit</h3>
        <p style="color:#94a3b8;">Tambahkan kebiasaan baru kamu</p>

        <!-- FORM -->
        <form method="POST">

            <!-- habit -->
            <div class="mb-3">
                <label>Nama Habit</label>
                <input type="text" name="habit" class="form-control" required>
            </div>

            <!-- deskripsi -->
            <div class="mb-3">
                <label>Deskripsi</label>
                <input type="text" name="desc" class="form-control" required>
            </div>

            <!-- tanggal -->
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <!-- tombol -->
            <div class="d-flex gap-2">

                <button name="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="habits.php" class="btn btn-danger">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>