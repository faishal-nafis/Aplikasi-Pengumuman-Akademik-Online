<?php
include "koneksi.php";

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
    <title>Papan Pengumuman Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
            padding: 4rem 0 5rem 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 3rem;
            position: relative;
        }
        .search-container {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            margin: 0 auto;
            max-width: 600px;
            padding: 0 15px;
        }
        .card-pengumuman {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            height: 100%;
        }
        .card-pengumuman:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .date-badge {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top pt-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <img src="polibatam_logo_bw.png" alt="polibatam_logo_bw" height="100">
            </a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-light rounded-pill px-4 shadow-sm text-primary fw-bold">
                    <i class="bi bi-box-arrow-in-right"></i> Admin Login
                </a>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Papan Informasi Mahasiswa</h1>
            <p class="lead opacity-75 mb-4">Temukan jadwal ujian, beasiswa, dan info akademik terbaru disini.</p>
            
            <div class="search-container">
                <form action="index.php" method="GET" class="shadow rounded-pill bg-white p-1">
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-white rounded-pill ps-3">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="cari" class="form-control border-0 shadow-none" 
                               placeholder="Cari beasiswa, ujian, atau info lain..." 
                               value="<?= htmlspecialchars($keyword) ?>">
                        <button class="btn btn-primary rounded-pill px-4 m-1" type="submit">Cari</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="container mb-5 pt-3">
        
        <?php if($keyword): ?>
            <div class="mb-4">
                <h5>Hasil pencarian untuk: <span class="text-primary">"<?= htmlspecialchars($keyword) ?>"</span></h5>
                <a href="index.php" class="text-decoration-none small text-muted"><i class="bi bi-arrow-left"></i> Kembali lihat semua</a>
            </div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    
                    <?php
                        // Logika Warna Badge
                        $badgeColor = "bg-primary"; 
                        if($row['kategori'] == 'Jadwal Ujian') { $badgeColor = "bg-danger"; } 
                        else if($row['kategori'] == 'Beasiswa') { $badgeColor = "bg-success"; } 
                        else if($row['kategori'] == 'Perubahan Kelas') { $badgeColor = "bg-warning text-dark"; } 
                    ?>

                    <div class="col">
                        <div class="card card-pengumuman shadow-sm h-100">
                            <div class="card-body p-4 position-relative">
                                
                                <span class="badge rounded-pill <?= $badgeColor ?> category-badge">
                                    <?= $row['kategori'] ?>
                                </span>

                                <div class="mb-2 date-badge">
                                    <i class="bi bi-calendar3"></i> 
                                    <?= date('d M Y', strtotime($row['tanggal_posting'])) ?>
                                </div>

                                <h5 class="card-title fw-bold mb-3"><?= $row['judul'] ?></h5>
                                
                                <p class="card-text text-muted">
                                    <?= nl2br(substr($row['isi'], 0, 100)) ?>...
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0 pb-4 ps-4">
                                <a href="#" class="text-decoration-none fw-bold small">Baca Selengkapnya &rarr;</a>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                
                <div class="col-12 text-center py-5">
                    <div class="text-muted opacity-50 mb-3">
                        <i class="bi bi-search" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted">Oops! Data tidak ditemukan.</h4>
                    <p>Coba gunakan kata kunci lain seperti "Ujian" atau "Beasiswa".</p>
                    <a href="index.php" class="btn btn-outline-primary rounded-pill mt-2">Tampilkan Semua</a>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <footer class="bg-white text-center py-4 border-top mt-auto">
        <div class="container">
            <p class="text-muted mb-0 small">&copy; 2025 Portal Informasi Kampus.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>