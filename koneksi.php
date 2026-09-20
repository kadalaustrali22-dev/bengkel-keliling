<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bengkel_keliling";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>