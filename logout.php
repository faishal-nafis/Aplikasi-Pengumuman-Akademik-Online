<?php
// 1. Mulai session (wajib agar PHP tahu session mana yang sedang aktif)
session_start();

// 2. Hapus semua variabel session
session_unset();

// 3. Hancurkan session sepenuhnya
session_destroy();

// 4. Tampilkan pesan notifikasi dan alihkan halaman
echo "<script>
        alert('Anda telah berhasil logout!');
        location.href = 'index.php'; 
      </script>";

?>