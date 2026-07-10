<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM orders WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $d['id'] ?> - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: white; font-size: 14px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; }
        }
    </style>
</head>
<body>

<div class="container my-5 invoice-box">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-primary">Laundry Arthur</h2>
            <p class="text-muted small">Jl. Contoh Alamat No. 123, Jakarta<br>Telp: 0812-3456-7890</p>
        </div>
        <div class="text-end">
            <h4 class="fw-bold">INVOICE</h4>
            <p class="mb-0">ID Pesanan: #<?= $d['id'] ?></p>
            <p>Tanggal: <?= date('d/m/Y') ?></p>
        </div>
    </div>

    <hr>

    <div class="row my-4">
        <div class="col-6">
            <p class="mb-1 text-muted">Ditujukan Kepada:</p>
            <h6 class="fw-bold"><?= $d['nama'] ?></h6>
        </div>
        <div class="col-6 text-end">
            <p class="mb-1 text-muted">Status Pesanan:</p>
            <span class="badge bg-dark"><?= $d['status'] ?></span>
        </div>
    </div>

    <table class="table table-bordered mt-4">
        <thead class="table-light text-center">
            <tr>
                <th>Layanan</th>
                <th>Berat (Kg)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td><?= $d['layanan'] ?></td>
                <td><?= $d['berat'] ?> kg</td>
                <td class="text-end">Rp<?= number_format($d['total'],0,',','.') ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-end">Total Bayar</th>
                <th class="text-end text-primary">Rp<?= number_format($d['total'],0,',','.') ?></th>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5 text-center small text-muted">
        <p>Terima kasih telah mempercayakan pakaian Anda kepada kami!</p>
        <div class="no-print mt-4">
            <button onclick="window.print()" class="btn btn-primary btn-sm px-4">Cetak Sekarang</button>
            <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm px-4">Kembali</a>
        </div>
    </div>
</div>

<script>
    // Otomatis buka print dialog pas halaman load
    window.onload = function() { window.print(); }
</script>

</body>
</html>