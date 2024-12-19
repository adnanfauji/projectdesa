<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

require 'db_connect.php';

// Periksa apakah parameter ID tersedia
if (!isset($_GET['id'])) {
  echo "ID laporan tidak ditemukan.";
  exit;
}

// Ambil ID laporan dari URL
$id_laporan = intval($_GET['id']);

// Ambil detail laporan berdasarkan ID
$query = "SELECT * FROM laporan WHERE id_laporan = $id_laporan";
$result = $connect->query($query);

if ($result->num_rows > 0) {
  $detail = $result->fetch_assoc();
} else {
  echo "Laporan tidak ditemukan.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Laporan</title>
  <link rel="stylesheet" href="laporan.css">
</head>

<body>
  <div class="content">
    <h1>Detail Laporan</h1>
    <table>
      <tr>
        <th>ID Laporan</th>
        <td><?= htmlspecialchars($detail['id_laporan']) ?></td>
      </tr>
      <tr>
        <th>Tanggal Laporan</th>
        <td><?= htmlspecialchars($detail['tanggal_laporan']) ?></td>
      </tr>
      <tr>
        <th>Judul Laporan</th>
        <td><?= htmlspecialchars($detail['judul_laporan']) ?></td>
      </tr>
      <tr>
        <th>Isi Laporan</th>
        <td><?= nl2br(htmlspecialchars($detail['isi_laporan'])) ?></td>
      </tr>
    </table>
    <a href="laporan.php" class="btn-back">Kembali</a>
  </div>
</body>

</html>