<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user'])) {
    header("location:login.php");
    exit();
}

$user = $_SESSION['user'];

$query = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY tanggal_posting DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin/Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: rgba(255,255,255,.75); }
        .nav-link:hover { color: white; }
        .nav-link.active { color: white; background: #0d6efd; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 d-md-block sidebar p-3 shadow">
            <img src="polibatam_logo_bw.png" alt="logo" class="img-fluid mb-3">
            <hr>
            <nav class="nav flex-column">
                <a class="nav-link active mb-2" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                <a class="nav-link mb-2" href="tambah_pengumuman.php"><i class="bi bi-megaphone me-2"></i> Buat Info</a>
                <hr>
                <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a>
            </nav>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kelola Pengumuman</h2>
                <div class="text-end">
                    <span class="badge bg-primary p-2">Login sebagai: <?= $user['username'] ?></span>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Daftar Informasi Mahasiswa</h5>
                        <a href="tambah_pengumuman.php" class="btn btn-success btn-sm"><i class="bi bi-plus-lg"></i> Tambah Pengumuman</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Isi</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while($row = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-bold"><?= $row['judul'] ?></td>
                                    <td><span class="badge bg-info text-dark"><?= $row['kategori'] ?></span></td>
                                    <td><?= substr($row['isi'], 0, 50) ?>...</td>
                                    <td class="small"><?= date('d M Y', strtotime($row['tanggal_posting'])) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="edit_pengumuman.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                            <a href="hapus_pengumuman.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>