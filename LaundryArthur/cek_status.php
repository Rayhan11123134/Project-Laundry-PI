<?php 
session_start();
include 'koneksi.php'; 

$user_login = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';

// Query untuk menarik data (sesuaikan 'orders' dengan nama tabelmu)
if ($user_login == 'Arthur' || $user_login == '') {
    $query = "SELECT * FROM orders ORDER BY id DESC";
} else {
    $query = "SELECT * FROM orders WHERE nama = '$user_login' ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan - LaundryArthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fe; }
        .main-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; }
        .order-item { border: 2px solid #eef2f7; border-radius: 15px; margin-bottom: 15px; }
        .highlight-me { border-left: 5px solid #0d6efd; background-color: #f0f7ff; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Lacak Laundry Kamu</h2>
        <p class="text-muted">Update otomatis setiap beberapa detik</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card main-card p-4">
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $nama_db = isset($row['nama']) ? $row['nama'] : 'Pelanggan';
                        // Sesuaikan nama kolom harga (tadi error karena 'total_harga')
                        $harga = isset($row['harga']) ? $row['harga'] : 0;
                        $is_mine = ($user_login == $nama_db) ? 'highlight-me' : '';
                ?>
                    <div class="card p-3 order-item <?php echo $is_mine; ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold"><?php echo $nama_db; ?></h5>
                                <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                                    🏷️ ID Order: #<?php echo $row['id']; ?>
                                </p>
                            </div>
                            <div class="text-end">
                                <h5 class="fw-bold text-primary mb-1">Rp<?php echo number_format($harga, 0, ',', '.'); ?></h5>
                                <span class="badge bg-warning text-dark"><?php echo isset($row['status']) ? $row['status'] : 'Pending'; ?></span>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo '<div class="text-center py-5"><p class="text-muted">Belum ada data pesanan.</p></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>