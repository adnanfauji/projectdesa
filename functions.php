<?php

// Koneksi ke database
$connect = mysqli_connect("localhost", "root", "B@lqis123", "projectdesa");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

function query($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connect));
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $connect;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($connect, $data["password"]);
    $password2 = mysqli_real_escape_string($connect, $data["password2"]);

    // Username sudah ada atau belum
    $result = mysqli_query($connect, "SELECT username FROM user WHERE username = '$username' ");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Username sudah terdaftar!');
            window.location.href = 'registrasi.php'; // Redirect ke halaman pendaftaran
        </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
            alert('Konsfirmasi password tidak sesuai!');
            window.location.href = 'registrasi.php'; // Redirect ke halaman pendaftaran
        </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan userbaru ke database
    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($connect, $query);
    if (mysqli_error($connect)) {
        die("Query failed: " . mysqli_error($connect));
    }
    return mysqli_affected_rows($connect);
}

function getPendingUsers()
{
    global $connect;

    // Mengambil pengguna dengan status 'pending'
    $query = "SELECT * FROM user WHERE status = 'pending'";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connect));
    }

    $pendingUsers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $pendingUsers[] = $row;
    }
    return $pendingUsers;
}

function getApprovedUsers()
{
    global $connect;

    $query = "SELECT id, username, email, approved_at FROM user WHERE status = 'approved'";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connect));
    }

    $approvedUsers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $approvedUsers[] = $row;
    }
    return $approvedUsers;
}

function check_cookie_login()
{
    global $connect;

    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        // Ambil username berdasarkan id
        $result = mysqli_query($connect, "SELECT username FROM user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        // Cek cookie dan username
        if ($key === hash('sha256', $row['username'])) {
            // Set session jika cookie valid
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['superuser'] = $row['is_admin'] == 1;
        }
    }
}

function is_admin()
{
    return isset($_SESSION['superuser']) && $_SESSION['superuser'];
}

function is_logged_in()
{
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang di upload
    if ($error === UPLOAD_ERR_NO_FILE) {
        echo "
            <script>
                alert('Pilih gambar terlebuh dahulu!');
            </script>
            ";
        return false;
    }

    // Cek apakah yang di upload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Yang anda upload bukan gambar!');
            </script>
            ";
        return false;
    }

    // Cek jika ukuran terlalu besar
    if ($ukuranFile > 1000000) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
            </script>
            ";
        return false;
    }

    // Lolos pengecekan, gambar siap di upload
    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}
