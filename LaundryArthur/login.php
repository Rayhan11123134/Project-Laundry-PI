<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared Statement untuk keamanan
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['nama'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['role']     = $user['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1545173153-93d243971f4a?q=80&w=2000');
            background-size: cover; background-position: center; height: 100vh; display: flex; align-items: center; 
        }
        .login-card { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); background: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="bg-dark d-inline-block p-3 rounded-circle mb-3 shadow text-white">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold">Login</h3>
                    <p class="text-muted small">Masuk ke akun Laundry Arthur</p>
                </div>
                
                <form method="POST">
                    <?php if(isset($error)){ ?>
                        <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill px-4" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" id="password" class="form-control rounded-pill px-4" placeholder="Password" required>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" onclick="togglePassword()">
                        <label class="form-check-label small">Show Password</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow">Login Sekarang</button>
                    <p class="text-center mt-4 small mb-0">Belum punya akun? <a href="register.php" class="text-primary text-decoration-none fw-bold">Daftar di sini</a></p>
                </form>
            </div>
            <div class="text-center mt-3">
                <a href="index.php" class="text-white-50 text-decoration-none small"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    if (x.type === "password") { x.type = "text"; } 
    else { x.type = "password"; }
}
</script>
</body>
</html>