<?php
session_start();
include 'koneksi.php';

// PROTEKSI: Wajib admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Ambil ID order yang mau ditimbang
if(!isset($_GET['id'])){
    header("Location: admin_dashboard.php");
    exit;
}
$id = $_GET['id'];

// Ambil data order lama
$query = mysqli_query($conn, "SELECT * FROM orders WHERE id='$id'");
$data  = mysqli_fetch_assoc($query);

if(!$data){
    echo "Data order tidak ditemukan.";
    exit;
}

// Menentukan harga dasar per unit layanan/jenis cucian secara dinamis
// Kamu bisa menyesuaikan nominal harga per kilo/pcs/pasang di bawah ini:
$harga_per_unit = 7000; // Default Rp 7.000/kg (misal Cuci Kering/Setrika biasa)
if(strpos($data['layanan'], 'Premium') !== false || strpos($data['jenis_cucian'], 'Jas') !== false){
    $harga_per_unit = 15000; 
} elseif(strpos($data['jenis_cucian'], 'Sepatu') !== false || strpos($data['layanan'], 'Unyellowing') !== false){
    $harga_per_unit = 35000; // Contoh tarif cuci sepatu per pasang seperti di gambar
} elseif(strpos($data['layanan'], 'Express') !== false){
    $harga_per_unit = 12000;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Timbangan Riil - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .card-timbang { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-timbang p-4 bg-white">
                <div class="text-center mb-4">
                    <div class="text-primary fs-1"><i class="bi bi-balance-scale"></i></div>
                    <h4 class="fw-bold text-dark mt-2">Penimbangan & Penentuan Harga</h4>
                    <p class="text-muted small">Update berat riil pesanan #<?= $data['id'] ?> atas nama <?= htmlspecialchars($data['nama']) ?></p>
                </div>

                <form action="update_timbangan_aksi.php" method="POST">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <input type="hidden" id="harga_satuan" value="<?= $harga_per_unit ?>">

                    <div class="mb-3 bg-light p-3 rounded-3 border">
                        <div class="row small text-secondary">
                            <div class="col-6">Jenis / Layanan:</div>
                            <div class="col-6 text-end fw-bold text-dark"><?= htmlspecialchars($data['jenis_cucian']) ?> / <?= $data['layanan'] ?></div>
                        </div>
                        <hr class="my-2 text-muted">
                        <div class="row small text-secondary">
                            <div class="col-6">Estimasi Tarif Satuan:</div>
                            <div class="col-6 text-end fw-bold text-primary">Rp<?= number_format($harga_per_unit, 0, ',', '.') ?></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Berat Riil Timbangan / Jumlah Pcs</label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="berat_baru" id="berat_baru" class="form-control form-control-lg text-center fw-bold" value="<?= $data['berat'] ?>" min="0.1" required>
                            <span class="input-group-text fw-semibold bg-light">Unit / Kg</span>
                        </div>
                        <div class="form-text text-muted" style="font-size: 0.75rem;">Gunakan tanda titik (.) untuk nilai desimal, misal: 3.5</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Kalkulasi Total Tagihan Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white fw-bold">Rp</span>
                            <input type="text" id="total_harga_tampil" class="form-control form-control-lg fw-bold text-primary bg-white" readonly value="<?= number_format($data['total'], 0, ',', '.') ?>">
                            <input type="hidden" name="total_baru" id="total_baru" value="<?= $data['total'] ?>">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold fs-6"><i class="bi bi-check-circle me-1"></i> Simpan & Perbarui Tagihan</button>
                        <a href="admin_dashboard.php" class="btn btn-light rounded-3 text-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi JavaScript untuk menghitung total harga secara real-time saat angka berat diketik admin
const inputBerat = document.getElementById('berat_baru');
const hargaSatuan = document.getElementById('harga_satuan').value;
const totalTampil = document.getElementById('total_harga_tampil');
const totalInput = document.getElementById('total_baru');

inputBerat.addEventListener('input', function() {
    let berat = parseFloat(this.value);
    if (isNaN(berat) || berat < 0) berat = 0;
    
    let totalHitung = Math.round(berat * hargaSatuan);
    
    totalInput.value = totalHitung;
    totalTampil.value = new Intl.NumberFormat('id-ID').format(totalHitung);
});
</script>
</body>
</html>