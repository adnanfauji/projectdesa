<?php
session_start();
require 'db_connect.php';
require 'functions.php';

if (!isset($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['upload-photo'])) {
  $file = $_FILES['upload-photo'];
  $uploadDirectory = "img/"; // Folder to store uploaded images

  // Validate if the uploaded file is an image
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
  $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

  if (in_array($fileExtension, $allowedExtensions)) {
    $newFileName = uniqid() . '.' . $fileExtension; // Create a unique file name
    $filePath = $uploadDirectory . $newFileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
      // Update the user's profile picture in the database
      $query_update_photo = "UPDATE user SET profile_picture = ? WHERE username = ?";
      $stmt_update_photo = $connect->prepare($query_update_photo);
      $stmt_update_photo->bind_param("ss", $filePath, $username);
      if ($stmt_update_photo->execute()) {
        // Redirect to the settings page with a success message
        header("Location: pengaturan.php?success=1");
      } else {
        $error_message = "Gagal memperbarui foto profil di database.";
      }
    } else {
      $error_message = "Gagal mengunggah foto.";
    }
  } else {
    $error_message = "Format file tidak diperbolehkan. Harap unggah file gambar.";
  }
}
