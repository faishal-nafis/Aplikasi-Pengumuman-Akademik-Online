<?php
session_start();
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - Username</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            /* --- BAGIAN GANTI GAMBAR --- */
            /* Ganti link di dalam url('...') dengan link gambar Anda sendiri */
            /* Bisa link online (https://...) atau file lokal (gambar.jpg) */
            background-image: url('bglogin.jpg');
            
            /* Pengaturan agar gambar memenuhi layar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        /* Overlay Hitam Transparan (Supaya teks form terbaca jelas) */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Tingkat kegelapan 40% */
            z-index: -1;
        }

        .card-login {
            border: none;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.9); /* Latar putih sedikit transparan */
            backdrop-filter: blur(5px); /* Efek blur di belakang kartu */
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .card-header-custom {
            text-align: center;
            padding-top: 2rem;
        }

        .btn-custom-primary {
            background: #4e54c8;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 84, 200, 0.4);
        }
    </style>
</head>
<body>

    <?php
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            // Contoh query untuk memeriksa kredensial pengguna
            $query = mysqli_query($koneksi, "SELECT*FROM user where username='$username' and password='$password'");

            if (mysqli_num_rows($query) > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['user'] = $data;
                echo "<script>alert('Selamat datang, Administrator dan Dosen!'); location.href='admin.php';</script>";
            }
            else {
                echo "<script>alert('Login gagal! Periksa username dan password Anda.');</script>";
            }
        }   
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="card card-login p-4">
                    <div class="card-header-custom mb-3">
                        <div class="mb-3">
                            <img src="polibatam.png" alt="logo_polibatam" width="100">
                        </div>
                        <h3 class="fw-bold text-dark">Halo! Administrator dan Dosen</h3>
                        <p class="text-muted small">Masukkan username dan password</p>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                                <label for="floatingInput">
                                    <i class="bi bi-person me-1"></i> Username
                                </label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                <label for="floatingPassword">
                                    <i class="bi bi-lock me-1"></i> Password
                                </label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label text-secondary small" for="rememberMe">Ingat Saya</label>
                                </div>
                                <a href="#" class="text-decoration-none small text-primary fw-bold">Lupa Password?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-custom-primary w-100 rounded-pill">
                                    MASUK
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