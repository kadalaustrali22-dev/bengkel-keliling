<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}


$id = (int) $_GET['id'];


mysqli_query(
    $koneksi,
    "DELETE FROM kendaraan WHERE id = $id"
);


header("Location: index.php");

exit;

?>