<?php 
session_start();
include 'koneksi.php';

// PROTEKSI: Jika belum login, wajib ke halaman login dulu
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu untuk melakukan pemesanan!'); 
            window.location.href='login.php';
          </script>";
    exit;
}

$username_aktif = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Laundry - LaundryArthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', sans-serif; }
        .order-card { border: none; border-radius: 25px; max-width: 550px; margin: 40px auto; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .order-header { background: #0d6efd; color: white; padding: 30px; text-align: center; }
        .input-group-custom { background: white; border: 1px solid #dee2e6; border-radius: 12px; padding: 10px 15px; display: flex; align-items: center; margin-bottom: 15px; }
        .input-group-custom i { color: #0d6efd; margin-right: 12px; font-size: 1.2rem; }
        .input-group-custom select, .input-group-custom input { border: none; width: 100%; background: transparent; outline: none; }
        .btn-order { background: #0d6efd; color: white; border: none; width: 100%; padding: 14px; border-radius: 12px; font-weight: bold; transition: 0.3s; }
        .btn-order:hover { background: #0056b3; }
        .hidden-element { display: none; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card order-card bg-white">
        <div class="order-header">
            <h3 class="fw-bold mb-1">Form Order</h3>
            <p class="mb-0 opacity-75">Lengkapi data pakaian yang ingin di-laundry</p>
        </div>
        <div class="card-body p-4">
            <form action="proses_order.php" method="POST">
                
                <label class="fw-bold mb-2 small text-uppercase">Nama Pelanggan</label>
                <div class="input-group-custom">
                    <i class="bi bi-person-fill"></i>
                    <input type="text" name="nama" value="<?= htmlspecialchars($username_aktif) ?>" readonly required>
                </div>

                <label class="fw-bold mb-2 small text-uppercase">Nomor WhatsApp</label>
                <div class="input-group-custom">
                    <i class="bi bi-whatsapp"></i>
                    <input type="number" name="nomor_hp" placeholder="Contoh: 08123456789" required>
                </div>

                <label class="fw-bold mb-2 small text-uppercase">1. Pilih Jenis Cucian</label>
                <div class="input-group-custom">
                    <i class="bi bi-tags-fill"></i>
                    <select name="jenis_cucian" id="jenis_cucian" required onchange="updateOpsiLayanan()">
                        <option value="" disabled selected>-- Pilih Jenis Cucian --</option>
                        <option value="Pakaian / Kiloan">Pakaian / Kiloan</option>
                        <option value="Pakaian Khusus / Jas">Pakaian Khusus / Jas / Kebaya</option>
                        <option value="Bedcover">Bedcover</option>
                        <option value="Selimut">Selimut</option>
                        <option value="Sepatu">Sepatu</option>
                    </select>
                </div>

                <div id="section_layanan" class="hidden-element">
                    <label class="fw-bold mb-2 small text-uppercase" id="label_layanan">2. Pilih Layanan</label>
                    <div class="input-group-custom">
                        <i class="bi bi-gear-wide-connected"></i>
                        <select name="layanan" id="layanan" required>
                            </select>
                    </div>

                    <label class="fw-bold mb-2 small text-uppercase" id="label_berat">Estimasi Jumlah / Berat</label>
                    <div class="input-group-custom">
                        <i class="bi bi-box-seam"></i>
                        <select name="berat" id="berat" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>

                    <div class="alert alert-warning py-2 px-3 border-0 shadow-sm mb-4" style="border-radius: 12px; font-size: 0.8rem;">
                        <i class="bi bi-info-circle-fill me-1"></i> 
                        <strong>Note:</strong> Hitungan final total harga tetap akan dikonfirmasi kembali secara akurat saat barang tiba di toko.
                    </div>

                    <button type="submit" class="btn-order shadow">Konfirmasi Order</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function updateOpsiLayanan() {
    var jenisCucian = document.getElementById("jenis_cucian").value;
    var sectionLayanan = document.getElementById("section_layanan");
    var dropdownLayanan = document.getElementById("layanan");
    var labelBerat = document.getElementById("label_berat");
    
    // Kosongkan pilihan layanan sebelumnya
    dropdownLayanan.innerHTML = "";

    if (jenisCucian === "") {
        sectionLayanan.classList.add("hidden-element");
        return;
    }

    // Munculkan section layanan
    sectionLayanan.classList.remove("hidden-element");

    // Suntik data option berdasarkan jenis cucian pilihan
    if (jenisCucian === "Pakaian / Kiloan") {
        labelBerat.innerText = "Estimasi Berat (Kg)";
        dropdownLayanan.innerHTML = `
            <option value="Cuci Kering">Cuci Kering (Reguler)</option>
            <option value="Cuci Setrika">Cuci Setrika (Premium)</option>
            <option value="Express">Express (Selesai < 24 Jam)</option>
        `;
    } else if (jenisCucian === "Pakaian Khusus / Jas") {
        labelBerat.innerText = "Jumlah Pakaian (Pcs)";
        dropdownLayanan.innerHTML = `
            <option value="Dry Cleaning">Dry Cleaning (Perawatan Khusus Bahan)</option>
            <option value="Cuci Satuan Premium">Cuci Satuan Premium</option>
        `;
    } else if (jenisCucian === "Bedcover" || jenisCucian === "Selimut") {
        labelBerat.innerText = "Jumlah Cucian (Pcs)";
        dropdownLayanan.innerHTML = `
            <option value="Cuci Premium">Cuci Premium Bersih & Wangi</option>
        `;
    } else if (jenisCucian === "Sepatu") {
        labelBerat.innerText = "Jumlah Sepatu (Pasang)";
        dropdownLayanan.innerHTML = `
            <option value="Deep Cleaning">Deep Cleaning (Cuci Bersih Total)</option>
            <option value="Unyellowing">Unyellowing (Menghilangkan Jamur/Kuning)</option>
        `;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>