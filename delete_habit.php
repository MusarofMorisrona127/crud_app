<?php
// ============================
// SESSION & KONEKSI
// ============================
session_start();
include 'koneksi.php';

// Jika belum login, lempar ke halaman login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

// ============================
// PROSES HAPUS (AMAN)
// ============================
// Mengecek apakah ada 'id' yang dikirim melalui URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user_id = $_SESSION['user'];

    // PREPARED STATEMENT: Mencegah SQL Injection
    // Kita juga memastikan (user_id = ?) agar user A tidak bisa menghapus habit user B
    $stmt = $conn->prepare("DELETE FROM habits WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
}

// Setelah berhasil dihapus, langsung kembalikan ke halaman habits.php
header("Location: habits.php");
exit;
?>