<?php
require_once __DIR__ . '/../config/koneksi.php';


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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-body: #f9f9f9;
            --black-deep: #121212;
            --gold-main: #d4af37;
            --text-dark: #333333;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        .article-hero {
            background: var(--black-deep);
            color: white;
            padding: 4rem 0 8rem 0;
            position: relative;
            margin-bottom: -5rem;
        }

        .article-hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(var(--gold-main) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.15;
        }

        .hero-content { position: relative; z-index: 2; }

        .article-title { font-family: 'Cinzel', serif; font-weight: 700; }

        .article-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            z-index: 3;
            background: white;
            border-top: 4px solid var(--gold-main);
        }

        .article-body {
            font-size: 1.15rem;
            line-height: 1.9;
            color: #444;
            white-space: pre-line;
        }

        .badge-base {
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 4px;
            padding: 0.6em 1.2em;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: white; 
        }

        .bg-maroon { background-color: #800000 !important; }
        .bg-purple-dark { background-color: #4B0082 !important; }
        .bg-emerald { background-color: #047857 !important; }
        .bg-royal-blue { background-color: #4169E1 !important; }
        
        .bg-luxury-default {
            background-color: rgba(255,255,255,0.1);
            border: 1px solid var(--gold-main);
            color: var(--gold-main);
        }

        .btn-back {
            background: transparent;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
        }
        .btn-back:hover {
            border-color: var(--gold-main);
            color: var(--gold-main);
            background: rgba(0,0,0,0.2);
        }

        .gold-separator {
            width: 60px; height: 4px;
            background-color: var(--gold-main);
            border-radius: 2px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <header class="article-hero">
        <div class="container hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <a href="../index.php" class="btn btn-back rounded-pill px-4">
                            <i class="bi bi-arrow-left me-2"></i> KEMBALI
                        </a>
                        <button onclick="window.print()" class="btn btn-back rounded-circle p-2" title="Cetak Info">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>

                    <div class="text-center mt-2">
                        <?php
                            // --- LOGIKA WARNA BADGE PHP ---
                            $kategori = $data['kategori'];
                            $badgeClass = "bg-luxury-default"; // Default
                            
                            if($kategori == 'Jadwal Ujian') { 
                                $badgeClass = "bg-maroon"; 
                            } 
                            else if($kategori == 'Perubahan Kelas') { 
                                $badgeClass = "bg-purple-dark"; 
                            } 
                            else if($kategori == 'Beasiswa') { 
                                $badgeClass = "bg-emerald"; 
                            }
                            else if($kategori == 'Informasi Penting') { 
                                $badgeClass = "bg-royal-blue"; 
                            }
                        ?>
                        
                        <span class="badge badge-base rounded-pill <?= $badgeClass ?> mb-4">
                            <?= $kategori ?>
                        </span>

                        <h1 class="display-4 mb-4 article-title"><?= $data['judul'] ?></h1>
                        
                        <div class="mt-3 text-white-50 text-uppercase small">
                            <span class="mx-2"><i class="bi bi-person-fill"></i> ADMIN</span>
                            <span class="mx-2">•</span>
                            <span class="mx-2"><i class="bi bi-calendar3"></i> <?= date('d F Y', strtotime($data['tanggal_posting'])) ?></span>
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
                    
                    <div class="text-center mb-5">
                        <span class="gold-separator"></span>
                    </div>

                    <div class="card-body p-0 article-body text-justify">
                        <?= nl2br($data['isi']) ?>
                    </div>

                    <hr class="my-5 opacity-25">
                    
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <span class="text-muted small fst-italic">
                            <i class="bi bi-info-circle me-1"> Informasi ini resmi dari akademik.</i>
                        </span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-whatsapp"></i></button>
                            <button class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-twitter"></i></button>
                            <button class="btn btn-outline-secondary rounded-circle btn-sm"><i class="bi bi-facebook"></i></button>
                        </div>
                    </div>

                </div>

                <div class="text-center mt-5">
                    <p class="text-muted small mb-0">
                        &copy; 2025 Portal Informasi Kampus.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>