<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki hak akses admin
if (!isset($_SESSION["username"])) {
  header("Location: index.php"); // Arahkan ke halaman login jika tidak memiliki akses
  exit;
}

require 'db_connect.php'; // Koneksi database
require 'functions.php'; // Fungsi untuk mendapatkan pengguna

// Cek apakah data form sudah dikirim
if (isset($_POST['id_pengajuan']) && isset($_POST['action'])) {
  $id_pengajuan = $_POST['id_pengajuan'];
  $action = $_POST['action']; // Bisa 'approve' atau 'reject'

  // Menangani aksi approve
  if ($action == 'approve') {
    $query = "UPDATE Pengajuan SET status_pengajuan = 'Approved' WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($connect, $query);

    if ($result) {
      // Tampilkan SweetAlert untuk pengajuan yang disetujui
      echo "
      <script>
                alert('Pengajuan berhasil disetujui.');
                window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
            </script>";
    } else {
      // Tampilkan SweetAlert jika gagal
      echo "
        <script>
                alert('Gagal menyetujui pengajuan.');
                window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
            </script>";
    }
  }
  // Menangani aksi reject
  elseif ($action == 'reject') {
    $query = "UPDATE Pengajuan SET status_pengajuan = 'Rejected' WHERE id_pengajuan = '$id_pengajuan'";
    $result = mysqli_query($connect, $query);

    if ($result) {
      // Tampilkan SweetAlert untuk pengajuan yang ditolak
      echo "
       <script>
                alert('Pengajuan berhasil ditolak.');
                window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
            </script>";
    } else {
      // Tampilkan SweetAlert jika gagal
      echo "
      
           <script>
                alert('Gagal menolak pengajuan.');
                window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
            </script>";
    }
  }
}
