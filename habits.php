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

// ambil id user
$user_id = $_SESSION['user'];

// ambil data habit milik user
$data = $conn->query("SELECT * FROM habits WHERE user_id=$user_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Habit</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        .fade-in {
            animation: fadeIn 0.8s ease;
        }

        table {
            background: #1e293b;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            color: #94a3b8;
        }

        td {
            color: #e2e8f0;
        }

        .btn-warning {
            background: #facc15;
            border: none;
            color: black;
        }

        .btn-warning:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="container mt-5 fade-in">

    <!-- HEADER -->
    <div class="card p-4 shadow mb-4">
        <h3 style="color:#f1f5f9;">Data Habit</h3>
        <p style="color:#94a3b8;">Kelola kebiasaan harian kamu</p>
    </div>

    <!-- BUTTON TAMBAH -->
    <div class="mb-3">
        <a href="add_habit.php" class="btn btn-primary">
            + Tambah Habit
        </a>

        <a href="dashboard.php" class="btn btn-success">
            ← Kembali
        </a>
    </div>

    <!-- TABEL -->
    <div class="card p-3 shadow">
        <table class="table table-borderless align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Habit</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php 
            $no = 1;
            while($row = $data->fetch_assoc()): 
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['habit_name'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['date'] ?></td>

                <td>
                    <!-- EDIT -->
                    <a href="edit_habit.php?id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">
                       Edit
                    </a>

                    <!-- DELETE -->
                    <a href="delete_habit.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin hapus data ini?')">
                       Hapus
                    </a>
                </td>
            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>
    </div>

</div>

</body>
</html>