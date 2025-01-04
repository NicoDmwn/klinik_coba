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

// Daftar Poli
$poli_list = [
    "Poliklinik Umum",
    "Poliklinik Anak",
    "Poliklinik Penyakit Dalam",
    "Poliklinik Bedah",
    "Poliklinik Kandungan",
    "Poliklinik Mata",
    "Poliklinik THT"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik Anak</title>
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
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_anak">Poliklinik Anak</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_penyakit_dalam">Poliklinik Penyakit Dalam</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_bedah">Poliklinik Bedah</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_kandungan">Poliklinik Kandungan</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_mata">Poliklinik Mata</a></li>
                            <li><a class="dropdown-item" href="index.php?page=poliklinik_tht">Poliklinik THT</a></li>
                        </ul>
                    </li>  

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Poliklinik Anak -->
    <div class="container">
        <h2>Poliklinik Anak</h2>

        <!-- Form Daftar Pasien -->
        <h5>Daftar Pasien</h5>
        <form method="POST" action="proses_daftar.php">
            <div class="mb-3">
                <label for="id_pasien" class="form-label">ID Pasien</label>
                <input type="text" class="form-control" id="id_pasien" name="id_pasien" required>
            </div>
            <div class="mb-3">
                <label for="keluhan" class="form-label">Keluhan</label>
                <textarea class="form-control" id="keluhan" name="keluhan" required></textarea>
            </div>

            <!-- Dropdown Pilih Poli -->
            <div class="mb-3">
                <label for="poli" class="form-label">Pilih Poli</label>
                <select class="form-control" id="poli" name="poli" required>
                    <?php foreach ($poli_list as $poli): ?>
                        <option value="<?php echo $poli; ?>"><?php echo $poli; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="no_antrian" class="form-label">No. Antrian</label>
                <input type="text" class="form-control" id="no_antrian" name="no_antrian" value="Automatic" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
