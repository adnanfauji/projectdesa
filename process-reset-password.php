<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$connect = require __DIR__ . "/db_connect.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $connect->prepare($sql);
if ($stmt === false) {
  die("Database error: " . $connect->error);
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
  die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
  die("token has expired");
}

if (strlen($_POST["new-password"]) < 8) {
  die("Password must be at least 8 characters");
}

if (! preg_match("/[a-z]/i", $_POST["new-password"])) {
  die("Password must contain at least one letter");
}

if (! preg_match("/[0-9]/", $_POST["new-password"])) {
  die("Password must contain at least one number");
}

if ($_POST["new-password"] !== $_POST["confirm-password"]) {
  die("Passwords must match");
}

$password_hash = password_hash($_POST["new-password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();

// Redirect dengan pesan dialog
echo "<script>
    alert('Password updated successfully. You can now login.');
    window.location.href = '/projectdesa/index.php';  
</script>";
exit;
