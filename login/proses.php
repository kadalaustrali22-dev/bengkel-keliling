<?php

session_start();

include "../koneksi.php";


$username = $_POST['username'];
$password = $_POST['password'];


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE username = '$username' LIMIT 1"
);


$user = mysqli_fetch_assoc($query);


if ($user && $password === $user['password']) {

    $_SESSION['user_id'] = $user['id'];

    $_SESSION['username'] = $user['username'];

    $_SESSION['role'] = $user['role'];


    header("Location: ../dashboard/index.php");

    exit;

} else {

    header("Location: index.php?error=1");

    exit;
}

?>