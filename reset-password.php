<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);
$connect = require __DIR__ . "/db_connect.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $connect->prepare($sql);
if ($stmt === false) {
    die("Terjadi kesalahan pada saat menyiapkan statement.");
}

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();


if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

// echo "token is valid and hasn't expired";


?>


<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Konfirmasi Kata Sandi</title>
    <link rel="stylesheet" href="/projectdesa/confirm.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script>
        function handleSubmit(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara default

            // Validasi password
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const alertBox = document.querySelector('.alert');
            const successBox = document.querySelector('.success');

            if (newPassword.length < 8) {
                alertBox.querySelector('.text').textContent = 'Password must be at least 8 characters long';
                alertBox.style.display = 'flex';
                successBox.style.display = 'none';
                return;
            }

            if (newPassword !== confirmPassword) {
                alertBox.querySelector('.text').textContent = 'Passwords do not match';
                alertBox.style.display = 'flex';
                successBox.style.display = 'none';
                return;
            }

            alertBox.style.display = 'none';
            successBox.querySelector('.text').textContent = 'Password is valid and matched';
            successBox.style.display = 'flex';

            // Ganti URL di bawah ini dengan URL yang sesuai
            window.location.href = '#';
        }

        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            const eyeIcon = document.getElementById(id + '-icon');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');

            // Update the visibility of both password fields
            if (id === 'new-password') {
                const confirmPasswordInput = document.getElementById('confirm-password');
                confirmPasswordInput.type = type;
                const confirmEyeIcon = document.getElementById('confirm-password-icon');
                confirmEyeIcon.classList.toggle('fa-eye');
                confirmEyeIcon.classList.toggle('fa-eye-slash');
            } else if (id === 'confirm-password') {
                const newPasswordInput = document.getElementById('new-password');
                newPasswordInput.type = type;
                const newEyeIcon = document.getElementById('new-password-icon');
                newEyeIcon.classList.toggle('fa-eye');
                newEyeIcon.classList.toggle('fa-eye-slash');
            }
        }

        function validatePassword() {
            const passwordInput = document.getElementById('new-password');
            const feedback = document.getElementById('password-feedback');
            if (passwordInput.value.length < 8) {
                feedback.textContent = 'Password must be at least 8 characters long';
                feedback.style.color = '#D93025';
            } else {
                feedback.textContent = 'Password length is okay';
                feedback.style.color = '#28a745';
            }
        }
    </script> -->
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="image-box">
                <img src="/projectdesa/img/contact.png" alt="Ilustrasi Kontak" />
            </div>
            <form action="/projectdesa/process-reset-password.php" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div class="topic">Masukkan Sandi Baru Kamu</div>
                <div class="input-box">
                    <input id="new-password" type="password" name="new-password" required />
                    <label>Masukkan sandi baru kamu</label>
                    <button type="button" class="toggle-password">
                        <i id="new-password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="password-feedback" class="password-feedback"></div>
                <div class="input-box">
                    <input id="confirm-password" type="password" name="confirm-password" required />
                    <label>Masukkan ulang sandi baru kamu</label>
                    <!-- <button type="button" class="toggle-password"> -->
                    <i id="confirm-password-icon" class="fas fa-eye"></i>
                    <!-- </button> -->
                </div>
                <!-- Alert moved below the input boxes -->
                <div class="alert">
                    <i class="fas fa-exclamation-circle error"></i>
                    <span class="text">Enter at least 8 characters</span>
                </div>
                <div class="success">
                    <i class="fas fa-check-circle success-icon"></i>
                    <span class="text">Password is valid and matched</span>
                </div>
                <div class="input-box">
                    <button type="submit">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>