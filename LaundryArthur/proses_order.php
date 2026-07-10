<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$nama          = mysqli_real_escape_string($conn, $_POST['nama']);
$nomor_hp      = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
$jenis_cucian  = mysqli_real_escape_string($conn, $_POST['jenis_cucian']);
$layanan       = mysqli_real_escape_string($conn, $_POST['layanan']);
$berat         = (int)$_POST['berat'];
$tanggal       = date('Y-m-d');
$user_session  = $_SESSION['username'];

// Logika kalkulasi tarif flat/kiloan baru yang rasional
$harga_satuan = 0;

if ($jenis_cucian == "Pakaian / Kiloan") {
    if ($layanan == "Express") {
        $harga_satuan = 10000;
    } elseif ($layanan == "Cuci Setrika") {
        $harga_satuan = 7000;
    } else {
        $harga_satuan = 5000; // Cuci Kering
    }
} elseif ($jenis_cucian == "Pakaian Khusus / Jas") {
    if ($layanan == "Dry Cleaning") {
        $harga_satuan = 30000; // Harga premium per pcs jas/kebaya
    } else {
        $harga_satuan = 20000; // Cuci satuan biasa
    }
} elseif ($jenis_cucian == "Bedcover") {
    $harga_satuan = 25000; // Per Pcs
} elseif ($jenis_cucian == "Selimut") {
    $harga_satuan = 15000; // Per Pcs
} elseif ($jenis_cucian == "Sepatu") {
    if ($layanan == "Unyellowing") {
        $harga_satuan = 35000; // Per Pasang
    } else {
        $harga_satuan = 25000; // Deep Cleaning per pasang
    }
}

$total = $harga_satuan * $berat;

$query = "INSERT INTO orders (nama, nomor_hp, jenis_cucian, layanan, berat, total, status, user, tanggal) 
          VALUES ('$nama', '$nomor_hp', '$jenis_cucian', '$layanan', '$berat', '$total', 'Diterima', '$user_session', '$tanggal')";

if(mysqli_query($conn, $query)){
    echo "<script>
            alert('Order Berhasil Dibuat!'); 
            window.location.href='update_status.php';
          </script>";
    exit;
} else {
    echo "Gagal memproses transaksi: " . mysqli_error($conn);
}
?>