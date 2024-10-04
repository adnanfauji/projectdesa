<?php
session_start();
require 'db_connect.php';
require 'functions.php';


if (isset($_SESSION["login"])) {
    header("Location: user_dashboard.php");
    exit;
}

if (isset($_POST["register"])) {
    // Cek apakah data sudah terisi lengkap
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password2"])) {
        echo "
            <script>
                alert('Harap isi semua data!');
                window.location.href = '/projectdesa/registrasi.php';
                </script>
                ";
        exit;
    } else {
        // Jika data lengkap, proses registrasi

        if (registrasi($_POST) > 0) {
            echo "
                    <script>
                    alert('User baru berhasi di tambahkan!');
                    window.location.href = '/projectdesa/login.php';
                    </script>
            ";
            exit;
        } else {
            echo mysqli_error($connect);
        }
    }
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
</head>

<body>
    <div class="wrapper">

        <div class="left">
            <img src="/projectdesa/img/logo-kabupaten-karawang.png" alt="">
            <h2>DESA KUTAPOHACI</h2>
        </div>

        <div class="registrasi-wrapper">
            <form action="" method="post" class="registrasi">
                <h1 class=" login-text">Daftar</h1>
                <div class="input-field">
                    <input type="text" id="username" name="username" autocomplete="on" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-field">
                    <input type="text" id="email" name="email" autocomplete="on" required> <!-- Tambahkan input email -->
                    <label for="email">Email</label>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                    <i id="register-password-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password','password-toggle')"></i>
                </div>
                <div class="input-field">
                    <input type="password" id="password2" name="password2" required>
                    <label for="password2">Confirm Password</label>
                    <i id="register-password-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password2','password2-toggle')"></i>
                </div>
                <div class="register-feedback"></div>
                <div>
                    <button type="submit" name="register">Daftar</button>
                </div>

                <div class="register">
                    <p>Sudah Punya Akun? <a href="/projectdesa/login.php">Login</a></p>

                </div>
        </div>

        </form>
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