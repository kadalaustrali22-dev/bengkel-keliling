<?php

include "../koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "
    DELETE FROM penugasan
    WHERE id = '$id'
");

header("Location: index.php");
exit;

?>