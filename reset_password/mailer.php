<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require __DIR__ . "/vendor/autoload.php";

// $mail = new PHPMailer(true);

// // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

// $mail->isSMTP();
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
// $mail->Port = 587;
// $mail->Username = "adnan.fauji.fict@krw.horizon.ac.id";
// $mail->Password = "B@lqis123";

// $mail->isHTML(true);

// return $mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);

try {
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Aktifkan untuk debugging jika perlu

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP yang benar
  $mail->SMTPAuth = true;
  $mail->Username = "adnanfauji48@gmail.com";
  $mail->Password = "wrvn sglc azca wzog";
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->setFrom("adnanfauji48@gmail.com", "Adnan"); // Ganti dengan nama pengirim

  $mail->isHTML(true);

  return $mail;
} catch (Exception $e) {
  echo "Mailer Error: " . $mail->ErrorInfo;
}
