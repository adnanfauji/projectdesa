<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

require 'db_connect.php'; // Pastikan file ini untuk koneksi database tersedia

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

// Fungsi untuk mengambil data laporan dari database
// Fungsi untuk mengambil data laporan berdasarkan filter tanggal
function getLaporan($connect, $startDate = null, $endDate = null)
{
    $query = "SELECT id_laporan, tanggal_laporan, judul_laporan, isi_laporan FROM laporan";
    if ($startDate && $endDate) {
        $query .= " WHERE tanggal_laporan BETWEEN ? AND ?";
    }
    $query .= " ORDER BY tanggal_laporan DESC";

    $stmt = $connect->prepare($query);
    if ($startDate && $endDate) {
        $stmt->bind_param("ss", $startDate, $endDate);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return [];
    }
}

// Ambil filter tanggal dari form
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Ambil data laporan
$laporan = getLaporan($connect, $startDate, $endDate);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan</title>
    <link rel="stylesheet" href="laporan.css" />
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
                <img src="<?php echo htmlspecialchars($display_profile_picture); ?>" alt="logo_img" />
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <!-- Bagian Laporan -->
            <h1>Daftar Laporan</h1>
            <div class="table-header">
                <h2>Tabel Laporan</h2>
                <form action="cetak_laporan.php" method="post" target="_blank">
                    <button type="submit" class="btn-cetak">🖨 Cetak Laporan</button>
                    <!-- Anda dapat menambahkan input tersembunyi untuk laporan yang dipilih jika diperlukan -->
                    <input type="hidden" name="laporan_ids" id="laporan_ids">
                </form>
            </div>
            <div class="filter-section">
                <form method="GET" action="laporan.php">
                    <label for="start-date">Tanggal Awal:</label>
                    <input type="date" name="start_date" id="start-date" value="<?php echo htmlspecialchars($startDate ?? ''); ?>">
                    <label for="end-date">Tanggal Akhir:</label>
                    <input type="date" name="end_date" id="end-date" value="<?php echo htmlspecialchars($endDate ?? ''); ?>">
                    <button type="submit" class="btn-search">Cari</button>
                    <button type="button" id="btn-clear" class="btn-clear">Clear</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Laporan</th>
                        <th>Judul Laporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($laporan) {
                        $no = 1;
                        while ($row = $laporan->fetch_assoc()) {
                            echo "<tr data-id='{$row['id_laporan']}'>
                            <td class='select-cell' style='cursor: pointer;'>
                                    <input type='checkbox' name='laporan[]' value='{$row['id_laporan']}'>
                                </td>
                            <td>{$row['tanggal_laporan']}</td>
                            <td>{$row['judul_laporan']}</td>
                            <td><a href='detail_laporan.php?id={$row['id_laporan']}' class='btn-detail'>Detail</a></td>
                        </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tidak ada data laporan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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

        document.querySelector(".btn-cetak").addEventListener("click", function(event) {
            var selectedLaporan = [];
            document.querySelectorAll("input[name='laporan[]']:checked").forEach(function(checkbox) {
                selectedLaporan.push(checkbox.value);
            });

            if (selectedLaporan.length === 0) {
                // Mencegah pengiriman form jika tidak ada laporan yang dipilih
                event.preventDefault();

                // Tampilkan pesan Sweet Alert
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada laporan yang dipilih',
                    text: 'Silakan pilih laporan yang ingin dicetak!',
                    confirmButtonText: 'OK'
                });
            } else {
                // Masukkan ID laporan yang dipilih ke input hidden
                document.getElementById("laporan_ids").value = selectedLaporan.join(',');
            }
        });

        document.getElementById("btn-clear").addEventListener("click", function() {
            // Kosongkan nilai input tanggal
            document.getElementById("start-date").value = "";
            document.getElementById("end-date").value = "";

            // Redirect ke laporan.php tanpa parameter
            window.location.href = "laporan.php";
        });
    </script>

</body>

</html>