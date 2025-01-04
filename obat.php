<?php
session_start();
include('db.php'); // Koneksi ke database

// Cek apakah user sudah login dan punya role yang sesuai
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'admin_klinik')) {
    // Jika bukan admin, redirect ke index.php atau halaman lain
    header('Location: index.php');
    exit();
}

// Proses untuk menambahkan data obat (hanya untuk admin)
if (isset($_POST['tambah_obat'])) {
    $nama_obat = $_POST['nama_obat'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Validasi input
    if (empty($nama_obat) || empty($deskripsi) || empty($harga)) {
        $error_message = "Semua kolom harus diisi!";
    } else {
        // Query untuk menambahkan data obat ke database
        $sql = "INSERT INTO obat (nama_obat, deskripsi, harga) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama_obat, $deskripsi, $harga);

        if ($stmt->execute()) {
            $success_message = "Obat berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan: " . $stmt->error;
        }
    }
}

// Proses hapus obat
if (isset($_GET['hapus_obat']) && isset($_GET['id_obat'])) {
    $id_obat = $_GET['id_obat'];

    // Pastikan id_obat tidak kosong
    if (!empty($id_obat)) {
        $sql = "DELETE FROM obat WHERE id_obat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_obat); // Pastikan id_obat bertipe integer

        if ($stmt->execute()) {
            $success_message = "Obat berhasil dihapus!";
        } else {
            $error_message = "Terjadi kesalahan saat menghapus obat: " . $stmt->error;
        }
    } else {
        $error_message = "ID obat tidak ditemukan!";
    }
}

// Proses edit obat
if (isset($_GET['edit_obat']) && isset($_GET['id_obat'])) {
    $id_obat = $_GET['id_obat'];

    // Pastikan id_obat ada
    if (!empty($id_obat)) {
        // Ambil data obat yang ingin diedit
        $sql = "SELECT * FROM obat WHERE id_obat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_obat);
        $stmt->execute();
        $result = $stmt->get_result();
        $obat = $result->fetch_assoc();

        if (isset($_POST['update_obat'])) {
            $nama_obat = $_POST['nama_obat'];
            $deskripsi = $_POST['deskripsi'];
            $harga = $_POST['harga'];

            // Validasi input
            if (empty($nama_obat) || empty($deskripsi) || empty($harga)) {
                $error_message = "Semua kolom harus diisi!";
            } else {
                // Query untuk update data obat
                $sql = "UPDATE obat SET nama_obat = ?, deskripsi = ?, harga = ? WHERE id_obat = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $nama_obat, $deskripsi, $harga, $id_obat);

                if ($stmt->execute()) {
                    $success_message = "Obat berhasil diperbarui!";
                } else {
                    $error_message = "Terjadi kesalahan: " . $stmt->error;
                }
            }
        }
    } else {
        $error_message = "ID Obat tidak valid!";
    }
}

// Query untuk mengambil data obat dari database (semua pengguna bisa melihat)
$sql = "SELECT * FROM obat";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1>Data Obat</h1>

    <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
    <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>

    <!-- Jika pengguna adalah admin, tampilkan form untuk menambah obat -->
    <?php if ($_SESSION['user_role'] === 'admin_klinik'): ?>
    <form method="POST" action="obat.php">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Obat</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <button type="submit" name="tambah_obat" class="btn btn-primary w-100">Tambah Obat</button>
            </div>
        </div>
    </form>
    <?php endif; ?>

    <!-- Tampilkan daftar obat untuk semua pengguna (admin, dokter, pasien) -->
    <h2 class="mt-4">Daftar Obat</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <?php if ($_SESSION['user_role'] === 'admin_klinik'): ?>
                <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($obat = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($obat['nama_obat']) . "</td>";
                    echo "<td>" . htmlspecialchars($obat['deskripsi']) . "</td>";
                    echo "<td>Rp " . number_format($obat['harga'], 0, ',', '.') . "</td>";
                    if ($_SESSION['user_role'] === 'admin_klinik') {
                        echo "<td>";
                        echo "<a href='obat.php?edit_obat=1&id_obat=" . $obat['id_obat'] . "' class='btn btn-warning btn-sm'>Edit</a>";
                        echo "<a href='obat.php?hapus_obat=1&id_obat=" . $obat['id_obat'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus obat ini?\")'>Hapus</a>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Tidak ada data obat.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
