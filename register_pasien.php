<?php
include('db.php'); // Koneksi ke database

// Cek apakah form registrasi sudah disubmit
if (isset($_POST['register_pasien'])) {
    $email = $_POST['email'];              // Email pasien
    $password = $_POST['password'];        // Password pasien
    $role = 'pasien';                      // Role untuk pasien

    // Melakukan password hashing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk menyimpan data akun pasien ke database
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $hashed_password, $role);

    if ($stmt->execute()) {
        // Registrasi berhasil, menampilkan modal pop-up
        $success_message = "Registrasi akun berhasil! Anda bisa login sekarang.";
    } else {
        $error_message = "Terjadi kesalahan: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('images/dna.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            width: 400px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .form-label {
            color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header text-center">
            <h3>Registrasi Akun Pasien</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="register_pasien.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="register_pasien" class="btn btn-success w-100">Daftar Akun</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary w-100">Login</a>
            </div>
        </div>
    </div>

    <!-- Modal pop-up jika registrasi berhasil -->
    <?php if (isset($success_message)): ?>
    <div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="registrationSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationSuccessModalLabel">Pemberitahuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $success_message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Menampilkan modal pop-up jika registrasi berhasil
        <?php if (isset($success_message)): ?>
            var myModal = new bootstrap.Modal(document.getElementById('registrationSuccessModal'));
            myModal.show();
        <?php endif; ?>
    </script>

</body>
</html>