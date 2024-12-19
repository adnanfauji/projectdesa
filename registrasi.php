<?php
session_start();
require 'db_connect.php';
require 'functions.php';


if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="/projectdesa/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">

        <div class="left">
            <img src="/projectdesa/img/logo-kabupaten-karawang.png" alt="">
            <h2>Selamat Datang di Desa Kutapohaci</h2>
            <p>Kami senang menyambut Anda! Silakan registrasi untuk menjadi bagian dari kami.</p>
        </div>

        <div class="login-wrapper">
            <form action="" method="post" class="registrasi">
                <h1 class="login-text">Daftar</h1>
                <p>Selamat datang di Portal Pendaftaran. <br>Silakan isi formulir di bawah ini untuk membuat akun baru!</p>

                <div class="input-field">
                    <input type="text" id="username" name="username" autocomplete="on" required>
                    <label for="username">Username</label>
                </div>

                <div class="input-field">
                    <input type="email" id="email" name="email" autocomplete="on" required> <!-- Tambahkan input email -->
                    <label for="email">Email</label>
                </div>

                <div class="input-field password-field">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                    <i id="password-toggle" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password','password-toggle')"></i>
                </div>

                <div class="input-field password-field">
                    <input type="password" id="password2" name="password2" required>
                    <label for="password2">Confirm Password</label>
                    <i id="password2-toggle" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password2','password2-toggle')"></i>
                </div>

                <div class="register-feedback"></div>
                <div>
                    <button type="submit" name="register">Daftar</button>
                </div>

                <div class="register">
                    <p>Sudah Punya Akun? <a href="/projectdesa/index.php">Login</a></p>

                </div>

            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(fieldId, toggleId) {
            var passwordField = document.getElementById(fieldId);
            var toggleButton = document.getElementById(toggleId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>

<?php

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password == $password2) {
        $query = "INSERT INTO user (username, email, password, is_admin) VALUES ('$username', '$email',md5('$password'),'0')";
        if (mysqli_query($connect, $query)) {
            echo "<script>
  Swal.fire({
    title: 'Berhasil',
    text: 'Pendaftaran anda berhasil',
    icon: 'success',
    showConfirmButton: true,
  }).then(() => {
    window.location.href = 'index.php';
  });
</script>";
        } else {
            echo "<script>
  Swal.fire({
    title: 'Gagal',
    text: 'Pendaftaran anda gagal',
    icon: 'error',
    showConfirmButton: true,
  }).then(() => {
    window.location.href = 'index.php';
  });
</script>";
        }
    } else {
        echo "<script>
  Swal.fire({
    title: 'error..!',
    text: 'Pasword tidak sama',
    icon: 'error',
    showConfirmButton: true,
  }).then(() => {
    window.location.href = 'index.php';
  });
</script>";
    }
}
?>