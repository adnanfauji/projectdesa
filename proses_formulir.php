<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body>
  <?php
  session_start();

  include('db_connect.php');

  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

  // Mengecek apakah formulir telah disubmit
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mendapatkan data dari formulir
    $nik_penduduk = $_POST['nik_penduduk'];
    $nomor_kk = $_POST['nomor_kk'];
    $nama_penduduk = $_POST['nama_penduduk'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $nomor_tlp_penduduk = $_POST['nomor_tlp_penduduk'];
    $id_layanan = $_POST['id_layanan'];
    $tanggal_pengajuan = $_POST['tanggal_pengajuan'];
    $tipe_formulir = $_POST['tipe_formulir'];
    $judul_formulir = $_POST['judul_formulir'];
    $tanggal_formulir = $_POST['tanggal_formulir'];
    $keterangan = $_POST['keterangan'];

    // Menangani upload foto penduduk
    if ($_FILES['foto_penduduk']['error'] === UPLOAD_ERR_OK) {
      $foto_penduduk = $_FILES['foto_penduduk']['name'];
      $foto_tmp = $_FILES['foto_penduduk']['tmp_name'];
      $foto_target = 'img/' . basename($foto_penduduk);

      // Memindahkan foto ke folder tujuan
      if (move_uploaded_file($foto_tmp, $foto_target)) {
        $foto_penduduk_url = $foto_target;
      } else {
        $foto_penduduk_url = null; // Jika upload gagal
      }
    } else {
      $foto_penduduk_url = null; // Jika tidak ada foto yang diupload
    }

    // Langkah 1: Periksa apakah NIK penduduk sudah ada di tabel Penduduk
    $query_cek_penduduk = "SELECT nik_penduduk FROM penduduk WHERE nik_penduduk = '$nik_penduduk'";
    $result_cek_penduduk = mysqli_query($connect, $query_cek_penduduk);

    if (mysqli_num_rows($result_cek_penduduk) === 0) {
      // Jika NIK tidak ditemukan, masukkan data ke tabel Penduduk
      $query_insert_penduduk = "INSERT INTO penduduk (nik_penduduk, nomor_kk, nama_penduduk, jenis_kelamin, tanggal_lahir, alamat, foto_penduduk, nomor_tlp_penduduk) 
                               VALUES ('$nik_penduduk', '$nomor_kk', '$nama_penduduk', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$foto_penduduk_url', '$nomor_tlp_penduduk')";
      if (!mysqli_query($connect, $query_insert_penduduk)) {
        die("Error saat menyimpan data penduduk: " . mysqli_error($connect));
      }
    }

    // Langkah 2: Masukkan data ke tabel Pengajuan
    $query_insert_pengajuan = "INSERT INTO pengajuan (nik_penduduk, tanggal_pengajuan, status_pengajuan) 
                           VALUES ('$nik_penduduk', '$tanggal_pengajuan', 'pending')";
    if (!mysqli_query($connect, $query_insert_pengajuan)) {
      die("Error saat menyimpan data pengajuan: " . mysqli_error($connect));
    }

    // Ambil ID Pengajuan yang baru saja dimasukkan
    $id_pengajuan = mysqli_insert_id($connect);

    // Langkah 3: Masukkan data ke tabel Formulir
    $query_insert_formulir = "INSERT INTO formulir (id_pengajuan, tipe_formulir, judul_formulir, tanggal_formulir) 
                          VALUES ('$id_pengajuan', '$tipe_formulir', '$judul_formulir', '$tanggal_formulir')";

    // Menjalankan query formulir terlebih dahulu untuk mendapatkan id_formulir
    if (mysqli_query($connect, $query_insert_formulir)) {
      // Ambil ID Formulir yang baru saja dimasukkan
      $id_formulir = mysqli_insert_id($connect);

      // Langkah 4: Masukkan data ke tabel Laporan
      $query_insert_laporan = "INSERT INTO laporan (id_formulir, judul_laporan, isi_laporan, tanggal_laporan) 
        VALUES ('$id_formulir', '$judul_formulir', '$keterangan', '$tanggal_formulir')";

      if (mysqli_query($connect, $query_insert_laporan)) {
        // Jika berhasil, lanjutkan SweetAlert sukses
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Formulir Berhasil Diajukan!',
                text: 'Data formulir telah berhasil disimpan, termasuk ke dalam laporan.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'user_dashboard.php';
                }
            });
            </script>";
      } else {
        // Jika gagal menyimpan ke laporan, tampilkan error
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat menyimpan data ke laporan.',
                confirmButtonText: 'Coba Lagi',
                confirmButtonColor: '#d33'
            });
            </script>";
      }
    }

    // Menutup koneksi database
    mysqli_close($connect);
  }
  ?>
</body>

</html>