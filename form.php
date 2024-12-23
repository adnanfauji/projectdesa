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
    <title>Formulir</title>
    <link rel="stylesheet" href="form.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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
                    <li class="item"><a href="arsip_sm.php" class="link flex"><i
                                class="bx bx-mail-send"></i><span>Daftar Permohonan</span></a></li>
                    <!-- <li class="item"><a href="arsip_sk.html" class="link flex"><i
                                class="bx bx-paper-plane"></i><span>Surat
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
                                &
                                Restore</span></a></li>
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
            <span class="nav_image"><img src="img/loga_sinapen-new.png" alt="logo_img" /></span>
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

    <!-- Main Content -->
    <div class="form-container">
        <h1>Formulir Permohonan Surat</h1>
        <form action="proses_formulir.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nik_penduduk">Nomor Induk Kependudukan (NIK):</label>
                <input type="text" id="nik_penduduk" name="nik_penduduk" maxlength="50"
                    placeholder="Masukkan Nomor Induk Kependudukan (NIK)" required>
            </div>

            <div class="form-group">
                <label for="nomor_kk">Nomor KK:</label>
                <input type="text" id="nomor_kk" name="nomor_kk" maxlength="16" placeholder="Masukkan Nomor KK"
                    required>
            </div>

            <div class="form-group">
                <label for="nama_penduduk">Nama Lengkap Penduduk:</label>
                <input type="text" id="nama_penduduk" name="nama_penduduk" maxlength="50"
                    placeholder="Masukkan Nama Lengkap Penduduk" required>
            </div>

            <div class="form-group inline">
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat Lengkap" required></textarea>
            </div>

            <div class="form-group">
                <label for="nomor_tlp_penduduk">Nomor Telepon Penduduk:</label>
                <input type="text" id="nomor_tlp_penduduk" name="nomor_tlp_penduduk" maxlength="15"
                    placeholder="Masukkan Nomor Telepon Penduduk" required>
            </div>

            <div class="form-group">
                <label for="id_layanan">Layanan:</label>
                <select id="id_layanan" name="id_layanan" placeholder="Masukkan ID Layanan" required>
                    <!-- Layanan diambil dari database -->
                    <option value="1">Layanan A</option>
                    <option value="2">Layanan B</option>
                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                </select>
            </div>

            <div class="form-group inline">
                <div class="form-group">
                    <label for="tanggal_pengajuan">Tanggal Pengajuan:</label>
                    <input type="date" id="tanggal_pengajuan" name="tanggal_pengajuan" required>
                </div>
            </div>

            <div class="form-group">
                <label for="foto_penduduk">Foto Penduduk:</label>
                <input type="file" id="foto_penduduk" name="foto_penduduk" accept="image/*" required>
            </div>

            <div class="form-group inline">
                <div class="form-group">
                    <label for="tipe_formulir">Tipe Formulir:</label>
                    <input type="text" id="tipe_formulir" name="tipe_formulir" placeholder="Masukkan Tipe Formulir"
                        required>
                </div>

                <div class="form-group">
                    <label for="judul_formulir">Judul Formulir:</label>
                    <input type="text" id="judul_formulir" name="judul_formulir" placeholder="Masukkan Judul Formulir"
                        required>
                </div>

                <div class="form-group">
                    <label for="tanggal_formulir">Tanggal Formulir:</label>
                    <input type="date" id="tanggal_formulir" name="tanggal_formulir" required>
                </div>
            </div>


            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea id="keterangan" name="keterangan" placeholder="Masukkan Keterangan Tambahan"
                    required></textarea>
            </div>

            <div class="form-button">
                <button type="submit">Ajukan Formulir</button>
            </div>
        </form>
    </div>


    <script>
        const sidebar = document.querySelector(".sidebar");
        const hamburgerIcon = document.querySelector("#hamburger-icon");
        const cardContainer = document.querySelector(".form-container");

        const toggleSidebar = () => {
            sidebar.classList.toggle("close");

            if (sidebar.classList.contains("close")) {
                cardContainer.style.marginLeft = "70px";
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
        // Script to synchronize the dates
        document.addEventListener("DOMContentLoaded", function() {
            const tanggalPengajuan = document.getElementById("tanggal_pengajuan");
            const tanggalFormulir = document.getElementById("tanggal_formulir");

            // Set the Tanggal Formulir to the selected Tanggal Pengajuan on change
            tanggalPengajuan.addEventListener("change", function() {
                const selectedDate = tanggalPengajuan.value;
                tanggalFormulir.value = selectedDate; // Set the same date for Tanggal Formulir
            });
        });
    </script>

</body>

</html>