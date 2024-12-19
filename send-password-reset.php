<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"])) {

    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

    if ($email === false) {
      die("Email tidak valid.");
    }

    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $connect = require __DIR__ . "/db_connect.php";

    $sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
      die("Terjadi kesalahan pada saat menyiapkan statement.");
    }

    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

    if ($connect->affected_rows) {
      $mail = require __DIR__ . "/mailer.php";

      $mail->setFrom("noreply@gmail.com");
      $mail->addAddress($email);
      $mail->Subject = "Password Reset";
      $mail->Body = <<<END

  Click <a href="http://localhost/projectdesa/reset-password.php?token=$token">here</a>
  to reset your password.

  END;

      try {
        $mail->send();
        echo "Message sent, please check your inbox.";
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
      }
    } else {
      echo "Email tidak ditemukan atau tidak valid.";
    }
  } else {
    die("Email tidak ditemukan. Silakan masukkan email Anda.");
  }
} else {
  die("Invalid request method.");
}
