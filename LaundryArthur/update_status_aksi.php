<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "laundry");

// Pastikan hanya admin yang bisa akses (opsional tapi disarankan)
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status_baru = mysqli_real_escape_string($conn, $_POST['status_baru']);

    // Update status di database
    $query = "UPDATE orders SET status='$status_baru' WHERE id='$id'";

    if(mysqli_query($conn, $query)){
        header("location:admin_dashboard.php?pesan=update_berhasil");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>