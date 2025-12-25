<?php
include "../config/koneksi.php";
$id = $_GET['id'];
$delete = mysqli_query($koneksi, "DELETE FROM pengumuman WHERE id='$id'");
header("location:admin.php");
?>