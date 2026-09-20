<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


$id = $_GET['id'];


$data = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT *
    FROM penugasan
    WHERE id = '$id'
"));


if (!$data) {
    die("Data penugasan tidak ditemukan.");
}


if (isset($_POST['update'])) {

    $status = $_POST['status'];

    mysqli_query($koneksi, "
        UPDATE penugasan
        SET status = '$status'
        WHERE id = '$id'
    ");

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Penugasan - Bengkel Keliling</title>

    <link
        rel="stylesheet"
        href="../assets/css/dashboard.css"
    >

</head>

<body>

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="sidebar-brand">

        <h3>Bengkel Keliling</h3>

        <p>Service on location</p>

    </div>


    <ul class="sidebar-menu">

        <li>
            <a href="../dashboard/index.php">
                Dashboard
            </a>
        </li>

        <li>
            <a href="../pelanggan/index.php">
                Pelanggan
            </a>
        </li>

        <li>
            <a href="../kendaraan/index.php">
                Kendaraan
            </a>
        </li>

        <li>
            <a href="../permintaan/index.php">
                Permintaan Servis
            </a>
        </li>

        <li>
            <a href="../mekanik/index.php">
                Mekanik
            </a>
        </li>

        <li>
            <a href="index.php" class="active">
                Penugasan
            </a>
        </li>

        <li>
            <a href="../riwayat/index.php">
                Riwayat Servis
            </a>
        </li>

        <li class="logout-menu">
            <a href="../login/logout.php">
                Logout
            </a>
        </li>

    </ul>

</aside>


<!-- MAIN -->

<main class="main-content">

    <div class="page-header">

        <div>

            <h1>Edit Penugasan</h1>

            <p>
                Perbarui status penugasan mekanik
            </p>

        </div>

    </div>


    <div class="content-card">

        <form method="POST">

            <div class="form-group">

                <label for="status">
                    Status Penugasan
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option
                        value="ditugaskan"
                        <?= $data['status'] == 'ditugaskan' ? 'selected' : ''; ?>
                    >
                        Ditugaskan
                    </option>

                    <option
                        value="diproses"
                        <?= $data['status'] == 'diproses' ? 'selected' : ''; ?>
                    >
                        Diproses
                    </option>

                    <option
                        value="selesai"
                        <?= $data['status'] == 'selesai' ? 'selected' : ''; ?>
                    >
                        Selesai
                    </option>

                </select>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    name="update"
                    class="btn-primary"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="index.php"
                    class="btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</main>

</body>
</html>