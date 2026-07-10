<?php 
session_start();
include 'koneksi.php'; 
include 'navbar.php'; 

// 1. Proteksi: Wajib login
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

$user_login = $_SESSION['username'];

// 2. Query: Hanya ambil data milik user yang sedang login
// Pastikan kolom di tabel 'orders' untuk menyimpan username bernama 'user'
$q = mysqli_query($conn, "SELECT * FROM orders WHERE user='$user_login' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Laundry Saya - LaundryArthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg,#667eea,#764ba2); min-height: 100vh; color: #333; font-family: 'Segoe UI', sans-serif; }
        .card-custom { border-radius: 20px; border: none; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .step-container { display: flex; justify-content: space-between; position: relative; margin-top: 35px; margin-bottom: 20px; }
        .step-item { text-align: center; width: 100%; position: relative; }
        .circle { width: 40px; height: 40px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; color: #adb5bd; font-weight: bold; }
        .circle.active { background: #0d6efd; color: white; }
        .label { font-size: 0.75rem; font-weight: 600; color: #adb5bd; }
        .label.active { color: #0d6efd; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="card card-custom p-4">
        <h3 class="fw-bold mb-4">Status Pesanan Saya</h3>
        
        <?php 
        if(mysqli_num_rows($q) > 0){
            while($d = mysqli_fetch_array($q)){
                // Logika status untuk bar visual
                $status = $d['status'];
                $step = 0;
                if($status == 'Diterima') $step = 1;
                elseif($status == 'Dicuci') $step = 2;
                elseif($status == 'Disetrika') $step = 3;
                elseif($status == 'Selesai') $step = 4;
                elseif($status == 'Diambil') $step = 5;
        ?>
            <div class="border rounded p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">ID Order: #<?= $d['id'] ?></h5>
                        <small class="text-muted"><?= $d['layanan'] ?> - <?= $d['berat'] ?> kg</small>
                    </div>
                    <span class="badge bg-primary fs-6"><?= $status ?></span>
                </div>

                <div class="step-container">
                    <div class="step-item">
                        <div class="circle <?= $step >= 1 ? 'active' : '' ?>"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="label <?= $step >= 1 ? 'active' : '' ?>">Diterima</div>
                    </div>
                    <div class="step-item">
                        <div class="circle <?= $step >= 2 ? 'active' : '' ?>"><i class="bi bi-water"></i></div>
                        <div class="label <?= $step >= 2 ? 'active' : '' ?>">Dicuci</div>
                    </div>
                    <div class="step-item">
                        <div class="circle <?= $step >= 3 ? 'active' : '' ?>"><i class="bi bi-fire"></i></div>
                        <div class="label <?= $step >= 3 ? 'active' : '' ?>">Disetrika</div>
                    </div>
                    <div class="step-item">
                        <div class="circle <?= $step >= 4 ? 'active' : '' ?>"><i class="bi bi-bag-check"></i></div>
                        <div class="label <?= $step >= 4 ? 'active' : '' ?>">Selesai</div>
                    </div>
                    <div class="step-item">
                        <div class="circle <?= $step >= 5 ? 'active' : '' ?>"><i class="bi bi-door-open"></i></div>
                        <div class="label <?= $step >= 5 ? 'active' : '' ?>">Diambil</div>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<div class='text-center py-5'><p class='text-muted'>Belum ada riwayat pesanan.</p><a href='order.php' class='btn btn-primary'>Buat Pesanan</a></div>";
        }
        ?>
    </div>
</div>

</body>
</html>