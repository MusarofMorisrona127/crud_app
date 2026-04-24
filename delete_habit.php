<?php
// ============================
// SESSION & KONEKSI DATABASE
// ============================
session_start(); // mulai session
include 'koneksi.php'; // koneksi database

// ============================
// CEK LOGIN
// ============================
if(!isset($_SESSION['user'])){
    // jika belum login, lempar ke login
    header("Location: login.php");
    exit;
}

// ============================
// AMBIL ID DARI URL
// ============================
// contoh URL: delete_habit.php?id=3
if(!isset($_GET['id'])){
    // jika tidak ada id, kembali
    header("Location: habits.php");
    exit;
}

$id = $_GET['id']; // id habit yang mau dihapus
$user_id = $_SESSION['user']; // id user login

// ============================
// HAPUS DATA (AMAN)
// ============================
// hanya hapus jika data milik user tersebut
$stmt = $conn->prepare("DELETE FROM habits WHERE id=? AND user_id=?");

// i = integer
$stmt->bind_param("ii", $id, $user_id);

// jalankan query
$stmt->execute();

// ============================
// REDIRECT KEMBALI
// ============================
header("Location: habits.php");
exit;
?>