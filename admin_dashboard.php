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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/projectdesa/style.css"> <!-- Ganti dengan file CSS yang sesuai -->
</head>

<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

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

</html>