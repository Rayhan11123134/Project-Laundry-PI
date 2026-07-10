<?php
session_start();
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nama      = trim($_POST['nama']);
    $email     = trim($_POST['email']);
    $no_hp     = trim($_POST['no_hp']);
    $password  = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    // Validasi Password Konfirmasi
    if ($password !== $konfirmasi) {
        $error = "Password tidak sama!";
    } elseif (strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";
    } else {
        // Cek apakah email sudah terdaftar
        $cek = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($cek, "s", $email);
        mysqli_stmt_execute($cek);
        $result = mysqli_stmt_get_result($cek);

        if (mysqli_num_rows($result) > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert ke database
            $stmt = mysqli_prepare($conn, "INSERT INTO users (nama, email, no_hp, password, role) VALUES (?, ?, ?, ?, 'user')");
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $no_hp, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Register berhasil! Silakan login.'); window.location='login.php';</script>";
                exit;
            } else {
                $error = "Gagal mendaftar!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #0d6efd 0%, #003d99 100%); min-height: 100vh; display: flex; align-items: center; }
        .reg-card { border: none; border-radius: 25px; box-shadow: 0 15px 45px rgba(0,0,0,0.2); background: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="reg-card p-4 p-md-5">
                <h3 class="fw-bold text-center mb-4">Register Akun</h3>
                
                <form method="POST">
                    <?php if(isset($error)){ echo "<div class='alert alert-danger py-2 small text-center'>$error</div>"; } ?>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control rounded-pill px-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill px-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor HP</label>
                        <input type="number" name="no_hp" class="form-control rounded-pill px-4" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control rounded-pill px-4" required minlength="8">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi" class="form-control rounded-pill px-4" required>
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-dark w-100 rounded-pill py-2 fw-bold shadow">Daftar Akun</button>
                    <p class="text-center mt-4 small mb-0">Sudah punya akun? <a href="login.php" class="text-primary text-decoration-none fw-bold">Login aja</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>