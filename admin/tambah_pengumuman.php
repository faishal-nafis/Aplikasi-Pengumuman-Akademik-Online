<?php
session_start();
include "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $isi = $_POST['isi'];

    $insert = mysqli_query($koneksi, "INSERT INTO pengumuman (judul, kategori, isi) VALUES ('$judul', '$kategori', '$isi')");

    if ($insert) {
        echo "<script>alert('Berhasil diposting!'); location.href='admin.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 shadow rounded-3" style="max-width: 600px;">
        <h3><i class="bi bi-megaphone"></i> Buat Informasi Baru</h3>
        <hr>
        <form method="POST">
            <div class="mb-3">
                <label>Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori" class="form-select">
                    <option>Jadwal Ujian</option>
                    <option>Perubahan Kelas</option>
                    <option>Beasiswa</option>
                    <option>Informasi Penting</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Isi Detail Informasi</label>
                <textarea name="isi" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Posting Sekarang</button>
            <a href="admin.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>