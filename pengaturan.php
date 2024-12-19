<?php
session_start();
require 'db_connect.php';
require 'functions.php';

// Redirect if user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION["username"];

// Fetch user data
$query_user = "SELECT username, email, profile_picture FROM user WHERE username = ?";
$stmt = $connect->prepare($query_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
    $display_username = htmlspecialchars($user_data['username']);
    $display_email = htmlspecialchars($user_data['email']);
    $display_profile_picture = htmlspecialchars($user_data['profile_picture']);
} else {
    header("Location: index.php");
    exit;
}

$alert_message = null;
$alert_type = null;

// Process password change
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $old_password = trim($_POST['old-password']);
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Validate input
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $alert_message = "Semua field harus diisi!";
        $alert_type = "error";
    } elseif (strlen($new_password) < 8) {
        $alert_message = "Password baru harus minimal 8 karakter.";
        $alert_type = "error";
    } elseif ($new_password !== $confirm_password) {
        $alert_message = "Password baru dan konfirmasi tidak cocok.";
        $alert_type = "error";
    } else {
        // Check old password
        $query_password = "SELECT password FROM user WHERE username = ?";
        $stmt_password = $connect->prepare($query_password);
        $stmt_password->bind_param("s", $username);
        $stmt_password->execute();
        $result_password = $stmt_password->get_result();

        if ($result_password->num_rows > 0) {
            $user_password_data = $result_password->fetch_assoc();
            if (!password_verify($old_password, $user_password_data['password'])) {
                $alert_message = "Password lama tidak valid!";
                $alert_type = "error";
            } else {
                // Update password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $query_update = "UPDATE user SET password = ? WHERE username = ?";
                $stmt_update = $connect->prepare($query_update);
                $stmt_update->bind_param("ss", $new_hashed_password, $username);

                if ($stmt_update->execute()) {
                    $alert_message = "Password berhasil diperbarui!";
                    $alert_type = "success";
                } else {
                    $alert_message = "Terjadi kesalahan saat memperbarui password.";
                    $alert_type = "error";
                }
                $stmt_update->close();
            }
        } else {
            $alert_message = "User tidak ditemukan.";
            $alert_type = "error";
        }
        $stmt_password->close();
    }
}
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengaturan</title>
    <link rel="stylesheet" href="pengaturan.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar locked">
        <!-- <div class="logo_items flex">
            <span class="nav_image"><img src="images/logo_example.jpeg" alt="logo_img" /></span>
            <span class="logo_name">SINAPEN</span>
        </div> -->
        <div class="menu_container">
            <div class="menu_items">
                <ul class="menu_item">
                    <i class="bx bx-menu" id="hamburger-icon" title="Menu"></i>
                    <!-- <div class="menu_title flex">
                        <span class="title">Dashboard</span>
                        <span class="line"></span>
                    </div> -->
                    <li class="item"><a href="user_dashboard.php" class="link flex"><i
                                class="bx bx-home-alt"></i><span>Home</span></a></li>
                    <li class="item"><a href="buat_surat.php" class="link flex"><i
                                class="fas fa-plus-circle"></i><span>Tambah Surat</span></a></li>
                    <li class="item"><a href="arsip_sm.php" class="link flex"><i class="bx bx-mail-send"></i><span>Permohonan Surat</span></a></li>
                    <!-- <li class="item"><a href="#" class="link flex"><i class="bx bx-paper-plane"></i><span>Surat
                                Keluar</span></a></li> -->
                </ul>
                <!-- <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Arsip</span>
                        <span class="line"></span>
                    </div>
                    <li class="item"><a href="arsip_sm.html" class="link flex"><i
                                class="bx bx-folder-open"></i><span>Arsip Surat Masuk</span></a></li>
                    <li class="item"><a href="arsip_sk.html" class="link flex"><i class="bx bx-file"></i><span>Arsip
                                Surat Keluar</span></a></li>
                </ul> -->
                <ul class="menu_item">
                    <!-- <div class="menu_title flex">
                        <span class="title">Laporan</span>
                        <span class="line"></span>
                    </div> -->
                    <li class="item"><a href="laporan.php" class="link flex"><i
                                class="bx bx-clipboard"></i><span>Laporan</span></a></li>
                </ul>
                <ul class="menu_item">
                    <!-- <div class="menu_title flex">
                        <span class="title">Setting</span>
                        <span class="line"></span>
                    </div> -->
                    <li class="item"><a href="backup_menu.php" class="link flex"><i class="bx bx-cloud"></i><span>Backup
                                & Restore</span></a></li>
                    <li class="item"><a href="pengaturan.php" class="link flex"><i
                                class="bx bx-cog"></i><span>Setting</span></a>
                    </li>
                    <li class="item"><a href="logout.php" class="link flex"><i class="bx bx-log-out"></i><span>Log
                                Out</span></a></li>
                </ul>
            </div>
            <!-- <div class="sidebar_profile flex">
                <span class="nav_image"><img src="images/profil_example.jpeg" alt="logo_img" /></span>
                <div class="data_text">
                    <span class="name">knight Kanterburry</span>
                    <span class="email">knight@gmail.com</span>
                </div>
            </div> -->
        </div>
    </nav>

    <!-- Navbar -->
    <nav class="navbar flex">
        <div class="logo_items flex">
            <span class="nav_image"><img src="img/logo_sinapen.png" alt="logo_img" /></span>
            <span class="logo_name">SINAPEN</span>
        </div>
        <input type="text" name="search_box" placeholder="Search..." class="search_box" />
        <div class="user-info">
            <div class="data_text">
                <span class="name">
                    <?php echo htmlspecialchars($display_username); ?>
                </span>
                <span class="email">
                    <?php echo htmlspecialchars($display_email); ?>
                </span>
            </div>
            <span class="nav_image">
                <img src="<?php echo htmlspecialchars($display_profile_picture); ?>" alt="logo_img" />
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Pengaturan Akun</h2>
        <div class="account-info">
            <div class="photo">
                <!-- Display the user's profile picture, if available -->
                <img src="<?php echo isset($user_data['profile_picture']) ? $user_data['profile_picture'] : 'images/profil_example.jpeg'; ?>" alt="Foto Admin" width="150">
            </div>
            <form action="upload_foto.php" method="POST" enctype="multipart/form-data">
                <label for="upload-photo" class="upload-label">Unggah Foto Profil</label>
                <input type="file" id="upload-photo" name="upload-photo" class="upload-input" />
                <button type="submit" class="btn-upload">Unggah</button>
            </form>
            <div class="details">
                <p><strong>Username:</strong><?php echo htmlspecialchars($display_username); ?></p>
                <p><strong>E-mail:</strong><?php echo htmlspecialchars($display_email); ?></p>
            </div>
        </div>

        <div class="change-password">
            <h2>Ubah Password</h2>
            <?php if (!empty($error_message)) : ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_message)) : ?>
                <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <form id="password-form" method="POST">
                <label for="old-password">Password Lama</label>
                <input type="password" id="old-password" name="old-password" required>

                <label for="new-password">Password Baru</label>
                <input type="password" id="new-password" name="new-password" required>

                <label for="confirm-password">Konfirmasi Password Baru</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit" class="btn-confirm">Konfirmasi</button>
            </form>
        </div>
        <?php if (isset($error_message)) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memperbarui password.'
                });
            </script>
        <?php endif; ?>
        <?php if ($alert_message) : ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $alert_type; ?>',
                    title: '<?php echo ($alert_type === "success") ? "Berhasil" : "Gagal"; ?>',
                    text: '<?php echo $alert_message; ?>'
                });
            </script>
        <?php endif; ?>
    </div>


    <script>
        const sidebar = document.querySelector(".sidebar");
        const hamburgerIcon = document.querySelector("#hamburger-icon");
        const cardContainer = document.querySelector(".container");

        const toggleSidebar = () => {
            sidebar.classList.toggle("close");

            if (sidebar.classList.contains("close")) {
                cardContainer.style.marginLeft = "150px";
                document.querySelector('.navbar').style.width = "calc(100% - 75px)";
                document.querySelector('.navbar').style.left = "75px";
                hamburgerIcon.classList.remove("bx-menu");
                hamburgerIcon.classList.add("bx-x");
            } else {
                cardContainer.style.marginLeft = "370px";
                document.querySelector('.navbar').style.width = "calc(100% - 270px)";
                document.querySelector('.navbar').style.left = "270px";
                hamburgerIcon.classList.remove("bx-x");
                hamburgerIcon.classList.add("bx-menu");
            }
        };

        // Event listener untuk ikon hamburger
        hamburgerIcon.addEventListener("click", toggleSidebar);

        // // Event listeners for the password fields
        // const oldPasswordInput = document.getElementById("old-password");
        // const newPasswordInput = document.getElementById("new-password");
        // const confirmPasswordInput = document.getElementById("confirm-password");
        // const errorNew = document.getElementById("error-new");
        // const errorOld = document.getElementById("error-old");
        // const errorConfirm = document.getElementById("error-confirm");

        // // Real-time validation when the user types in the password fields
        // newPasswordInput.addEventListener("input", function() {
        //     if (newPasswordInput.value.length < 8) {
        //         errorNew.textContent = "Sandi baru harus memiliki minimal 8 karakter.";
        //         errorNew.classList.add("active"); // Ensure the error message is visible
        //     } else {
        //         errorNew.textContent = "";
        //         errorNew.classList.remove("active"); // Hide the error message
        //     }
        // });

        // confirmPasswordInput.addEventListener("input", function() {
        //     if (confirmPasswordInput.value.length < 8) {
        //         errorConfirm.textContent = "Konfirmasi sandi harus memiliki minimal 8 karakter.";
        //         errorConfirm.classList.add("active");
        //     } else {
        //         errorConfirm.textContent = "";
        //         errorConfirm.classList.remove("active");
        //     }

        //     // Also check if both passwords match
        //     if (confirmPasswordInput.value !== newPasswordInput.value) {
        //         errorConfirm.textContent = "Sandi baru dan konfirmasi tidak cocok!";
        //         errorConfirm.classList.add("active");
        //     } else if (confirmPasswordInput.value.length >= 8) {
        //         errorConfirm.textContent = "";
        //         errorConfirm.classList.remove("active");
        //     }
        // });

        // // Form submission validation
        // document.getElementById("password-form").addEventListener("submit", function(e) {
        //     e.preventDefault(); // Prevent the form from being submitted

        //     // Get input values
        //     const oldPassword = document.getElementById("old-password").value;
        //     const newPassword = document.getElementById("new-password").value;
        //     const confirmPassword = document.getElementById("confirm-password").value;

        //     let formIsValid = true; // Flag to check if the form is valid

        //     // Reset error messages
        //     document.getElementById("error-old").textContent = "";

        //     if (oldPassword === "") {
        //         document.getElementById("error-old").textContent = "Sandi lama tidak boleh kosong!";
        //         formIsValid = false;
        //     }

        //     // Ensure new password has at least 8 characters
        //     if (newPassword.length < 8) {
        //         document.getElementById("error-new").textContent = "Sandi baru harus memiliki minimal 8 karakter.";
        //         formIsValid = false;
        //     }

        //     // Ensure confirm password has at least 8 characters and matches the new password
        //     if (confirmPassword.length < 8) {
        //         document.getElementById("error-confirm").textContent = "Konfirmasi sandi harus memiliki minimal 8 karakter.";
        //         formIsValid = false;
        //     }

        //     if (newPassword !== confirmPassword) {
        //         document.getElementById("error-confirm").textContent = "Sandi baru dan konfirmasi tidak cocok!";
        //         formIsValid = false;
        //     }

        //     // If the form is valid, alert success and reset form
        //     if (formIsValid) {
        //         alert("Password berhasil diubah!");
        //         document.getElementById("password-form").reset();
        //     } else {
        //         alert("Ada kesalahan dalam pengisian form! Periksa kembali data Anda.");
        //     }
        // });

        // const toggleOldPassword = document.getElementById("toggle-old-password");
        // const toggleNewPassword = document.getElementById("toggle-new-password");
        // const toggleConfirmPassword = document.getElementById("toggle-confirm-password");

        // const togglePasswordVisibility = (input, icon) => {
        //     if (input.type === "password") {
        //         input.type = "text";
        //         icon.classList.remove("bx-hide");
        //         icon.classList.add("bx-show");
        //     } else {
        //         input.type = "password";
        //         icon.classList.remove("bx-show");
        //         icon.classList.add("bx-hide");
        //     }
        // };

        // // Event listener for the password visibility toggles
        // toggleOldPassword.addEventListener("click", () => {
        //     togglePasswordVisibility(oldPasswordInput, toggleOldPassword);
        // });

        // toggleNewPassword.addEventListener("click", () => {
        //     togglePasswordVisibility(newPasswordInput, toggleNewPassword);
        // });

        // toggleConfirmPassword.addEventListener("click", () => {
        //     togglePasswordVisibility(confirmPasswordInput, toggleConfirmPassword);
        // });
    </script>


</body>

</html>