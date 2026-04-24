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
// AMBIL ID DARI URL
// ============================
$id = $_GET['id'];

// ambil data berdasarkan id
$stmt = $conn->prepare("SELECT * FROM habits WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

// ============================
// PROSES UPDATE DATA
// ============================
if(isset($_POST['submit'])){

    $habit = $_POST['habit'];
    $desc  = $_POST['desc'];
    $date  = $_POST['date'];

    // update database
    $update = $conn->prepare("UPDATE habits SET habit_name=?, description=?, date=? WHERE id=?");
    $update->bind_param("sssi", $habit, $desc, $date, $id);
    $update->execute();

    header("Location: habits.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Habit</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
.form-card { max-width: 500px; margin:auto; }
label { color:#cbd5f5; }
</style>
</head>

<body>

<div class="container mt-5">

<div class="card p-4 shadow form-card">

<h3 style="color:#f1f5f9;">Edit Habit</h3>
<p style="color:#94a3b8;">Ubah data kebiasaan kamu</p>

<form method="POST">

<!-- NAMA HABIT -->
<div class="mb-3">
<label>Nama Habit</label>
<input type="text" name="habit" class="form-control"
value="<?= $data['habit_name'] ?>" required>
</div>

<!-- DESKRIPSI -->
<div class="mb-3">
<label>Deskripsi</label>
<input type="text" name="desc" class="form-control"
value="<?= $data['description'] ?>" required>
</div>

<!-- TANGGAL -->
<div class="mb-3">
<label>Tanggal</label>
<input type="date" name="date" class="form-control"
value="<?= $data['date'] ?>" required>
</div>

<!-- TOMBOL -->
<div class="d-flex gap-2">
<button name="submit" class="btn btn-primary">Update</button>
<a href="habits.php" class="btn btn-danger">Batal</a>
</div>

</form>

</div>

</div>

</body>
</html>