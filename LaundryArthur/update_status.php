<?php 
session_start();
include 'koneksi.php'; 

$user_login = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';

if ($user_login != '') {
    if ($is_admin) {
        $query = !empty($keyword) ? "SELECT * FROM orders WHERE nama LIKE '%$keyword%' ORDER BY id DESC" : "SELECT * FROM orders ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM orders WHERE user = '$user_login' OR nama = '$user_login' ORDER BY id DESC";
    }
    $result = mysqli_query($conn, $query);
}

// Daftar tahapan proses
$steps = ['Diterima', 'Dicuci', 'Disetrika', 'Selesai', 'Diambil'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Laundry - LaundryArthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; }
        .order-card { border: none; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .stepper-wrapper { display: flex; justify-content: space-between; margin: 25px 0; position: relative; padding: 0 10px; }
        .stepper-item { position: relative; display: flex; flex-direction: column; align-items: center; flex: 1; }
        .stepper-item::before { position: absolute; content: ""; border-bottom: 2px solid #dee2e6; width: 100%; top: 12px; left: -50%; z-index: 1; }
        .stepper-item:first-child::before { content: none; }
        .stepper-item .step-counter { position: relative; z-index: 5; display: flex; justify-content: center; align-items: center; width: 25px; height: 25px; border-radius: 50%; background: #dee2e6; margin-bottom: 8px; font-size: 12px; color: white; }
        .stepper-item.completed .step-counter { background: #0d6efd; }
        .stepper-item.completed::before { border-bottom: 2px solid #0d6efd; }
        .step-name { font-size: 9px; font-weight: bold; color: #6c757d; text-transform: uppercase; }
        .stepper-item.completed .step-name { color: #0d6efd; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">👕 Status Laundry Anda</h2>
        <p class="text-muted">Pantau pengerjaan pakaian Anda secara real-time</p>
    </div>

    <?php if ($user_login == ''): ?>
        <div class="card p-5 text-center shadow-sm border-0" style="border-radius: 20px;">
            <i class="bi bi-lock-fill text-primary" style="font-size: 3rem;"></i>
            <h4 class="mt-3">Fitur Pelacakan Terkunci</h4>
            <a href="login.php" class="btn btn-primary mt-3 rounded-pill">Login Sekarang</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $current_step_index = array_search($row['status'], $steps);
                    if ($current_step_index === false) $current_step_index = -1;
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card order-card h-100 p-4 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold mb-0">#<?= $row['id'] ?> - <?= htmlspecialchars($row['nama']) ?></h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill"><?= $row['status'] ?></span>
                        </div>
                        
                        <div class="stepper-wrapper">
                            <?php foreach ($steps as $index => $step): ?>
                                <div class="stepper-item <?= $index <= $current_step_index ? 'completed' : '' ?>">
                                    <div class="step-counter"><i class="bi bi-check-lg"></i></div>
                                    <div class="step-name"><?= $step ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-2 small text-muted border-top pt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Layanan:</span>
                                <span class="fw-bold text-dark"><?= $row['layanan'] ?> (<?= $row['berat'] ?>kg)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tanggal Masuk:</span>
                                <span class="fw-bold text-dark"><?= date('d M Y', strtotime($row['tanggal'])) ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Harga:</span>
                                <span class="fw-bold text-primary">Rp<?= number_format($row['total'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } } else { echo "<p class='text-center text-muted'>Tidak ada data pesanan saat ini.</p>"; } ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>