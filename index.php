<?php
session_start();
include_once("db.php");

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Role pengguna
$role = $_SESSION['user_role'];

// Cek halaman yang diminta melalui query string
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home'

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?page=home">Home</a>
                    </li>

                    <?php if ($role == 'admin_klinik' || $role == 'dokter_klinik'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=periksa">Pemeriksaan</a>
                        </li>
                    <?php endif; ?>

                    <!-- Dropdown Daftar Poli -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPoli" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Daftar Poli
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownPoli">
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_umum">Poliklinik Umum</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_gigi">Poliklinik Gigi</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_anak">Poliklinik Anak</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Obat -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownObat" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Obat
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownObat">
                            <li><a class="dropdown-item" href="index.php?page=obat">Lihat Obat</a></li>
                        </ul>
                    </li> 

                    <!-- Dropdown Jadwal Pemeriksaan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownJadwal" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Jadwal Pemeriksaan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownJadwal">
                            <li><a class="dropdown-item" href="index.php?page=jadwal_periksa">Jadwal Periksa</a></li>
                        </ul>
                    </li> 

                    <!-- Link Pendaftaran Pasien -->
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_pasien.php">Pendaftaran Pasien</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="container">
        <?php
        // Menampilkan halaman yang sesuai berdasarkan query parameter 'page'
        switch($page) {
            case 'poliklinik_umum':
                include('poliklinik_umum.php');
                break;
            case 'poliklinik_gigi':
                include('poliklinik_gigi.php');
                break;
            case 'poliklinik_anak':
                include('poliklinik_anak.php');
                break;
            case 'obat':
                include('obat.php');
                break;
            case 'jadwal_periksa':
                include('jadwal_periksa.php');
                break;
            case 'periksa':
                include('periksa.php');
                break;
            case 'logout':
                include('logout.php');
                break;
            case 'home':
                echo "<h2>Selamat datang di Poliklinik, jangan menyerah Anda tidak sendirian!</h2>";
                echo "<p>Silakan pilih menu pada navbar untuk melanjutkan.</p>";
                break;
            default:
                echo "<h2>Halaman tidak ditemukan!</h2>";
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
