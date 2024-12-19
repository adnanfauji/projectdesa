<?php
// restore.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sqlFile'])) {
  $file = $_FILES['sqlFile']['tmp_name'];  // Mengambil file SQL yang di-upload
  $filename = $_FILES['sqlFile']['name'];

  // Memastikan bahwa file yang di-upload adalah file .sql
  if (pathinfo($filename, PATHINFO_EXTENSION) !== 'sql') {
    echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak valid!']);
    exit;
  }

  // Perintah untuk melakukan restore database dari file SQL
  $command = "mysql --user=root --password=B@lqis123 --host=localhost projectdesa < $file";

  // Menjalankan perintah restore
  exec($command, $output, $return_var);

  // Cek apakah restore berhasil
  if ($return_var === 0) {
    echo json_encode(['status' => 'success', 'message' => 'Database berhasil dipulihkan!']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Restore gagal!']);
  }
}
