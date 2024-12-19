<?php
session_start();
require 'db_connect.php';
require 'functions.php';

// $error = false;

// // cek cookie
// if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
//     $id = $_COOKIE['id'];
//     $key = $_COOKIE['key'];

//     // Ambil username berdasarkan id menggunakan prepared statement
//     $stmt = $connect->prepare("SELECT username FROM user WHERE id = ?");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();

//     // cek cookie dan username
//     if ($key === hash('sha256', $row['username'])) {
//         $_SESSION['login'] = true;
//     }
// }

if (isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}


// //tombol login di tekan atau belum
// if (isset($_POST["login"])) {
//     $username = $_POST["username"];
//     $password = $_POST["password"];
//     $remember = isset($_POST["remember"]);

//     // Query menggunakan prepared statement
//     $stmt = $connect->prepare("SELECT * FROM user WHERE username = ?");
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     // cek Username
//     if ($result->num_rows === 1) {
//         $row = $result->fetch_assoc();

//         // cek password
//         if (password_verify($password, $row["password"])) {
//             // set session
//             $_SESSION["login"] = true;

//             // Set session admin jika pengguna adalah admin
//             $_SESSION["username"] = $row["username"];
//             $_SESSION["id"] = $row["id"];
//             $_SESSION["superuser"] = $row["is_admin"] == 1; // Akan bernilai true jika is_admin adalah 1


//             // Cek Remember me
//             if (isset($_POST['remember'])) {
//                 // buat cookie
//                 setcookie('id', $row['id'], time() + 60);
//                 setcookie('key', hash('sha256', $row['username']), time() + 60);
//             }


//         // }
//     // }
//   if (empty($username) || empty($password)) {
//                 echo "<script>
//                 Swal.fire({
//                     title: 'Login Gagal',
//                     text: 'Username atau password tidak boleh kosong.',
//                     icon: 'error'
//                 });
//                 </script>";
//                 exit;
//             }

//             // Redirect berdasarkan peran
//             if ($row["is_admin"] == 1) {
//                 echo "<script>
//                 Swal.fire({
//                     title: 'Login Berhasil',
//                     text: 'Selamat datang, Admin!',
//                     icon: 'success'
//                 }).then(() => {
//                     window.location.href = 'admin_dashboard.php';
//                 });
//                 </script>";
//             } else {
//                 echo "<script>
//                 Swal.fire({
//                     title: 'Login Berhasil',
//                     text: 'Selamat datang, User!',
//                     icon: 'success'
//                 }).then(() => {
//                     window.location.href = 'user_dashboard.php';
//                 });
//                 </script>";
//             }
//             exit;

//     // Jika username atau password salah
//     // $error = true;
//     echo "<script>
//     Swal.fire({
//         title: 'Login Gagal',
//         text: 'Username atau password salah.',
//         icon: 'error',
//         confirmButtonText: 'Coba Lagi'
//     });
//     </script>";
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="/projectdesa/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
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
                    <label class="remember" for="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <p>Remember me</p>
                    </label>
                    <a href="/projectdesa/forgot-password.php">Forgot password?</a>
                </div>

                <div>
                    <button type="submit" name="login" id="login" class="login">Log In</button>
                </div>


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

<?php
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];

            // Redirect sesuai peran
            if ($row['is_admin'] == 1) {
                echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: 'Login berhasil ke Account ADMINISTRATOR!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'admin_dashboard.php';
                });
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Login Berhasil',
                    text: 'Login berhasil ke Account USER!',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'user_dashboard.php';
                });
                </script>";
            }
        } else {
            echo "<script>
            Swal.fire({
                title: 'Gagal',
                text: 'Password salah!',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
            </script>";
        }
    } else {
        echo "<script>
        Swal.fire({
            title: 'Gagal',
            text: 'Username tidak ditemukan!',
            icon: 'error',
            confirmButtonText: 'Coba Lagi'
        });
        </script>";
    }
}
?>