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
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Pengajuan disetujui!',
                  text: 'Pengajuan berhasil disetujui.',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
                      exit();
                      }
              });
            </script>";
    } else {
      // Tampilkan SweetAlert jika gagal
      echo "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'error',
                  title: 'Terjadi kesalahan!',
                  text: 'Gagal menyetujui pengajuan.',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = 'admin_dashboard.php';
                      exit();
                      }
              });
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
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Pengajuan ditolak!',
                  text: 'Pengajuan berhasil ditolak.',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = 'admin_dashboard.php'; // Redirect ke halaman dashboard admin
                      exit();
                      }
              });
            </script>";
    } else {
      // Tampilkan SweetAlert jika gagal
      echo "
       <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
              Swal.fire({
                  icon: 'error',
                  title: 'Terjadi kesalahan!',
                  text: 'Gagal menolak pengajuan.',
                  confirmButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = 'admin_dashboard.php';
                      exit();
                      }
              });
            </script>";
    }
  }
}
