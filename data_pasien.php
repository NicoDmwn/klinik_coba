<?php
session_start();
include_once("db.php");

// Ambil data pasien dari tabel
$result = mysqli_query($conn, "SELECT * FROM pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
</head>
<body>

<h2>Data Pasien</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No KTP/NIK</th>
        <th>No HP</th>
        <th>No Rekam Medis</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nama']; ?></td>
        <td><?php echo $row['alamat']; ?></td>
        <td><?php echo $row['no_ktp']; ?></td>
        <td><?php echo $row['no_hp']; ?></td>
        <td><?php echo $row['no_rm']; ?></td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
