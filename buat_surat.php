<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'db_connect.php';
require 'functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Surat Baru</title>
    <link rel="stylesheet" href="buat_surat.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        /* CSS tambahan untuk efek hover */
        .clickable-header {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        .clickable-header:hover {
            color: #4070f4;
        }

        .hoverable-header {
            transition: background-color 0.3s ease;
        }

        .hoverable-header:hover {
            background-color: #f1f1f1;
        }

        .content-class {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .input-with-icon {
            position: relative;
            display: flex; /* Menggunakan flex untuk tata letak */
            align-items: center; /* Rata tengah secara vertikal */
        }

        .input-with-icon .search-icon {
            position: absolute;
            right: 10px; /* Jarak dari kanan */
            top: 50%; /* Posisikan vertikal di tengah */
            transform: translateY(-50%); /* Pusatkan secara vertikal */
            color: #aaa;
        }

        .input-with-icon input {
            padding-right: 30px; /* Tambah padding untuk ruang ikon */
        }
    </style>
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
                    <li class="item"><a href="/projectdesa/user_dashboard.php" class="link flex"><i class="bx bx-home-alt"></i><span>Home</span></a></li>
                    <li class="item"><a href="#" class="link flex"><i class="fas fa-plus-circle"></i><span>Tambah Surat</span></a></li>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-mail-send"></i><span>Surat Masuk</span></a></li>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-paper-plane"></i><span>Surat Keluar</span></a></li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Arsip</span>
                        <span class="line"></span>
                    </div>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-folder-open"></i><span>Arsip Surat Masuk</span></a></li>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-file"></i><span>Arsip Surat Keluar</span></a></li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Laporan</span>
                        <span class="line"></span>
                    </div>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-clipboard"></i><span>Laporan</span></a></li>
                </ul>
                <ul class="menu_item">
                    <div class="menu_title flex">
                        <span class="title">Setting</span>
                        <span class="line"></span>
                    </div>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-cloud"></i><span>Backup & Restore</span></a></li>
                    <li class="item"><a href="#" class="link flex"><i class="bx bx-cog"></i><span>Setting</span></a></li>
                    <li class="item"><a href="/projectdesa/logout.php" class="link flex"><i class="bx bx-log-out"></i><span>Log Out</span></a></li>
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
        <input type="text" placeholder="Search..." class="search_box" />
        <span class="nav_image"><img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" /></span>
    </nav>

    <div class="container">
        <div class="header-container title">
            <h1>Buat Surat Baru</h1>
            <div class="divider"></div>
        </div>
        <div class="header-container flex">
            <h2>Surat Internal Desa</h2>
            <input type="submit" value="Surat Masuk Instani Eksternal" class="submit-button" />
        </div>
        <div class="divider"></div>
        <div class="header-container sub-title">
            <h3>Header Surat</h3>
        </div>
        <div class="divider"></div>
        <div class="content">
            <form onsubmit="handleSubmit(event)">
                <div class="input-box">
                    <label>Nomor Surat</label>
                    <div class="input-with-icon">
                        <input id="new-password" type="search" required oninput="validatePassword()" />
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="input-box">
                    <label>Jenis Surat</label>
                    <select id="jenis-surat" class="select-box" required>
                        <option value="" disabled selected>Pilih Jenis Surat</option>
                        <option value="surat-umum">Surat Umum</option>
                        <option value="surat-peribadi">Surat Peribadi</option>
                    </select>
                </div>
                <div class="input-box">
                    <label>Perihal</label>
                    <textarea id="perihal" class="perihal" required></textarea>
                </div>                             
            </form>
            <form>
                <div class="input-box">
                    <label>Tanggal Surat</label>
                    <input id="Tanggal-surat" type="date" required />
                </div>
                <div class="input-box">
                    <label>Sifat Surat</label>
                    <select id="sifat-surat" class="select-box" required>
                        <option value="" disabled selected>Pilih Sifat Surat</option>
                        <option value="penting">Penting</option>
                        <option value="biasa">Biasa</option>
                        <option value="rahasia">Rahasia</option>
                    </select>
                </div>
                <div class="input-box">
                    <label>Bidang/Sub</label>
                    <div class="input-with-icon">
                        <input id="bidang-sub" type="search" required />
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sidebar = document.querySelector(".sidebar");
        const hamburgerIcon = document.querySelector("#hamburger-icon");
        const tableContainer = document.querySelector(".container");
        
        const toggleSidebar = () => {
            sidebar.classList.toggle("close");

            if (sidebar.classList.contains("close")) {
                tableContainer.style.marginLeft = "75px"; 
                document.querySelector('.navbar').style.width = "calc(100% - 75px)"; 
                document.querySelector('.navbar').style.left = "75px"; 
                hamburgerIcon.classList.remove("bx-menu"); 
                hamburgerIcon.classList.add("bx-x"); 
            } else {
                tableContainer.style.marginLeft = "270px"; 
                document.querySelector('.navbar').style.width = "calc(100% - 270px)"; 
                document.querySelector('.navbar').style.left = "270px"; 
                hamburgerIcon.classList.remove("bx-x"); 
                hamburgerIcon.classList.add("bx-menu"); 
            }
        };

        // Event listener untuk ikon hamburger
        hamburgerIcon.addEventListener("click", toggleSidebar);

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
