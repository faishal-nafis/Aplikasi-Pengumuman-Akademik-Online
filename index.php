<?php
require_once __DIR__ . "/config/koneksi.php";

// --- LOGIKA PENCARIAN ---
$keyword = ""; 
if (isset($_GET['cari'])) {
    $keyword = $_GET['cari'];
    $safe_keyword = mysqli_real_escape_string($koneksi, $keyword);
    $sql = "SELECT * FROM pengumuman 
            WHERE judul LIKE '%$safe_keyword%' 
            OR isi LIKE '%$safe_keyword%' 
            OR kategori LIKE '%$safe_keyword%'
            ORDER BY tanggal_posting DESC";
} else {
    $sql = "SELECT * FROM pengumuman ORDER BY tanggal_posting DESC";
}
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kampus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Palette Mewah */
            --bg-body: #f9f9f9;
            --black-deep: #121212;
            --black-soft: #1e1e1e;
            --gold-main: #d4af37;
            --gold-hover: #b4941f;
            --text-dark: #333333;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        h1, .navbar-brand { font-family: 'Cinzel', serif; }

        /* Navbar Glass */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Hero Section */
        .hero-section {
            background: var(--black-deep);
            color: white;
            padding: 7rem 0 6rem 0;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(var(--gold-main) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.15;
        }

        /* Tombol Emas */
        .btn-gold {
            background: var(--gold-main);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-gold:hover {
            background: var(--gold-hover);
            color: white;
            transform: translateY(-2px);
        }

        .text-gold { color: var(--gold-main) !important; }

        /* Search Bar */
        .search-container {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 600px;
            z-index: 10;
        }
        .search-box {
            background: white;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        /* Kartu Pengumuman */
        .card-pengumuman {
            border: none;
            border-radius: 12px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            border-top: 3px solid transparent;
        }
        .card-pengumuman:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.1);
            border-top: 3px solid var(--gold-main);
        }

        /* --- LOGIKA WARNA BADGE --- */
        .badge-base {
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            padding: 6px 12px;
            text-transform: uppercase;
            font-size: 0.7rem;
            color: white; /* Semua teks badge putih agar kontras */
        }

        /* 1. Merah Maroon (Jadwal Ujian) */
        .bg-maroon {
            background-color: #800000 !important;
        }

        /* 2. Ungu Tua (Perubahan Kelas) */
        .bg-purple-dark {
            background-color: #4B0082 !important; /* Indigo/Deep Purple */
        }

        /* 3. Emerald Green (Beasiswa) */
        .bg-emerald {
            background-color: #047857 !important; /* Hijau Emerald Deep */
        }

        /* 4. Royal Blue (Informasi Penting) */
        .bg-royal-blue {
            background-color: #4169E1 !important;
        }

        /* Default (Hitam Emas - Jika kategori lain) */
        .bg-luxury-default {
            background-color: var(--black-deep);
            color: var(--gold-main);
            border: 1px solid var(--gold-main);
        }

        /* Link Baca Selengkapnya */
        .read-more-link {
            color: var(--black-deep);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid var(--gold-main);
            padding-bottom: 2px;
            transition: all 0.3s;
        }
        .read-more-link:hover {
            background: var(--gold-main);
            color: white;
        }

        footer {
            background: var(--black-deep);
            color: rgba(255,255,255,0.6);
            border-top: 3px solid var(--gold-main);
        }

        @media (max-width: 768px) {
            .hero-section { padding: 6rem 0 5rem 0; text-align: center; }
            .display-4 { font-size: 2rem; }
            .btn-login-text { display: none; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
                <img src="assets/images/polibatam_logo_black.png" alt="Logo" height="40">
                <span class="text-black d-none d-sm-block">INFO<span class="text-gold">KAMPUS</span></span>
            </a>
            <div class="ms-auto">
                <a href="auth/login.php" class="btn btn-dark rounded-pill px-4 btn-sm fw-bold border-0">
                    <i class="bi bi-shield-lock-fill text-gold me-1"></i> 
                    <span class="btn-login-text">Admin Area</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container position-relative z-2">
            <span class="text-gold fw-bold text-uppercase ls-2 small mb-2 d-block">Portal Akademik Resmi</span>
            <h1 class="display-4 fw-bold text-white mb-3">Papan Informasi Mahasiswa</h1>
            <p class="lead text-white-50 mb-5 px-3">Akses cepat jadwal, beasiswa, dan berita kampus terkini.</p>
            
            <div class="search-container">
                <form action="index.php" method="GET" class="search-box d-flex align-items-center">
                    <span class="ps-3 pe-2"><i class="bi bi-search text-gold fs-5"></i></span>
                    <input type="text" name="cari" class="form-control border-0 shadow-none bg-transparent" 
                           placeholder="Cari informasi..." 
                           value="<?= htmlspecialchars($keyword) ?>">
                    <button class="btn btn-gold rounded-pill px-4 fw-bold shadow-sm" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-5" style="margin-top: 5rem;">
        
        <?php if($keyword): ?>
            <div class="mb-4 text-center">
                <span class="text-muted">Hasil pencarian:</span> 
                <strong class="fs-4 d-block mt-1">"<?= htmlspecialchars($keyword) ?>"</strong>
                <a href="index.php" class="btn btn-sm btn-outline-dark rounded-pill mt-2">Reset</a>
            </div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    
                    <?php
                        // --- LOGIKA WARNA BADGE ---
                        // Default Style
                        $badgeClass = "bg-luxury-default"; 
                        
                        // Override Style berdasarkan Kategori
                        if($row['kategori'] == 'Jadwal Ujian') { 
                            $badgeClass = "bg-maroon"; 
                        } 
                        else if($row['kategori'] == 'Perubahan Kelas') { 
                            $badgeClass = "bg-purple-dark"; 
                        } 
                        else if($row['kategori'] == 'Beasiswa') { 
                            $badgeClass = "bg-emerald"; 
                        }
                        else if($row['kategori'] == 'Informasi Penting') { 
                            $badgeClass = "bg-royal-blue"; 
                        }
                    ?>

                    <div class="col">
                        <div class="card card-pengumuman h-100 position-relative">
                            <div class="card-body p-4 d-flex flex-column">
                                
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge badge-base <?= $badgeClass ?>">
                                        <?= $row['kategori'] ?>
                                    </span>
                                    <small class="text-muted fst-italic" style="font-size: 0.8rem;">
                                        <?= date('d M Y', strtotime($row['tanggal_posting'])) ?>
                                    </small>
                                </div>

                                <h4 class="card-title fw-bold mb-3" style="font-family: 'Inter', sans-serif; font-size: 1.25rem;">
                                    <?= $row['judul'] ?>
                                </h4>
                                
                                <p class="card-text text-muted small flex-grow-1" style="line-height: 1.6;">
                                    <?= nl2br(substr($row['isi'], 0, 120)) ?>...
                                </p>
                                
                                <div class="mt-4 d-flex align-items-center">
                                    <a href="pengumuman/detail.php?id=<?= $row['id'] ?>" class="read-more-link stretched-link">
                                        BACA SELENGKAPNYA
                                    </a>
                                    <i class="bi bi-arrow-right ms-2 text-gold"></i>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                
                <div class="col-12 text-center py-5">
                    <i class="bi bi-journal-x text-muted display-1 opacity-25"></i>
                    <h4 class="mt-3 text-dark">Tidak ada data.</h4>
                    <a href="index.php" class="text-gold text-decoration-none">Kembali ke beranda</a>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <footer class="py-5 mt-auto text-center">
        <div class="container">
            <h5 class="fw-bold text-white mb-3" style="font-family: 'Cinzel', serif;">POLIBATAM</h5>
            <div class="mb-4">
                <a href="#" class="text-white-50 mx-2"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white-50 mx-2"><i class="bi bi-globe"></i></a>
                <a href="#" class="text-white-50 mx-2"><i class="bi bi-linkedin"></i></a>
            </div>
            <p class="text-muted small mb-0">
                &copy; <?= date('Y') ?> Portal Informasi Kampus. All rights reserved.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>