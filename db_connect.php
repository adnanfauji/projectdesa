<?php
$connect = mysqli_connect("localhost", "root", "B@lqis123", "projectdesa");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
return $connect;
