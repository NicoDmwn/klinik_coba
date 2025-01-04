<?php
session_start();
if ($_SESSION['user_role'] !== 'admin_klinik') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Selamat datang, Admin!</h1>
    <p>Ini adalah halaman dashboard admin.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
