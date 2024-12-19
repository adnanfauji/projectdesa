<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"])) {

    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

    if ($mysqli->affected_rows) {
      $mail = require __DIR__ . "/mailer.php";

      $mail->setFrom("noreply@gmail.com");
      $mail->addAddress("$email");
      $mail->Subject = "Password Reset";
      $mail->Body = <<<END

  Click <a href="http://localhost/web_programming2024/tutorial/Latihan/reset_password/reset-password.php?token=$token">here</a>
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
