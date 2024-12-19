<?php
// backup.php
$folderPath = 'backup_database/'; // Pastikan folder ini ada dan memiliki izin akses
$filename = $folderPath . 'backup_' . date('Ymd_His') . '.sql';  // Nama file backup berdasarkan tanggal dan waktu
$command = "mysqldump --user=root --password=B@lqis123 --host=localhost projectdesa > $filename";  // Perintah untuk backup

// Menjalankan perintah backup
exec($command, $output, $return_var);

// Cek apakah backup berhasil
if ($return_var === 0) {
  // Jika backup berhasil, kirimkan response success
  echo json_encode(['status' => 'success', 'filename' => $filename]);
} else {
  // Jika backup gagal, kirimkan response error
  echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat melakukan backup.']);
}
