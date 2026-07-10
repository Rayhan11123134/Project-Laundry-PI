<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Laundry Arthur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        
        /* 📸 HERO BACKGROUND PREMIUM LAUNDRY ROOM */
        .hero-section {
    background:
        linear-gradient(
            rgba(0, 0, 0, 0.35),
            rgba(0, 0, 0, 0.35)
        ),
        url('https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?q=80&w=2000&auto=format&fit=crop');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    min-height: 80vh;
    display: flex;
    align-items: center;
    color: white;
    position: relative;
}

        /* Card Custom Design */
        .custom-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        }

        /* Floating WhatsApp Button */
        .btn-whatsapp {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color: #25d366;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: 0.3s;
        }
        .btn-whatsapp:hover {
            transform: scale(1.1);
            color: white;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<header class="hero-section text-start px-3 px-md-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <span class="badge bg-light text-primary mb-3 fw-bold px-3 py-2 rounded-pill">EST. 2026 • LAUNDRYARTHUR</span>
                <h1 class="display-3 fw-bold mb-3">Laundry Premium <br><span class="text-info">Modern</span></h1>
                <p class="lead mb-4 text-white-50 fs-5">Cepat • Bersih • Harum Maksimal.<br>Gak perlu repot, tinggal order dan pantau status laundry kamu secara realtime dari rumah.</p>
                <div class="d-flex gap-3">
                    <a href="order.php" class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2 shadow-sm">Order Sekarang</a>
                    <a href="update_status.php" class="btn btn-outline-light rounded-pill px-4 py-2">Order Status</a>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="py-5 bg-white">
    <div class="container text-center py-4">
        <span class="text-primary fw-bold text-uppercase small tracking-wider" style="letter-spacing: 1px;">What We Do</span>
        <h2 class="fw-bold text-dark mt-1 mb-3">Layanan Terbaik Kami</h2>
        <p class="text-muted mx-auto mb-5" style="max-width: 600px;">Kami menangani berbagai macam kebutuhan pencucian pakaian dan barang kesayangan Anda dengan penanganan profesional.</p>
        
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 p-4 custom-card border bg-light">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex align-items-center justify-content-center mx-auto mb-4" style="width: 55px; height: 55px;">
                        <i class="bi bi-layers fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pakaian Kiloan</h5>
                    <p class="text-muted small mb-4">Solusi cuci harian praktis. Tersedia opsi Cuci Kering, Cuci Setrika Premium, hingga Express selesai kurang dari 24 jam.</p>
                    <div class="mt-auto fw-bold text-primary">Mulai Rp5.000 / Kg</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 p-4 custom-card border bg-light">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center mx-auto mb-4" style="width: 55px; height: 55px;">
                        <i class="bi bi-clock fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Jas & Baju Khusus</h5>
                    <p class="text-muted small mb-4">Penanganan ekstra untuk pakaian formal, kebaya, jas, atau gaun mewah menggunakan teknik Dry Cleaning & handwash premium.</p>
                    <div class="mt-auto fw-bold text-danger">Mulai Rp20.000 / Pcs</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 p-4 custom-card border bg-light">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-inline-flex align-items-center justify-content-center mx-auto mb-4" style="width: 55px; height: 55px;">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Bedcover & Selimut</h5>
                    <p class="text-muted small mb-4">Pencucian menggunakan mesin khusus berkapasitas besar untuk memastikan serat kain bedcover bersih total, steril, bebas tungau, dan wangi.</p>
                    <div class="mt-auto fw-bold text-warning">Mulai Rp15.000 / Pcs</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 p-4 custom-card border bg-light">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-inline-flex align-items-center justify-content-center mx-auto mb-4" style="width: 55px; height: 55px;">
                        <span class="fw-bold" style="font-size: 1.1rem;">Ad</span>
                    </div>
                    <h5 class="fw-bold mb-2">Perawatan Sepatu</h5>
                    <p class="text-muted small mb-4">Kembalikan kebersihan sepatu kesayangan Anda dengan treatment Deep Cleaning menyeluruh atau Unyellowing untuk memutihkan sol yang menguning.</p>
                    <div class="mt-auto fw-bold text-success">Mulai Rp25.000 / Pasang</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #fff;">
    <div class="container">
        <div class="card border-0 rounded-4 p-4 p-md-5 shadow-sm" style="background: linear-gradient(135deg, #0d6efd, #00c6ff); color: white;">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h3 class="fw-bold m-0"><i class="bi bi-search me-2"></i> Lacak Pakaian Anda</h3>
                    <p class="m-0 text-white-50">Masukkan ID Order atau nama Anda untuk memantau status secara live.</p>
                </div>
                <div class="col-lg-6">
                    <form action="update_status.php" method="GET" class="input-group bg-white p-2 rounded-pill shadow-sm">
                        <input type="text" name="search" class="form-control border-0 px-3" placeholder="Masukkan ID Nota / Nama Anda..." required>
                        <button type="submit" class="btn btn-dark rounded-pill px-4 fw-semibold">Cek Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #f4f7f6;">
    <div class="container text-center py-4">
        <div class="mb-5">
            <span class="text-primary fw-bold text-uppercase small tracking-wider" style="letter-spacing: 1px;">Proses Mudah</span>
            <h2 class="fw-bold text-dark mt-1">Bagaimana Laundry Arthur Bekerja?</h2>
        </div>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <span class="fs-3">🧺</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">1. Drop Pakaian</h5>
                    <p class="text-muted small">Bawa pakaian kotor Anda ke outlet kami atau isi form orderan web.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <span class="fs-3">⚖️</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">2. Timbang & Proses</h5>
                    <p class="text-muted small">Admin akan memverifikasi muatan unit berat secara transparan ke sistem.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <span class="fs-3">🧼</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">3. Cuci Higienis</h5>
                    <p class="text-muted small">Pakaian diproses menggunakan detergen dan pewangi premium anti-bakteri.</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <span class="fs-3">🛵</span>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">4. Siap Diambil</h5>
                    <p class="text-muted small">Status otomatis berubah ke 'Selesai' dan pakaian siap diambil dalam kondisi steril.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container text-center py-4">
        <h2 class="fw-bold text-dark mb-5">Apa Kata Pelanggan?</h2>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="p-4 bg-light rounded-4 border position-relative shadow-sm">
                    <p class="text-secondary fst-italic mb-3">"Laundry di sini bener-bener mantap, bisa dipantau langsung status orderannya lewat web. Bersih banget, wangi, dan harganya masih ramah mahasiswa."</p>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span class="fw-bold text-dark">- Syaiful Usman</span>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <div class="row">

            <!-- Tentang -->
            <div class="col-md-4 mb-4">
                <h4 class="fw-bold">LaundryArthur</h4>
                <p class="text-white-50 mb-0">
                    Solusi pakaian premium modern Anda.
                </p>
            </div>

            <!-- Hubungi Kami -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Hubungi Kami</h5>

                <p class="text-white-50 mb-2">
                    <i class="bi bi-whatsapp me-2"></i> 085888457308
                </p>

                <p class="text-white-50 mb-2">
                    <i class="bi bi-clock me-2"></i>
                    Senin - Minggu, 08.00 - 20.00 WIB
                </p>
            </div>

            <!-- Informasi Lokasi -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Informasi Lokasi</h5>

                <p class="text-white-50 mb-0">
                    Jl. Sairin RT 01/RW 011,<br>
                    Kel. Tanah Baru,<br>
                    Kec. Beji,<br>
                    Kota Depok
                </p>
            </div>

        </div>

        <hr class="border-secondary">

        <div class="text-center">
            <a href="https://wa.me/6285888457308"
               target="_blank"
               class="text-success fs-3 text-decoration-none">
                <i class="bi bi-whatsapp"></i>
            </a>

            <p class="text-white-50 small mt-3 mb-0">
                &copy; 2026 LaundryArthur. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

<!-- Tombol WhatsApp -->
<a href="https://wa.me/6285888457308"
   class="btn-whatsapp"
   target="_blank">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>