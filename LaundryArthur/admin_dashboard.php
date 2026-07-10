<?php
session_start();
include 'koneksi.php';

// PROTEKSI: Wajib admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Ambil data filter jika diinputkan admin
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

// Statistik Ringkas (Card Atas)
$total_order = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
$dicuci      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Dicuci'"));
$disetrika   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Disetrika'"));
$selesai     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status='Selesai'"));

// --- FITUR REKAP PENGHASILAN BULANAN ---
$query_rekap = "SELECT 
                    YEAR(tanggal) as tahun, 
                    MONTH(tanggal) as bulan, 
                    SUM(total) as total_pendapatan,
                    COUNT(id) as jumlah_order
                FROM orders 
                GROUP BY YEAR(tanggal), MONTH(tanggal)
                ORDER BY YEAR(tanggal) DESC, MONTH(tanggal) DESC";
$data_rekap = mysqli_query($conn, $query_rekap);

$nama_bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
// ---------------------------------------------------

// Query Data utama tabel + fitur filter status
if(!empty($filter_status)){
    $query_string = "SELECT * FROM orders WHERE status='$filter_status' ORDER BY id DESC";
} else {
    $query_string = "SELECT * FROM orders ORDER BY id DESC";
}
$data_orders = mysqli_query($conn, $query_string);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: 0.3s; }
        .table-card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
        .rekap-card { border: none; border-radius: 15px; background: linear-gradient(135deg, #2c3e50, #3498db); color: white; }
        .select-status-inline {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            cursor: pointer;
        }
        .st-diterima { background-color: #e7f1ff; color: #0d6efd; border-color: #b6d4fe; }
        .st-dicuci { background-color: #e0f7fa; color: #00838f; border-color: #b2ebf2; }
        .st-disetrika { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; }
        .st-selesai { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
        .st-diambil { background-color: #e2e3e5; color: #41464b; border-color: #d3d6d8; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-4">
    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'update_berhasil'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>Status pengerjaan berhasil diperbarui secara real-time!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'timbangan_diperbarui'): ?>
        <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-calculator-fill me-2"></i>Data berat timbangan riil dan total harga tagihan berhasil disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Administrator LaundryArthur</h2>
            <p class="text-muted mb-0">Kelola operasional cuci-setrika harian dan pantau omset bulanan</p>
        </div>
        <a href="order.php" class="btn btn-primary rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i> Tambah Order</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-white p-3 border-start border-primary border-4">
                <div class="text-muted small text-uppercase fw-bold">Total Masuk Pesanan</div>
                <h3 class="fw-bold text-dark m-0"><?= $total_order ?></h3>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-white p-3 border-start border-info border-4">
                <div class="text-muted small text-uppercase fw-bold">Sedang Dicuci</div>
                <h3 class="fw-bold text-dark m-0"><?= $dicuci ?></h3>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-white p-3 border-start border-warning border-4">
                <div class="text-muted small text-uppercase fw-bold">Sedang Disetrika</div>
                <h3 class="fw-bold text-dark m-0"><?= $disetrika ?></h3>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-white p-3 border-start border-success border-4">
                <div class="text-muted small text-uppercase fw-bold">Siap Diambil</div>
                <h3 class="fw-bold text-dark m-0"><?= $selesai ?></h3>
            </div>
        </div>
    </div>

    <div class="card rekap-card p-4 mb-4 shadow-sm">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                <i class="bi bi-wallet2 text-white fs-4 d-flex"></i>
            </div>
            <div>
                <h5 class="fw-bold m-0">Rekap Penghasilan & Omset Bulanan</h5>
                <p class="small text-white-50 m-0">Berdasarkan total kalkulasi pesanan masuk di database</p>
            </div>
        </div>
        <div class="row g-3">
            <?php 
            if(mysqli_num_rows($data_rekap) == 0){
                echo "<div class='text-white-50 small ps-3'>Belum ada data bulanan yang terekam.</div>";
            }
            while($rekap = mysqli_fetch_assoc($data_rekap)){ 
                $bulan_angka = (int)$rekap['bulan'];
                $bulan_nama = isset($nama_bulan[$bulan_angka]) ? $nama_bulan[$bulan_angka] : 'Bulan';
            ?>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="bg-white bg-opacity-10 rounded-3 p-3 border border-white border-opacity-10">
                        <div class="small text-white-50 fw-semibold text-uppercase"><?= $bulan_nama . " " . $rekap['tahun'] ?></div>
                        <h4 class="fw-bold my-1 text-warning">Rp<?= number_format($rekap['total_pendapatan'], 0, ',', '.') ?></h4>
                        <div class="small text-white-50" style="font-size: 0.8rem;"><i class="bi bi-box-seam me-1"></i><?= $rekap['jumlah_order'] ?> Pesanan tercatat</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="d-flex gap-2 mb-3 overflow-auto pb-2">
        <a href="admin_dashboard.php" class="btn btn-sm btn-<?= empty($filter_status)?'dark':'outline-dark' ?> rounded-pill px-3">Semua</a>
        <a href="admin_dashboard.php?filter_status=Diterima" class="btn btn-sm btn-<?= $filter_status=='Diterima'?'primary':'outline-primary' ?> rounded-pill px-3">Diterima</a>
        <a href="admin_dashboard.php?filter_status=Dicuci" class="btn btn-sm btn-<?= $filter_status=='Dicuci'?'info':'outline-info' ?> rounded-pill px-3">Dicuci</a>
        <a href="admin_dashboard.php?filter_status=Disetrika" class="btn btn-sm btn-<?= $filter_status=='Disetrika'?'warning':'outline-warning' ?> rounded-pill px-3">Disetrika</a>
        <a href="admin_dashboard.php?filter_status=Selesai" class="btn btn-sm btn-<?= $filter_status=='Selesai'?'success':'outline-success' ?> rounded-pill px-3">Selesai</a>
        <a href="admin_dashboard.php?filter_status=Diambil" class="btn btn-sm btn-<?= $filter_status=='Diambil'?'secondary':'outline-secondary' ?> rounded-pill px-3">Diambil</a>
    </div>

    <div class="card table-card bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">ID / Tgl</th>
                            <th>Pelanggan</th>
                            <th>Jenis Cucian</th>
                            <th>Detail Layanan</th>
                            <th>Jumlah</th>
                            <th>Total Tagihan</th>
                            <th>Update Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while($row = mysqli_fetch_assoc($data_orders)){ 
                            $hp = $row['nomor_hp'];
                            if(substr($hp, 0, 1) == '0'){ $hp = '62' . substr($hp, 1); }

                            $jenis = isset($row['jenis_cucian']) ? $row['jenis_cucian'] : 'Pakaian / Kiloan';
                            $satuan = "Kg";
                            if(strpos($jenis, 'Sepatu') !== false) { $satuan = "Pasang"; }
                            elseif(strpos($jenis, 'Jas') !== false || strpos($jenis, 'Bedcover') !== false || strpos($jenis, 'Selimut') !== false) { $satuan = "Pcs"; }

                            $select_class = "st-diterima";
                            if($row['status'] == "Dicuci") { $select_class = "st-dicuci"; }
                            elseif($row['status'] == "Disetrika") { $select_class = "st-disetrika"; }
                            elseif($row['status'] == "Selesai") { $select_class = "st-selesai"; }
                            elseif($row['status'] == "Diambil") { $select_class = "st-diambil"; }
                        ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#<?= $row['id'] ?></span>
                                <div class="text-muted small" style="font-size: 0.75rem;"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama']) ?></div>
                                <div class="text-muted small"><i class="bi bi-whatsapp text-success"></i> <?= $row['nomor_hp'] ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($jenis) ?></span></td>
                            <td class="fw-semibold text-secondary"><?= $row['layanan'] ?></td>
                            <td><span class="fw-bold"><?= $row['berat'] ?></span> <span class="text-muted small"><?= $satuan ?></span></td>
                            <td class="fw-bold text-primary">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                            
                            <td>
                                <form action="update_status_aksi.php" method="POST" class="m-0">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <select name="status_baru" class="form-select select-status-inline <?= $select_class ?>" onchange="this.form.submit()">
                                        <option value="Diterima" <?= $row['status']=='Diterima'?'selected':'' ?>>1. Diterima</option>
                                        <option value="Dicuci" <?= $row['status']=='Dicuci'?'selected':'' ?>>2. Dicuci</option>
                                        <option value="Disetrika" <?= $row['status']=='Disetrika'?'selected':'' ?>>3. Disetrika</option>
                                        <option value="Selesai" <?= $row['status']=='Selesai'?'selected':'' ?>>4. Selesai</option>
                                        <option value="Diambil" <?= $row['status']=='Diambil'?'selected':'' ?>>5. Diambil</option>
                                    </select>
                                </form>
                            </td>

                            <td class="pe-4">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="update_timbangan.php?id=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm rounded-circle p-2" title="Input Timbangan & Harga">
                                        <i class="bi bi-calculator d-flex"></i>
                                    </a>
                                    
                                    <a href="https://wa.me/<?= $hp ?>?text=Halo%20<?= urlencode($row['nama']) ?>,%20kami%20dari%20LaundryArthur.%20Pesanan%20ID%20<?= $row['id'] ?>%20(<?= urlencode($jenis) ?>)%20saat%20ini%20berstatus%20*<?= urlencode($row['status']) ?>*." target="_blank" class="btn btn-outline-success btn-sm rounded-circle p-2" title="Kirim WA">
                                        <i class="bi bi-whatsapp d-flex"></i>
                                    </a>
                                    <a href="invoice.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle p-2" title="Cetak Invoice">
                                        <i class="bi bi-printer d-flex"></i>
                                    </a>
                                    <a href="hapus_aksi.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data order ini?')" class="btn btn-outline-danger btn-sm rounded-circle p-2" title="Hapus">
                                        <i class="bi bi-trash d-flex"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>