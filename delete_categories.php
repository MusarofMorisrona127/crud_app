<?php
// ==========================================
// SESSION & KONEKSI DATABASE
// ==========================================
session_start();
include 'koneksi.php';

// Proteksi keamanan: Tendang user yang belum login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID kategori yang dikirim dari URL
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // ==========================================
    // LANGKAH 1: PROTEKSI DATA HABIT (SMART DELETE)
    // ==========================================
    // Kita set habit yang memakai kategori ini menjadi NULL (Uncategorized)
    // Tujuannya agar data habit pengguna tidak ikut hilang atau memicu error database.
    $stmt_update = $conn->prepare("UPDATE habits SET category_id = NULL WHERE category_id = ?");
    $stmt_update->bind_param("i", $id);
    $stmt_update->execute();

    // ==========================================
    // LANGKAH 2: EKSEKUSI HAPUS KATEGORI
    // ==========================================
    // Setelah data habit aman, baru kita hapus kategorinya dari database
    $stmt_delete = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
}

// Terakhir, langsung lempar kembali user ke halaman matrix kategori
header("Location: categories.php");
exit;
?>