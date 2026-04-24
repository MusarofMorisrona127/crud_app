<?php
// ============================
// SESSION & KONEKSI DATABASE
// ============================
session_start(); // memulai session
include 'koneksi.php'; // koneksi ke database

// variabel untuk error login
$error = "";

// ============================
// PROSES LOGIN
// ============================
if(isset($_POST['login'])){

    // ambil input user
    $user = trim($_POST['username']); // hapus spasi
    $pass = $_POST['password'];

    // query aman (prepared statement)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$user);
    $stmt->execute();

    // ambil hasil query
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // cek login valid atau tidak
    if($data && password_verify($pass,$data['password'])){

        // simpan id user ke session
        $_SESSION['user'] = $data['id'];

        // pindah ke dashboard
        header("Location: dashboard.php");
        exit;

    } else {
        // jika gagal
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Habit Tracker</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS CUSTOM -->
    <link rel="stylesheet" href="style.css">

    <style>
        /* ============================
           LAYOUT UTAMA (CENTER)
        ============================ */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* card login */
        .login-card {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease; /* animasi muncul */
        }

        /* judul */
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            color: #f1f5f9; /* putih terang */
        }

        /* subjudul */
        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #94a3b8; /* abu soft */
        }

        /* link */
        a {
            color: #818cf8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #a5b4fc;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="card shadow-lg p-4">

        <!-- ============================
             JUDUL
        ============================ -->
        <h3 class="title">Habit Tracker</h3>
        <div class="subtitle">Silakan login ke akun Anda</div>

        <!-- ============================
             ERROR ALERT
        ============================ -->
        <?php if($error): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- ============================
             FORM LOGIN
        ============================ -->
        <form method="POST">

            <!-- username -->
            <div class="mb-3">
                <label class="form-label" style="color:#cbd5f5;">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <!-- password -->
            <div class="mb-3">
                <label class="form-label" style="color:#cbd5f5;">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- tombol login -->
            <button name="login" class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <!-- ============================
             LINK REGISTER
        ============================ -->
        <div class="text-center mt-3">
            Belum punya akun?
            <a href="register.php">Daftar di sini</a>
        </div>

    </div>

</div>

</body>
</html>