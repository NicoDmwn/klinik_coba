<?php
session_start();
include_once("db.php");

// Cek apakah form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $no_rm = $_POST['no_rm'];
    
    // Masukkan data ke tabel pasien
    $sql = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) 
            VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>Pendaftaran pasien berhasil!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            font-size: 16px;
        }
        .alert {
            margin-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?page=home">Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_pasien.php">Pendaftaran Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">Pemeriksaan</a>
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
        <h2>Form Pendaftaran Pasien</h2>

        <form method="POST" action="daftar_pasien.php">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>

            <div class="mb-3">
                <label for="no_ktp" class="form-label">No KTP:</label>
                <input type="number" class="form-control" id="no_ktp" name="no_ktp" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP:</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp" required>
            </div>

            <div class="mb-3">
                <label for="no_rm" class="form-label">No Rekam Medis:</label>
                <input type="text" class="form-control" id="no_rm" name="no_rm" required>
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
