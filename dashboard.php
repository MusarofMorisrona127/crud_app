<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user'];

// ============================
// DATA USER
// ============================
$user = $conn->query("SELECT username FROM users WHERE id=$user_id")->fetch_assoc();

// ============================
// STATISTIK
// ============================
$total_habits = $conn->query("SELECT COUNT(*) as total FROM habits WHERE user_id=$user_id")
                    ->fetch_assoc()['total'];

$today = date('Y-m-d');

$today_habits = $conn->query("SELECT COUNT(*) as total FROM habits WHERE user_id=$user_id AND date='$today'")
                    ->fetch_assoc()['total'];

$total_categories = $conn->query("SELECT COUNT(*) as total FROM categories")
                        ->fetch_assoc()['total'];

// ============================
// PROGRESS (%)
// ============================
$progress = $total_habits > 0 ? ($today_habits / $total_habits) * 100 : 0;

// ============================
// INSIGHT
// ============================
if($progress == 0){
    $insight = "Kamu belum memulai hari ini 😴";
} elseif($progress < 50){
    $insight = "Lumayan, tapi masih bisa lebih baik 🚀";
} elseif($progress < 80){
    $insight = "Keren! Kamu hampir konsisten 🔥";
} else {
    $insight = "Gila! Disiplin tingkat dewa 💪";
}

// ============================
// CHART DATA
// ============================
$chart = $conn->query("
    SELECT categories.name, COUNT(habits.id) as total
    FROM habits
    LEFT JOIN categories ON habits.category_id = categories.id
    WHERE habits.user_id=$user_id
    GROUP BY categories.name
");

$labels = [];
$values = [];

while($c = $chart->fetch_assoc()){
    $labels[] = $c['name'] ? $c['name'] : 'Tanpa Kategori';
    $values[] = $c['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Ultra</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    background: radial-gradient(circle at top, #0f172a, #020617);
    color:white;
    font-family:'Segoe UI';
}

.card {
    background: rgba(30,41,59,0.6);
    backdrop-filter: blur(12px);
    border-radius:20px;
    animation:fadeIn 0.7s ease;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

.glow {
    color:#38bdf8;
    text-shadow:0 0 12px #38bdf8;
}

.btn-neon {
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    transition:0.3s;
}

.btn-blue { background: linear-gradient(45deg,#06b6d4,#3b82f6); }
.btn-purple { background: linear-gradient(45deg,#a78bfa,#7c3aed); }
.btn-green { background: linear-gradient(45deg,#22c55e,#16a34a); }

.btn-neon:hover {
    transform:scale(1.05);
    box-shadow:0 0 10px rgba(255,255,255,0.2);
}

/* PROGRESS BAR */
.progress {
    height: 25px;
    border-radius: 20px;
    background: #1e293b;
}

.progress-bar {
    background: linear-gradient(90deg,#06b6d4,#3b82f6);
    transition: width 1s ease;
}
</style>

</head>

<body>

<div class="container mt-5">

<!-- HEADER -->
<div class="card p-4 mb-4 shadow">
    <h2 class="glow">👋 Halo, <?= $user['username'] ?></h2>
    <p style="color:#94a3b8;">Pantau progres kebiasaanmu hari ini</p>
</div>

<!-- MENU -->
<div class="mb-4 d-flex gap-2">
    <a href="habits.php" class="btn btn-neon btn-blue">Habit</a>
    <a href="categories.php" class="btn btn-neon btn-purple">Kategori</a>
    <a href="logout.php" class="btn btn-neon btn-green">Logout</a>
</div>

<!-- STAT -->
<div class="row mb-4">

<div class="col-md-4">
<div class="card p-3 text-center">
<h3><?= $total_habits ?></h3>
<p>Total Habit</p>
</div>
</div>

<div class="col-md-4">
<div class="card p-3 text-center">
<h3><?= $today_habits ?></h3>
<p>Hari Ini</p>
</div>
</div>

<div class="col-md-4">
<div class="card p-3 text-center">
<h3><?= $total_categories ?></h3>
<p>Kategori</p>
</div>
</div>

</div>

<!-- PROGRESS -->
<div class="card p-4 mb-4 shadow">
<h4 class="glow">Progress Hari Ini</h4>

<div class="progress mt-3">
<div class="progress-bar" style="width: <?= $progress ?>%;">
<?= round($progress) ?>%
</div>
</div>

<p class="mt-3"><?= $insight ?></p>
</div>

<!-- CHART -->
<div class="card p-4 shadow">
<h4 class="glow">Statistik Kategori</h4>
<canvas id="chart"></canvas>
</div>

</div>

<script>
new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Habit',
            data: <?= json_encode($values) ?>
        }]
    }
});
</script>

</body>
</html>