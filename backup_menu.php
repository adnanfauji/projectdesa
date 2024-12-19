<?php
session_start();
require 'db_connect.php';
require 'functions.php';

// Redirect jika user tidak login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Ambil username dari sesi
$username = $_SESSION["username"];

// Query untuk mendapatkan data user berdasarkan username
$query_user = "SELECT username, email FROM user WHERE username = ?";
$stmt = $connect->prepare($query_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

// Periksa apakah data user ditemukan
if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
    $display_username = $user_data['username'];
    $display_email = $user_data['email'];
} else {
    $display_username = "Guest";
    $display_email = "guest@example.com";
}


// Query untuk mendapatkan data pengajuan yang sudah diproses
$query = "SELECT p.id_pengajuan, f.tipe_formulir, p.tanggal_pengajuan, p.status_pengajuan
          FROM pengajuan p
          JOIN formulir f ON p.id_pengajuan = f.id_formulir
          WHERE p.status_pengajuan IN ('Pending', 'Approved', 'Rejected')";

$result = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Backup & Restore</title>
    <link rel="stylesheet" href="backup.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar locked">
        <!-- <div class="logo_items flex">
            <span class="nav_image"><img src="img/logo_sinapen.png" alt="logo_img" /></span>
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
                    <li class="item">
                        <a href="user_dashboard.php" class="link flex"><i class="bx bx-home-alt"></i><span>Home</span></a>
                    </li>
                    <li class="item">
                        <a href="buat_surat.php" class="link flex"><i class="fas fa-plus-circle"></i><span>Tambah Surat</span></a>
                    </li>
                    <li class="item">
                        <a href="arsip_sm.php" class="link flex"><i class="bx bx-mail-send"></i><span>Daftar Permohonan</span></a>
                    </li>
                    <!-- <li class="item">
                        <a href="arsip_sk.html" class="link flex"><i class="bx bx-paper-plane"></i><span>Surat Keluar</span></a>
                    </li> -->
                </ul>
                <!-- <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Arsip</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="arsip_sm.html" class="link flex"><i class="bx bx-folder-open"></i><span>Arsip Surat Masuk</span></a>
                    </li>
                    <li class="item">
                        <a href="arsip_sk.html" class="link flex"><i class="bx bx-file"></i><span>Arsip Surat Keluar</span></a>
                    </li>
                </ul> -->
                <ul class="menu_item">
                    <!-- <div class="menu_title flex">
                        <span class="title">Laporan</span>
                        <span class="line"></span>
                    </div> -->
                    <li class="item">
                        <a href="laporan.php" class="link flex"><i class="bx bx-clipboard"></i><span>Laporan</span></a>
                    </li>
                </ul>
                <ul class="menu_item">
                    <!-- <div class="menu_title flex">
                        <span class="title">Setting</span>
                        <span class="line"></span>
                    </div> -->
                    <li class="item">
                        <a href="backup_menu.php" class="link flex"><i class="bx bx-cloud"></i><span>Backup & Restore</span></a>
                    </li>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-cog"></i><span>Setting</span></a>
                    </li>
                    <li class="item">
                        <a href="logout.php" class="link flex"><i class="bx bx-log-out"></i><span>Log Out</span></a>
                    </li>
                </ul>
            </div>
            <!-- <div class="sidebar_profile flex">
                <span class="nav_image"><img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" /></span>
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
                <span class="name"><?php echo htmlspecialchars($display_username); ?></span>
                <span class="email"><?php echo htmlspecialchars($display_email); ?></span>
            </div>
            <span class="nav_image">
                <img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" />
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="header">
            Cadangkan & Pulihkan
        </div>
        <div class="content">
            <div class="card">
                <h3>Cadangkan</h3>
                <p>Klik untuk backup</p>
                <button class="btn" onclick="backupDatabase()">Cadangkan Database</button>
            </div>
            <div class="card">
                <h3>Pulihkan</h3>
                <form id="restoreForm" enctype="multipart/form-data" action="restore.php" method="POST"
                    onsubmit="return restoreDatabase(event)">
                    <div class="file-input-container">
                        <input type="file" name="sqlFile" accept=".sql" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Pulihkan Database</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        function backupDatabase() {
            fetch('backup.php') // Memanggil script PHP untuk melakukan backup
                .then(response => response.json()) // Mengambil data dalam format JSON
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Backup Berhasil!',
                            text: 'File backup telah berhasil dibuat.',
                            icon: 'success',
                            confirmButtonText: 'Download',
                            showCancelButton: true,
                            cancelButtonText: 'Tutup',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = data.filename; // Mengunduh file backup
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Backup Gagal!',
                            text: data.message || 'Terjadi kesalahan saat melakukan backup.',
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#d33',
                            allowOutsideClick: false
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat melakukan proses backup.',
                        icon: 'error',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false
                    });
                });
        }

        // Menangani proses restore dengan SweetAlert
        function restoreDatabase(event) {
            event.preventDefault(); // Mencegah form untuk submit default

            const form = document.getElementById('restoreForm');
            const formData = new FormData(form);

            fetch('restore.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Mengambil data dalam format JSON
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Restore Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false
                        });
                    } else {
                        Swal.fire({
                            title: 'Restore Gagal!',
                            text: data.message || 'Terjadi kesalahan saat melakukan restore.',
                            icon: 'error',
                            confirmButtonText: 'Tutup',
                            confirmButtonColor: '#d33',
                            allowOutsideClick: false
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat melakukan proses restore.',
                        icon: 'error',
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false
                    });
                });
        }


        // JavaScript untuk sidebar
        const sidebar = document.querySelector(".sidebar");
        const hamburgerIcon = document.querySelector("#hamburger-icon");
        const cardContainer = document.querySelector(".container");

        const toggleSidebar = () => {
            sidebar.classList.toggle("close");

            if (sidebar.classList.contains("close")) {
                cardContainer.style.marginLeft = "75px";
                document.querySelector('.navbar').style.width = "calc(100% - 75px)";
                document.querySelector('.navbar').style.left = "75px";
                hamburgerIcon.classList.remove("bx-menu");
                hamburgerIcon.classList.add("bx-x");
            } else {
                cardContainer.style.marginLeft = "270px";
                document.querySelector('.navbar').style.width = "calc(100% - 270px)";
                document.querySelector('.navbar').style.left = "270px";
                hamburgerIcon.classList.remove("bx-x");
                hamburgerIcon.classList.add("bx-menu");
            }
        };

        // Event listener untuk ikon hamburger
        hamburgerIcon.addEventListener("click", toggleSidebar);
    </script>

</body>

</html>