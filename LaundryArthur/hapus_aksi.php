<?php
session_start();
include 'koneksi.php';

// Proteksi Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Query hapus
    $query = "DELETE FROM orders WHERE id = '$id'";
    
    if(mysqli_query($conn, $query)){
        header("Location: admin_dashboard.php?pesan=hapus_berhasil");
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    header("Location: admin_dashboard.php");
}
?>