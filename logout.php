<?php
// ============================
// MULAI SESSION
// ============================
// session harus dimulai dulu sebelum dihancurkan
session_start();

// ============================
// HAPUS SEMUA DATA SESSION
// ============================
// ini akan menghapus login user
session_destroy();

// ============================
// REDIRECT KE LOGIN
// ============================
// setelah logout, kembali ke halaman login
header("Location: login.php");
exit;
?>