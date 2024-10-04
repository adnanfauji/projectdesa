<?php
session_start();
require 'db_connect.php'; // Koneksi database
require 'functions.php';

if (!isset($_SESSION["login"]) || !isset($_SESSION["superuser"]) || !$_SESSION["superuser"]) {
  header("Location: login.php");
  exit;
}

if (isset($_POST['action']) && isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $action = $_POST['action'];

  if ($action === 'approve') {
    $query = "UPDATE user SET status = 'approved' WHERE id = $id";
  } elseif ($action === 'reject') {
    $query = "UPDATE user SET status = 'rejected' WHERE id = $id";
  } else {

    if (mysqli_query($connect, $query)) {
      header("Location: admin_dashboard.php"); // Kembali ke dashboard setelah aksi
      exit;
    } else {
      die("Error: " . mysqli_error($connect));
    }
  }
}


// session_start();
// require 'db_connect.php'; // Koneksi database

// if (!isset($_SESSION["login"]) || !isset($_SESSION["superuser"]) || !$_SESSION["superuser"]) {
//   header("Location: testlogin.php");
//   exit;
// }

// if (isset($_POST['action']) && isset($_POST['id'])) {
//   $id = intval($_POST['id']);
//   $action = $_POST['action'];

//   if ($action === 'approve') {
//     $query = "UPDATE user SET status = 'approved' WHERE id = $id";
//   } elseif ($action === 'reject') {
//     $query = "UPDATE user SET status = 'rejected' WHERE id = $id";
//   }

//   error_log($query); // Log query

//   if (mysqli_query($connect, $query)) {
//     header("Location: testadmin_dashboard.php");
//     exit;
//   } else {
//     die("Error: " . mysqli_error($connect));
//   }
// }
?>
<!-- -->
// session_start();
// require 'db_connect.php'; // Koneksi database

// // Cek apakah pengguna sudah login dan memiliki hak akses admin
// if (!isset($_SESSION["login"]) || !isset($_SESSION["superuser"]) || !$_SESSION["superuser"]) {
// header("Location: testlogin.php");
// exit;
// }

// if (isset($_POST['action'])) {
// $userId = $_POST['id'];
// $action = $_POST['action'];

// if ($action === 'approve') {
// // Update status di tabel user
// $query = "UPDATE user SET status = 'approved', approved_at = NOW() WHERE id = $userId"; // Kurang aman
// mysqli_query($connect, $query);
// // $query = "UPDATE user SET status = 'approved', approved_at = NOW() WHERE id = ?";
// // $stmt = mysqli_prepare($connect, $query);
// // mysqli_stmt_bind_param($stmt, 'i', $userId);
// // mysqli_stmt_execute($stmt);

// // Tambahkan entri ke tabel approved_users
// $query = "INSERT INTO approved_users (user_id, approved_at) VALUES ($userId, NOW())";
// mysqli_query($connect, $query);
// // $stmt = mysqli_prepare($connect, $query);
// // mysqli_stmt_bind_param($stmt, 'i', $userId);
// // mysqli_stmt_execute($stmt);

// // Redirect ke dashboard
// header("Location: testadmin_dashboard.php");
// exit;
// } elseif ($action === 'reject') {
// // Update status di tabel user

// $query = "UPDATE user SET status = 'rejected' WHERE id = $userId";
// mysqli_query($connect, $query);
// // $stmt = mysqli_prepare($connect, $query);
// // mysqli_stmt_bind_param($stmt, 'i', $userId);
// // mysqli_stmt_execute($stmt);

// // Redirect ke dashboard
// header("Location: testadmin_dashboard.php");
// exit;
// }
// }