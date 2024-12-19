    <?php
    session_start();

    require 'db_connect.php'; // Koneksi database
    require 'functions.php'; // Fungsi untuk mendapatkan pengguna

    // Cek apakah pengguna sudah login dan memiliki hak akses admin
    if (!isset($_SESSION["username"])) {
        header("Location: index.php"); // Arahkan ke halaman login jika tidak memiliki akses
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

    // Fungsi untuk mengambil data berdasarkan status pengajuan
    function getPengajuanByStatus($connect, $status)
    {
        $query = "SELECT p.nama_penduduk, pg.id_pengajuan, pg.tanggal_pengajuan, pg.status_pengajuan, f.tipe_formulir
              FROM Penduduk p
              JOIN Pengajuan pg ON p.nik_penduduk = pg.nik_penduduk
              JOIN Formulir f ON pg.id_pengajuan = f.id_pengajuan
              WHERE pg.status_pengajuan = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Hitung jumlah pengajuan berdasarkan status
    function countPengajuanByStatus($connect, $status)
    {
        $query = "SELECT COUNT(*) as total FROM Pengajuan WHERE status_pengajuan = ?";
        $stmt = $connect->prepare($query);
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    // Ambil data jumlah pengajuan
    $total_pending = countPengajuanByStatus($connect, 'Pending');
    $total_approved = countPengajuanByStatus($connect, 'Approved');
    $total_rejected = countPengajuanByStatus($connect, 'Rejected');

    // Status default atau status dari request
    $status_filter = $_GET['status'] ?? 'Pending';
    $filtered_pengajuan = getPengajuanByStatus($connect, $status_filter);

    // // Query untuk mengambil data pengajuan yang telah diproses
    // $query = "SELECT p.nama_penduduk, pg.id_pengajuan, pg.tanggal_pengajuan, pg.status_pengajuan, f.tipe_formulir
    //       FROM Penduduk p
    //       JOIN Pengajuan pg ON p.nik_penduduk = pg.nik_penduduk
    //       JOIN Formulir f ON pg.id_pengajuan = f.id_pengajuan";
    // $result = mysqli_query($connect, $query);

    // // Query untuk menghitung jumlah pengajuan berdasarkan status
    // $query_pending = "SELECT COUNT(*) as total_pending FROM Pengajuan WHERE status_pengajuan = 'Pending'";
    // $query_approved = "SELECT COUNT(*) as total_approved FROM Pengajuan WHERE status_pengajuan = 'Approved'";
    // $query_rejected = "SELECT COUNT(*) as total_rejected FROM Pengajuan WHERE status_pengajuan = 'Rejected'";

    // $result_pending = mysqli_query($connect, $query_pending);
    // $result_approved = mysqli_query($connect, $query_approved);
    // $result_rejected = mysqli_query($connect, $query_rejected);

    // // Ambil hasil query
    // $row_pending = mysqli_fetch_assoc($result_pending);
    // $row_approved = mysqli_fetch_assoc($result_approved);
    // $row_rejected = mysqli_fetch_assoc($result_rejected);

    // // Ambil jumlah masing-masing status
    // $total_pending = $row_pending['total_pending'];
    // $total_approved = $row_approved['total_approved'];
    // $total_rejected = $row_rejected['total_rejected'];

    // // Ambil pengguna pending
    // $pendingUsers = getPendingUsers();

    // // Ambil pengguna yang disetujui
    // $approvedUsers = getApprovedUsers();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>
        <!-- stylesheet -->
        <link rel="stylesheet" href="admin.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    </head>

    <body>
        <!-- navigation -->
        <div class="container">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon">
                                <span class="nav_image"><img src="img/logo_sinapen.png" alt="logo_img" /></span>
                            </span>
                            <span class="title">SINAPEN</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_dashboard.php">
                            <span class="icon">
                                <ion-icon name="home-outline"></ion-icon>
                            </span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="permohonan_surat.php">
                            <span class="icon">
                                <ion-icon name="people-outline"></ion-icon>
                            </span>
                            <span class="title">Permohonan Surat</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </span>
                            <span class="title">Kategori Surat</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="logout.php">
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
                            <input type="text" id="search" placeholder="search here" />
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </div>
                    <div class="user-info">
                        <div class="data_text">
                            <span class="name"><?php echo htmlspecialchars($display_username); ?></span>
                            <span class="email"><?php echo htmlspecialchars($display_email); ?></span>
                        </div>
                        <span class="nav_image">
                            <img src="/projectdesa/img/logo_example.jpeg" alt="logo_img" />
                        </span>
                    </div>
                </div>
                <!-- ======= card ===== -->
                <div class="cardBox">
                    <div class="card_pending" onclick="filterPengajuan('Pending')">
                        <div>
                            <div class="number"><?php echo $total_pending; ?></div>
                            <div class="cardName">Permohonan Pending</div>
                        </div>
                        <div class="iconBox">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="card_disetujui" onclick="filterPengajuan('Approved')">
                        <div>
                            <div class=" number"><?php echo $total_approved; ?></div>
                            <div class="cardName">Permohonan Disetujui</div>
                        </div>
                        <div class="iconBox">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                    </div>
                    <div class="card_ditolak" onclick="filterPengajuan('Rejected')">
                        <div>
                            <div class="number"><?php echo $total_rejected; ?></div>
                            <div class="cardName">Permohonan Ditolak</div>
                        </div>
                        <div class="iconBox">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                    </div>
                </div>

                <div class="details">
                    <div class="recentOrders">
                        <div class="cardHeader">
                            <h2>Data Permohonan (<?php echo $status_filter; ?>)</h2>
                            <a href="#" class="btn">View All</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <td>Nama Penduduk</td>
                                    <td>Tanggal Pengajuan</td>
                                    <td>Tipe Formulir</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $filtered_pengajuan->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?php echo $row['nama_penduduk']; ?></td>
                                        <td><?php echo $row['tanggal_pengajuan']; ?></td>
                                        <td><?php echo $row['tipe_formulir']; ?></td>
                                        <td><?php echo $row['status_pengajuan']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="recentCustomer">
                        <div class="cardHeader">
                            <h2>Data Pemohon</h2>
                        </div>
                        <table>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Dadang <br />
                                        <span>Indonesia</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        John <br />
                                        <span>England</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Suny <br />
                                        <span>US</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Dany <br />
                                        <span>Swiss</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Andrew <br />
                                        <span>US</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Witney <br />
                                        <span>Spain</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Mark <br />
                                        <span>Italy</span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <td width="60px">
                                    <div class="imgbx">
                                        <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png"
                                            alt="">
                                    </div>
                                </td>
                                <td>
                                    <h4>
                                        Rian <br />
                                        <span>France</span>
                                    </h4>
                                </td>
                            </tr>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>

        <script>
            // Fungsi untuk mengubah filter pengajuan berdasarkan status
            function filterPengajuan(status) {
                window.location.href = `admin_dashboard.php?status=${status}`;
            }
        </script>


        <!-- memanggil file javascript / main.js -->
        <script src="JS/admin_main.js"></script>
        <!-- ========================================ionicon========================== -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>

    </html>