<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki hak akses admin
if (!isset($_SESSION["username"])) {
  header("Location: index.php"); // Arahkan ke halaman login jika tidak memiliki akses
  exit;
}

require 'db_connect.php'; // Koneksi database
require 'functions.php'; // Fungsi untuk mendapatkan pengguna
// Query untuk mengambil data pengajuan yang telah diproses
// $query = "SELECT p.nama_penduduk, pg.id_pengajuan, pg.tanggal_pengajuan, pg.status_pengajuan, f.tipe_formulir
//           FROM Penduduk p
//           JOIN Pengajuan pg ON p.nik_penduduk = pg.nik_penduduk
//           JOIN Formulir f ON pg.id_pengajuan = f.id_pengajuan";
// $result = mysqli_query($connect, $query);


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


// Query untuk mengambil data pengajuan yang telah diproses
$queryPermohonan = "SELECT p.nama_penduduk, pg.id_pengajuan, pg.tanggal_pengajuan, pg.status_pengajuan, f.tipe_formulir
                    FROM Penduduk p
                    JOIN Pengajuan pg ON p.nik_penduduk = pg.nik_penduduk
                    JOIN Formulir f ON pg.id_pengajuan = f.id_pengajuan
                    WHERE pg.status_pengajuan NOT IN ('Approved', 'Rejected')";

$resultPermohonan = mysqli_query($connect, $queryPermohonan);


// Query untuk mengambil data penduduk (Data Pemohon)
$queryPemohon = "SELECT nama_penduduk, foto_penduduk FROM Penduduk";
$resultPemohon = mysqli_query($connect, $queryPemohon);


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
              <span class="nav_image"><img src="img/loga_sinapen-new.png" alt="logo_img" /></span>
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
          <a href="#">
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
      <!-- <div class="cardBox">
        <div class="card_pending">
          <div>
            <div class="number">4</div>
            <div class="cardName">Permohonan Pending</div>
          </div>
          <div class="iconBox">
            <ion-icon name="documents-outline"></ion-icon>
          </div>
        </div>
        <div class="card_disetujui">
          <div>
            <div class="number">2</div>
            <div class="cardName">Permohonan Disetujui</div>
          </div>
          <div class="iconBox">
            <ion-icon name="documents-outline"></ion-icon>
          </div>
        </div>
        <div class="card_ditolak">
          <div>
            <div class="number">2</div>
            <div class="cardName">Permohonan Ditolak</div>
          </div>
          <div class="iconBox">
            <ion-icon name="documents-outline"></ion-icon>
          </div>
        </div>
      </div> -->

      <div class="details">
        <div class="recentOrders">
          <div class="cardHeader">
            <h2>Data Permohonan Surat</h2>
            <a href="#" class="btn">View All</a>
          </div>
          <table>
            <thead>
              <tr>
                <td>Nama Penduduk</td>
                <td>Tanggal Pengajuan</td>
                <td>Tipe Formulir</td>
                <td>Aksi</td>
              </tr>
            </thead>
            <tbody>
              <?php
              // Loop untuk menampilkan setiap pengajuan yang diambil dari database
              while ($row = mysqli_fetch_assoc($resultPermohonan)) {
                // Skip rows where the status is 'Approved'
                if ($row['status_pengajuan'] === 'Approved') {
                  continue;
                }

                // Tentukan kelas status untuk styling
                $status_class = '';
                switch ($row['status_pengajuan']) {
                  case 'Pending':
                    $status_class = 'pending';
                    break;
                  case 'Rejected':
                    $status_class = 'return';
                    break;
                }

                echo "<tr>
            <td>{$row['nama_penduduk']}</td>
            <td>{$row['tanggal_pengajuan']}</td>
            <td>{$row['tipe_formulir']}</td>
            <td>
                <form action='process_action.php' method='POST'>
                    <input type='hidden' name='id_pengajuan' value='{$row['id_pengajuan']}'>
                    <button type='submit' name='action' value='approve'>Approve</button>
                    <button type='submit' name='action' value='reject'>Reject</button>
                </form>
            </td>
          </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- <div class="recentCustomer">
          <div class="cardHeader">
            <h2>Data Pemohon</h2>
          </div>
          <table>
            
            // if (mysqli_num_rows($resultPemohon) > 0) {
            //   while ($row = mysqli_fetch_assoc($resultPemohon)) {
            //     $fotoPath = 'img/' . $row['foto_penduduk'];
            //     $foto = (!empty($row['foto_penduduk']) && file_exists($fotoPath)) ? $fotoPath : 'img/user-avatar.png';
            //     echo "
            //       <tr>
            //           <td width='60px'>
            //               <div class='imgbx'>
            //                   <img src='$foto' alt='Foto Pemohon'>
            //               </div>
            //           </td>
            //           <td>
            //               <h4>{$row['nama_penduduk']}</h4>
            //           </td>
            //       </tr>";
            //   }
            // } else {
            //   echo "<tr><td colspan='2'>Tidak ada data penduduk.</td></tr>";
            // }
            
          </table>
        </div> -->
      </div>
    </div>
  </div>


  <!-- memanggil file javascript / main.js -->
  <script src="JS/admin_main.js"></script>
  <!-- ========================================ionicon========================== -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>