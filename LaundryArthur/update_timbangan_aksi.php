<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id         = $_POST['id'];
    $berat_baru = $_POST['berat_baru'];
    $total_baru = $_POST['total_baru'];

    // Update data berat dan total harga riil ke database orders
    $query = "UPDATE orders SET berat='$berat_baru', total='$total_baru' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)){
        header("Location: admin_dashboard.php?pesan=timbangan_diperbarui");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
} else {
    header("Location: admin_dashboard.php");
}
?>