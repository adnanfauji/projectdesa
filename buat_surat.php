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
$query_user = "SELECT username, email, profile_picture FROM user WHERE username = ?";
$stmt = $connect->prepare($query_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

// Periksa apakah data user ditemukan
if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
    $display_username = $user_data['username'];
    $display_email = $user_data['email'];
    $display_profile_picture = $user_data['profile_picture'];
} else {
    $display_username = "Guest";
    $display_email = "guest@example.com";
    $display_email = "image";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Surat Baru</title>
    <link rel="stylesheet" href="buat_surat.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
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
                        <a href="arsip_sm.php" class="link flex"><i class="bx bx-mail-send"></i><span>Permohonan Surat</span></a>
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
                        <a href="pengaturan.php" class="link flex"><i class="bx bx-cog"></i><span>Setting</span></a>
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
    <!-- Sidebar code remains the same -->

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
                <img src="<?php echo htmlspecialchars($display_profile_picture); ?>" alt="logo_img" />
            </span>
        </div>
    </nav>

    <!-- <div class="card-container">
        <div class="card blue">
            <h2>27</h2>
            <p>Surat Masuk</p>
            <a href="#">Lihat Selengkapnya</a>
        </div>
        <div class="card yellow">
            <h2>27</h2>
            <p>Surat Keluar</p>
            <a href="#">Lihat Selengkapnya</a>
        </div>
    </div> -->

    <div class="container">
        <div class="header-container title">
            <h1>Buat Permohonan Baru</h1>
        </div>
        <div class="card-container">
            <div class="card">
                <p>Surat Pengantar KTP</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Pengantar KK</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Pengantar Keterangan Usaha</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Keterangan Pengantar Nikah</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Keterangan Pindah/Datang</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Keterangan kematian</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
            <div class="card">
                <p>Surat Keterangan Ahli Waris</p>
                <a href="form.php" class="card-button">Buat Permohonan Surat</a>
                <!-- <button class="card-button">Buat Permohonan Surat</button> -->
            </div>
        </div>

    </div>


    <script>
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

        // Event listener for hamburger icon
        hamburgerIcon.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });


        // Logika untuk menyembunyikan ikon pencarian
        const searchInputs = document.querySelectorAll('.input-with-icon input');
        searchInputs.forEach(input => {
            const searchIcon = input.nextElementSibling;
            input.addEventListener('input', () => {
                searchIcon.style.display = input.value ? 'none' : 'block';
            });
        });
    </script>
</body>

</html>