<?php
session_start();
include('db.php'); // Koneksi ke database

// Proses registrasi untuk Dokter/Admin
if (isset($_POST['register_dokter_admin'])) {
    $nama = $_POST['nama'];          // Nama dokter/admin
    $email = $_POST['email'];        // Email dokter/admin
    $password = $_POST['password'];  // Password dokter/admin
    $role = $_POST['role'];          // Role (Dokter atau Admin)

    // Cek jika email sudah ada di database
    $sql_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message_register = "Email sudah terdaftar, silakan gunakan email lain.";
    } else {
        // Melakukan password hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Query untuk menyimpan data dokter/admin ke database
        $sql = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! Silakan login.";
        } else {
            $error_message_register = "Terjadi kesalahan: " . $stmt->error;
        }
    }
}

// Proses login untuk Pasien
if (isset($_POST['login_pasien'])) {
    $email = $_POST['email_pasien'];        // Email yang dimasukkan pasien
    $password = $_POST['password_pasien'];  // Password yang dimasukkan pasien

    if (empty($email) || empty($password)) {
        $error_message_pasien = "Email atau password tidak boleh kosong!";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = 'pasien'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];

                header('Location: index.php');
                exit(); 
            } else {
                $error_message_pasien = "Password salah!";
            }
        } else {
            $error_message_pasien = "Pasien tidak ditemukan!";
        }
    }
}

// Proses login untuk Dokter/Admin
if (isset($_POST['login_dokter_admin'])) {
    $email = $_POST['email_dokter_admin'];  // Email yang dimasukkan dokter/admin
    $password = $_POST['password_dokter_admin'];  // Password yang dimasukkan dokter/admin
    $role = $_POST['role_dokter_admin'];  // Role yang dipilih (dokter/admin)

    if (empty($email) || empty($password) || empty($role)) {
        $error_message_dokter_admin = "Semua field harus diisi!";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect user to index.php after login
                header('Location: index.php');
                exit();  
            } else {
                $error_message_dokter_admin = "Password salah!";
            }
        } else {
            $error_message_dokter_admin = "Pengguna tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Login Form for Pasien -->
            <form method="POST" action="login.php">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login Pasien</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message_pasien)) { echo "<div class='alert alert-danger'>$error_message_pasien</div>"; } ?>
                        <div class="mb-3">
                            <label for="email_pasien" class="form-label">Email</label>
                            <input type="email" name="email_pasien" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_pasien" class="form-label">Password</label>
                            <input type="password" name="password_pasien" class="form-control" required>
                        </div>
                        <button type="submit" name="login_pasien" class="btn btn-success w-100">Login Pasien</button>
                    </div>
                </div>
            </form>

            <!-- Login Form for Dokter/Admin -->
            <form method="POST" action="login.php">
                <div class="card mt-4">
                    <div class="card-header text-center">
                        <h4>Login Dokter/Admin</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message_dokter_admin)) { echo "<div class='alert alert-danger'>$error_message_dokter_admin</div>"; } ?>
                        <div class="mb-3">
                            <label for="email_dokter_admin" class="form-label">Email</label>
                            <input type="email" name="email_dokter_admin" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_dokter_admin" class="form-label">Password</label>
                            <input type="password" name="password_dokter_admin" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_dokter_admin" class="form-label">Login sebagai</label>
                            <select name="role_dokter_admin" class="form-select" required>
                                <option value="dokter_klinik">Dokter Klinik</option>
                                <option value="admin_klinik">Admin Klinik</option>
                            </select>
                        </div>
                        <button type="submit" name="login_dokter_admin" class="btn btn-success w-100">Login Dokter/Admin</button>
                    </div>
                </div>
            </form>

            <!-- Registrasi Form for Dokter/Admin -->
            <form method="POST" action="login.php" class="mt-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Registrasi Dokter/Admin</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
                        <?php if (isset($error_message_register)) { echo "<div class='alert alert-danger'>$error_message_register</div>"; } ?>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Login sebagai</label>
                            <select name="role" class="form-select" required>
                                <option value="dokter_klinik">Dokter Klinik</option>
                                <option value="admin_klinik">Admin Klinik</option>
                            </select>
                        </div>
                        <button type="submit" name="register_dokter_admin" class="btn btn-primary w-100">Registrasi</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>
