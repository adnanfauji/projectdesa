<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'db_connect.php';
require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerhalaman = 2;
$jumlahData = count(query("SELECT * FROM pending_users"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? (int) $_GET["halaman"] : 1;
$awalData = ( $jumlahDataPerhalaman * $halamanAktif ) - $jumlahDataPerhalaman;

// panggil query data mahasiswa yang di simpan ke variable mahasiswa
$result = query("SELECT * FROM pending_users LIMIT $awalData, $jumlahDataPerhalaman");

// tombol cari di tekan
if ( isset($_POST["cari"]) ){
    $result = cari($_POST["keyword"]);
}

?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
<!-- stylesheet -->
<!-- <link
        rel="stylesheet" href="/projectdesa/style.css" /> -->
<!-- memanggil file javascript / main.js -->
<!-- <script src="/projectdesa/JS/main.js"></script> -->
<!-- ionicons -->
<!-- <script
        type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head> -->

<!-- <body>

    <div>
        <header>
            <h1>SISTEM INFORMASI ADMINISTRASI KEPENDUDUKAN</h1>
        </header>
        <div>
            <aside>
                <ul>
                    <li><a href="">Dashboard</a>
                        <ul>
                            <li><a href="">Surat Masuk</a></li>
                            <li><a href="">Surat Keluar</a></li>
                        </ul>
                    </li>
                    <li><a href="">Buat Surat Baru</a></li>
                    <li><a href="">Arsip Surat Masuk</a></li>
                    <li><a href="">Arsip Surat Keluar</a></li>
                    <li><a href="">Laporan</a></li>
                    <li><a href="">Jadwal Desa</a></li>
                    <li><a href="">Database Backup</a></li>
                    <li><a href="/projectdesa/Test/testlogout.php" class="logout">logout</a></li>
                </ul>
            </aside>
            <main>
                <p>Main Content</p>
            </main>
        </div>
        <footer>
            <p>Footer</p>
        </footer>
    </div>
</body> -->

<!-- </html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title> -->
<!-- stylesheet -->
<!-- <link
        rel="stylesheet"
        href="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/admin.css" /> -->
<!-- memanggil file javascript / main.js -->
<!-- <script src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/main.js"></script> -->
<!-- ionicons -->
<!-- <script
        type="module"
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body> -->
<!-- navigation -->
<!-- <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="school-outline"></ion-icon>
                        </span>
                        <span class="title">Desa Kutapohaci</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="add-outline"></ion-icon>
                        </span>
                        <span class="title">Buat Surat Baru</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="mail-outline"></ion-icon>
                        </span>
                        <span class="title">Surat Masuk</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="paper-plane-outline"></ion-icon>
                        </span>
                        <span class="title">Surat Keluar</span>
                    </a>
                </li>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="archive-outline"></ion-icon>
                        </span>
                        <span class="title">Arsip Surat Masuk</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="document-outline"></ion-icon>
                        </span>
                        <span class="title">Laporan</span>
                    </a>
                </li> -->
<!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Message</span>
                    </a>
                </li> -->
<!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="server-outline"></ion-icon>
                        </span>
                        <span class="title">Backup & Restore</span>
                    </a>
                </li> -->
<!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Setting</span>
                    </a>
                </li> -->
<!-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li> -->
<!-- <li>
                    <a href="/projectdesa/Test/testlogout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="search here" />
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div class="user">
                    <img
                        src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                        alt="" />
                </div>
            </div> -->
<!-- ======= card ===== -->
<!-- <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="number">1.504</div>
                        <div class="cardName">Surat Masuk</div>
                    </div>

                    <div class="iconBox">
                        <ion-icon name="mail-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="number">1.080</div>
                        <div class="cardName">Surat Keluar</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="mail-open-outline"></ion-icon>
                    </div>
                </div> -->
<!-- <div class="card">
                    <div>
                        <div class="number">284</div>
                        <div class="cardName">Comments</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="chatbubble-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="number">$3.84</div>
                        <div class="cardName">Earnings</div>
                    </div>

                    <div class="iconBox"><ion-icon name="cash-outline"></ion-icon></div>
                </div> -->
<!-- </div>
        </div>
    </div>
</body>

</html> -->



<!-- Part 3.1 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="/projectdesa/dashboard.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
</head>

<body>
    <nav class="sidebar locked">
        <div class="logo_items flex">
            <span class="nav_image"><img src="/projectdesa/img/logo.png" style="width: 100px; height:50px" alt="logo_img" /></span>
            <span class="logo_name">SINAPEN</span>
        </div>
        <div class="menu_container">
            <div class="menu_items">
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Dashboard</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="/projectdesa/user_dashboard.php" class="link flex"><i class="bx bx-home-alt"></i><span>Home</span></a>
                    </li>
                    <li class="item">
                        <a href="/projectdesa/buat_surat.php" class="link flex"><i class="fas fa-plus-circle"></i><span>Tambah Surat</span></a>
                    </li>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-mail-send"></i><span>Surat Masuk</span></a>
                    </li>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-paper-plane"></i><span>Surat Keluar</span></a>
                    </li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Arsip</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-folder-open"></i><span>Arsip Surat Masuk</span></a>
                    </li>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-file"></i><span>Arsip Surat Keluar</span></a>
                    </li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Laporan</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-clipboard"></i><span>Laporan</span></a>
                    </li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Setting</span>
                        <span class="line"></span>
                    </div>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-cloud"></i><span>Backup & Restore</span></a>
                    </li>
                    <li class="item">
                        <a href="#" class="link flex"><i class="bx bx-cog"></i><span>Setting</span></a>
                    </li>
                    <li class="item">
                        <a href="/projectdesa/logout.php" class="link flex"><i class="bx bx-log-out"></i><span>Log Out</span></a>
                    </li>
                </ul>
            </div>
            <div class="sidebar_profile flex">
                <span class="nav_image"><img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" /></span>
                <div class="data_text">
                    <span class="name">knight Kanterburry</span>
                    <span class="email">knight@gmail.com</span>
                </div>
            </div>
        </div>
    </nav>

    <nav class="navbar flex">
        <i class="bx bx-menu" id="hamburger-icon" title="Menu"></i>
        <input type="text" name="search_box" placeholder="Search..." class="search_box" />
        <span class="nav_image"><img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" /></span>
    </nav>

    <div class="card-container">
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
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Surat A</td>
                    <td>01-01-2024</td>
                    <td>Diterima</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Surat B</td>
                    <td>02-01-2024</td>
                    <td>Dikirim</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Surat C</td>
                    <td>03-01-2024</td>
                    <td>Dalam Proses</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- navigasi -->

    <?php if ( $halamanAktif > 1 ) : ?>
    <a href="?halaman=<?= $halamanAktif -1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for (  $i = 1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if ( $i == $halamanAktif ) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i ?> </a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i ?> </a>
        <?php endif; ?>    
    <?php endfor; ?>

    <?php if ( $halamanAktif < $jumlahHalaman ) : ?>
    <a href="?halaman=<?= $halamanAktif +1; ?>">&raquo;</a>
    <?php endif; ?>

    <script>
        const sidebar = document.querySelector(".sidebar");
        const hamburgerIcon = document.querySelector("#hamburger-icon");
        const cardContainer = document.querySelector(".card-container");

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