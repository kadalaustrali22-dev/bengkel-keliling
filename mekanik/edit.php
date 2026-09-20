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


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM mekanik WHERE id = $id"
);

$mekanik = mysqli_fetch_assoc($query);


if (!$mekanik) {
    header("Location: index.php");
    exit;
}


if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );

    $no_hp = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_hp']
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );


    mysqli_query(
        $koneksi,
        "UPDATE mekanik SET
            nama = '$nama',
            no_hp = '$no_hp',
            status = '$status'
        WHERE id = $id"
    );


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

    <title>Edit Mekanik - Bengkel Keliling</title>

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
            <a href="index.php" class="active">
                Mekanik
            </a>
        </li>

        <li>
            <a href="../penugasan/index.php">
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

            <h1>Edit Mekanik</h1>

            <p>
                Perbarui data mekanik
            </p>

        </div>

    </div>


    <div class="content-card">

        <form method="POST">


            <div class="form-group">

                <label for="nama">
                    Nama Mekanik
                </label>

                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="form-control"
                    value="<?= htmlspecialchars($mekanik['nama']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="no_hp">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    id="no_hp"
                    class="form-control"
                    value="<?= htmlspecialchars($mekanik['no_hp']); ?>"
                >

            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option
                        value="tersedia"
                        <?= $mekanik['status'] == 'tersedia' ? 'selected' : ''; ?>
                    >
                        Tersedia
                    </option>

                    <option
                        value="sedang_servis"
                        <?= $mekanik['status'] == 'sedang_servis' ? 'selected' : ''; ?>
                    >
                        Sedang Servis
                    </option>

                    <option
                        value="tidak_aktif"
                        <?= $mekanik['status'] == 'tidak_aktif' ? 'selected' : ''; ?>
                    >
                        Tidak Aktif
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