<?php
include "koneksi.php";

// Cek apakah ada ID di URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Ambil data berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE id='$id'");
    $data = mysqli_fetch_array($query);

    // Jika data tidak ditemukan
    if(mysqli_num_rows($query) < 1) {
        die("Data tidak ditemukan...");
    }
} else {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Header dengan Gradient */
        .article-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
            padding: 4rem 0 8rem 0; /* Padding bawah besar untuk efek menumpuk */
            position: relative;
            margin-bottom: -5rem; /* Margin negatif agar kartu naik ke atas */
        }

        /* Overlay Pattern (Hiasan Latar) */
        .article-hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.6;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Kartu Konten Utama */
        .article-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            z-index: 3;
            background: white;
        }

        .article-body {
            font-size: 1.15rem;
            line-height: 1.9;
            color: #2c3e50;
            white-space: pre-line; /* Menjaga spasi dan enter dari database */
        }

        .meta-info {
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        /* Badge Kategori */
        .badge-category {
            font-size: 0.85rem;
            padding: 0.5em 1em;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Tombol Kembali */
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: white;
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <header class="article-hero">
        <div class="container hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="index.php" class="btn btn-back rounded-pill px-4">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-back rounded-circle p-2" title="Cetak Info">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <?php
                            // Logika Warna Badge (Sama seperti index.php)
                            $kategori = $data['kategori'];
                            $badgeClass = "bg-warning text-dark"; // Default
                            if($kategori == 'Jadwal Ujian') $badgeClass = "bg-danger";
                            if($kategori == 'Beasiswa') $badgeClass = "bg-success";
                            if($kategori == 'Informasi Penting') $badgeClass = "bg-primary";
                        ?>
                        
                        <span class="badge rounded-pill <?= $badgeClass ?> badge-category mb-3">
                            <?= $kategori ?>
                        </span>

                        <h1 class="display-4 fw-bold mb-3"><?= $data['judul'] ?></h1>
                        
                        <div class="meta-info mt-3">
                            <span class="mx-2"><i class="bi bi-person-circle"></i> Admin</span>
                            <span class="mx-2">•</span>
                            <span class="mx-2"><i class="bi bi-calendar-event"></i> <?= date('d F Y', strtotime($data['tanggal_posting'])) ?></span>
                            <span class="mx-2">•</span>
                            <span class="mx-2"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($data['tanggal_posting'])) ?> WIB</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <div class="card article-card p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <span class="d-inline-block bg-primary rounded-pill" style="width: 50px; height: 5px;"></span>
                    </div>

                    <div class="card-body p-0 article-body text-justify">
                        <?= nl2br($data['isi']) ?>
                    </div>

                    <hr class="my-5 opacity-25">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            Semoga informasi ini bermanfaat.
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary rounded-circle btn-sm"><i class="bi bi-whatsapp"></i></button>
                            <button class="btn btn-outline-primary rounded-circle btn-sm"><i class="bi bi-twitter"></i></button>
                            <button class="btn btn-outline-primary rounded-circle btn-sm"><i class="bi bi-facebook"></i></button>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-4 text-muted small">
                    &copy; 2025 Portal Informasi Kampus
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>