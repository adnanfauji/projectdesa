<?php
session_start();
require 'db_connect.php'; // Koneksi database
require 'functions.php'; // Fungsi untuk mendapatkan pengguna

// Cek apakah pengguna sudah login dan memiliki hak akses admin
if (!isset($_SESSION["login"]) || !isset($_SESSION["superuser"]) || !$_SESSION["superuser"]) {
    header("Location: login.php"); // Arahkan ke halaman login jika tidak memiliki akses
    exit;
}




// Ambil pengguna pending
$pendingUsers = getPendingUsers();

// Ambil pengguna yang disetujui
$approvedUsers = getApprovedUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <!-- stylesheet -->
    <link rel="stylesheet" href="adminstyle.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- memanggil file javascript / main.js -->
    <script src="/JS/adminmain.js"></script>
    <!-- ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <!-- navigation -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="school-outline"></ion-icon>
                        </span>
                        <span class="title">Administrator</span>
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
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Permohonan Surat</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Kategori Surat</span>
                    </a>
                </li>
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
                <div class="user">
                    <img src="/web_programming2024/si2b-adnanfauji/web_projectclass/pertemuan3/img/user-avatar.png" alt="">
                </div>
            </div>
            <!-- ======= card ===== -->
            <div class="cardBox">
                <div class="card_pending">
                    <div>
                        <div class="number">24</div>
                        <div class="cardName">Permohonan Pending</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="documents-outline"></ion-icon>
                    </div>
                </div>
                <div class="card_disetujui">
                    <div>
                        <div class="number">1539</div>
                        <div class="cardName">Permohonan Disetujui</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="documents-outline"></ion-icon>
                    </div>
                </div>
                <div class="card_ditolak">
                    <div>
                        <div class="number">10</div>
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
                        <h2>Recent Orders</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Star Delivery</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                            <tr>
                                <td>Acer</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Dell Laptop</td>
                                <td>$1200</td>
                                <td>Due</td>
                                <td><span class="status return">Return</span></td>
                            </tr>
                            <tr>
                                <td>Hp Laptop</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status inprogress">In Progress</span></td>
                            </tr>
                            <tr>
                                <td>Star Delivery</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                            <tr>
                                <td>Acer</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Dell Laptop</td>
                                <td>$1200</td>
                                <td>Due</td>
                                <td><span class="status return">Return</span></td>
                            </tr>
                            <tr>
                                <td>Hp Laptop</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status inprogress">In Progress</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="recentCustomer">
                    <div class="cardHeader">
                        <h2>Recent Customer</h2>
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<!-- <h1>Admin Dashboard</h1>

        <h3>Pending Users:</h3>
        <?php if (!empty($pendingUsers)): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($pendingUsers as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['status']); ?></td>
                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <form action="/projectdesa/approve_reject.php" method="post" class="form-action">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                <button type="submit" id="action" name="action">Approve</button>
                                <button type="submit" id="action" name="action">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No pending users.</p>
        <?php endif; ?>

        <h3>Approved Users:</h3>
        <?php if (!empty($approvedUsers)): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Approved At</th>
                </tr>
                <?php foreach ($approvedUsers as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo ($user['approved_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No approved users.</p>
        <?php endif; ?>
        <div>
            <label for="logout"></label>
            <a href="/projectdesa/logout.php" class="logout">logout</a>
        </div>
    </div>
</body>

</html> -->