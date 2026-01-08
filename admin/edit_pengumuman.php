<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['user'])) {
    header("location:login.php");
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM pengumuman WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    
    if(mysqli_num_rows($query) < 1) {
        header("location:admin.php");
    }
} else {
    header("location:admin.php");
}

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    $update = mysqli_query($koneksi, "UPDATE pengumuman SET 
                            judul='$judul', 
                            kategori='$kategori', 
                            isi='$isi' 
                            WHERE id='$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal update data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0"><i class="bi bi-pencil-square text-primary"></i> Edit Pengumuman</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <form method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Pengumuman</label>
                                <input type="text" name="judul" class="form-control" 
                                       value="<?= $data['judul'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="Jadwal Ujian" <?= ($data['kategori'] == 'Jadwal Ujian') ? 'selected' : '' ?>>Jadwal Ujian</option>
                                    <option value="Perubahan Kelas" <?= ($data['kategori'] == 'Perubahan Kelas') ? 'selected' : '' ?>>Perubahan Kelas</option>
                                    <option value="Beasiswa" <?= ($data['kategori'] == 'Beasiswa') ? 'selected' : '' ?>>Beasiswa</option>
                                    <option value="Informasi Penting" <?= ($data['kategori'] == 'Informasi Penting') ? 'selected' : '' ?>>Informasi Penting</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Isi Detail Informasi</label>
                                <textarea name="isi" class="form-control" rows="6" required><?= $data['isi'] ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="dashboard.php" class="btn btn-secondary px-4">Batal</a>
                                <button type="submit" name="update" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>