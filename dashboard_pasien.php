<?php
session_start();
if ($_SESSION['user_role'] !== 'pasien') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
</head>
<body>
    <h1>Selamat datang, Pasien!</h1>
    <p>Ini adalah halaman dashboard pasien.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
