<?php
require_once __DIR__ . '/vendor/autoload.php'; // Mengimpor TCPDF

// use TCPDF;

// Cek apakah pengguna sudah login
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

// Cek apakah ada laporan yang dipilih
if (isset($_POST['laporan_ids']) && !empty($_POST['laporan_ids'])) {
  $laporan_ids = explode(',', $_POST['laporan_ids']);

  // Koneksi ke database
  require 'db_connect.php';

  // Fungsi untuk mengambil data laporan berdasarkan ID
  function getLaporanByIds($connect, $ids)
  {
    // Cek apakah ada id yang valid
    if (empty($ids)) {
      return [];
    }

    $idString = implode(",", $ids);
    $query = "SELECT id_laporan, tanggal_laporan, judul_laporan, isi_laporan FROM laporan WHERE id_laporan IN ($idString) ORDER BY tanggal_laporan DESC";
    $result = $connect->query($query);
    return $result;
  }

  // Ambil data laporan yang dipilih
  $laporan = getLaporanByIds($connect, $laporan_ids);

  // Cek apakah ada data laporan
  if ($laporan->num_rows > 0) {
    // Buat objek TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Judul laporan
    $pdf->Cell(0, 10, 'Laporan yang Dipilih', 0, 1, 'C');

    // Loop melalui data laporan dan tambahkan ke PDF
    while ($row = $laporan->fetch_assoc()) {
      $pdf->Ln();
      $pdf->Cell(0, 10, 'Tanggal: ' . $row['tanggal_laporan'], 0, 1);
      $pdf->Cell(0, 10, 'Judul: ' . $row['judul_laporan'], 0, 1);
      $pdf->MultiCell(0, 10, 'Isi Laporan: ' . $row['isi_laporan']);
      $pdf->Ln();
    }

    // Output PDF ke browser
    $pdf->Output('laporan.pdf', 'I'); // 'I' untuk langsung ditampilkan di browser
  } else {
    echo "Tidak ada laporan yang dipilih.";
  }
} else {
  echo "Tidak ada laporan yang dipilih.";
}
