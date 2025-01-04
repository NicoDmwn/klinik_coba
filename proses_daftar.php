<?php
include_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_pasien = $_POST['id_pasien'];
    $keluhan = $_POST['keluhan'];
    $poli = $_POST['poli'];

    // Menyimpan data pendaftaran ke tabel pendaftaran
    $query = "INSERT INTO pendaftaran (id_pasien, keluhan, poli) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id_pasien, $keluhan, $poli);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil.";
        // Redirect atau tampilkan pesan sukses
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
