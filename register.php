<?php
// ============================
// KONEKSI DATABASE
// ============================
include 'koneksi.php';

// variabel pesan
$error = "";
$success = "";

// ============================
// PROSES REGISTER
// ============================
if(isset($_POST['register'])){

    // ambil input
    $user = trim($_POST['username']);
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];

    // ============================
    // VALIDASI
    // ============================

    // cek password sama atau tidak
    if($pass !== $confirm){
        $error = "Konfirmasi password tidak sama!";
    } else {

        // cek username sudah ada atau belum
        $cek = $conn->prepare("SELECT id FROM users WHERE username=?");
        $cek->bind_param("s",$user);
        $cek->execute();
        $result = $cek->get_result();

        if($result->num_rows > 0){
            $error = "Username sudah digunakan!";
        } else {

            // hash password
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            // insert user baru
            $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?,?)");
            $stmt->bind_param("ss",$user,$hash);
            $stmt->execute();

            // pesan sukses
            $success = "Registrasi berhasil! Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Habit Tracker</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS CUSTOM -->
    <link rel="stylesheet" href="style.css">

    <style>
        /* layout center */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* card */
        .register-card {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease;
        }

        /* judul */
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            color: #f1f5f9;
        }

        /* subjudul */
        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #94a3b8;
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

<div class="register-card">

    <div class="card shadow-lg p-4">

        <!-- ============================
             JUDUL
        ============================ -->
        <h3 class="title">Buat Akun</h3>
        <div class="subtitle">Daftar untuk mulai menggunakan Habit Tracker</div>

        <!-- ============================
             ALERT ERROR
        ============================ -->
        <?php if($error): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- ============================
             ALERT SUCCESS
        ============================ -->
        <?php if($success): ?>
            <div class="alert alert-success text-center">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- ============================
             FORM REGISTER
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

            <!-- konfirmasi password -->
            <div class="mb-3">
                <label class="form-label" style="color:#cbd5f5;">Konfirmasi Password</label>
                <input type="password" name="confirm" class="form-control" required>
            </div>

            <!-- tombol daftar -->
            <button name="register" class="btn btn-success w-100">
                Daftar
            </button>

        </form>

        <!-- ============================
             LINK LOGIN
        ============================ -->
        <div class="text-center mt-3">
            Sudah punya akun?
            <a href="login.php">Login di sini</a>
        </div>

    </div>

</div>

</body>
</html>