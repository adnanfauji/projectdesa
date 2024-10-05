<?php
session_start();
require 'db_connect.php';
require 'functions.php';

$error = false;

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($connect, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: user_dashboard.php");
    exit;
}


//tombol login di tekan atau belum
if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    //Query ke database
    $result = mysqli_query($connect, "SELECT * FROM user WHERE username = '$username'");

    // cek Username
    if (mysqli_num_rows($result) === 1) {

        // Ambil data pengguna
        $row = mysqli_fetch_assoc($result);

        // cek password
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;

            // Set session admin jika pengguna adalah admin
            $_SESSION["username"] = $row["username"];
            $_SESSION["superuser"] = $row["is_admin"] == 1; // Akan bernilai true jika is_admin adalah 1


            // Cek Remember me
            if (isset($_POST['remember'])) {
                // buat cookie
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            // Redirect berdasarkan peran
            if ($row["is_admin"] == 1) {
                header("Location: admin_dashboard.php"); // Redirect ke halaman admin
            } else {
                header("Location: user_dashboard.php");  // Redirect ke dashboard pengguna biasa
            }
            exit;
        }
    }
    // Jika username atau password salah
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="/projectdesa/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>


    <div class="wrapper">

        <div class="left">
            <img src="/projectdesa/img/logo-kabupaten-karawang.png" alt="">
            <h2>DESA KUTAPOHACI</h2>
            <p>Selamat datang di Desa Kutapohaci! Bersama kita membangun desa yang lebih baik.</p>
        </div>

        <div class="login-wrapper">
            <form action="" method="post">
                <h1>Selamat Datang</h1>
                <p>Silakan masukkan <strong>username</strong> dan <strong>password</strong> Anda untuk login ke portal ini.</p>
                <div class="input-field">
                    <input type="text" id="login-email" name="username" autocomplete="on" required>
                    <label for="login-email">Enter your username</label>
                </div>
                <div class="input-field password-field">
                    <input type="password" id="login-password" name="password" required oninput="validateLoginPassword()">
                    <label for="login-password">Enter your password</label>
                    <i id="login-password-icon" class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('login-password')"></i>
                </div>
                <div class="password-feedback" id="login-password-feedback"></div>
                <div class="forget">
                    <label for="remember">
                        <input type="checkbox" id="remember">
                        <p>Remember me</p>
                    </label>
                    <a href="/projectdesa/resetpassword.php">Forgot password?</a>
                </div>

                <div>
                    <a href="/projectdesa/user_dashboard.php" id="login">
                        <button type="submit" name="login" id="login" class="login">Log In</button>
                    </a>
                </div>

                <?php if ($error): ?>

                    <div class="error">Username atau password salah.</div>
                <?php endif; ?>

                <div class="register">
                    <p>Don't have an account? <a href="/projectdesa/registrasi.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>





    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            const eyeIcon = document.getElementById(id + '-icon');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>

</html>