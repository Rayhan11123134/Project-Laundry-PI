<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
            <i class="bi bi-bucket-fill text-primary"></i> 
            LaundryArthur
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle=\"collapse\" data-bs-target=\"#menu\">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="order.php">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="update_status.php">Order Status</a>
                </li>

                <li class="nav-item ms-lg-3">
                    <?php if(isset($_SESSION['username'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle rounded-pill px-4 btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username']); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow mt-2 border-0">
                                <?php if(isset($_SESSION['role']) && $_SESSION['role']=="admin"): ?>
                                    <li><a class="dropdown-item" href="admin_dashboard.php">Dashboard Admin</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-primary rounded-pill px-4 btn-sm" href="login.php">
                            <i class="bi bi-person-fill"></i> Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>