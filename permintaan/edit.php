<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


$id = $_GET['id'];


$query = mysqli_query($koneksi, "
    SELECT
        ps.*,
        p.nama AS nama_pelanggan,
        k.no_polisi,
        k.merk,
        k.tipe
    FROM permintaan_servis ps
    JOIN pelanggan p ON ps.pelanggan_id = p.id
    JOIN kendaraan k ON ps.kendaraan_id = k.id
    WHERE ps.id = '$id'
");


$data = mysqli_fetch_assoc($query);


if (!$data) {
    die("Data permintaan servis tidak ditemukan.");
}


if (isset($_POST['update'])) {

    $keluhan = $_POST['keluhan'];
    $lokasi = $_POST['lokasi'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "
        UPDATE permintaan_servis
        SET
            keluhan = '$keluhan',
            lokasi = '$lokasi',
            status = '$status'
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

    <title>Edit Permintaan Servis - Bengkel Keliling</title>

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
            <a href="index.php" class="active">
                Permintaan Servis
            </a>
        </li>

        <li>
            <a href="../mekanik/index.php">
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

            <h1>Edit Permintaan Servis</h1>

            <p>
                Perbarui informasi dan status permintaan servis
            </p>

        </div>

    </div>


    <div class="content-card">


        <!-- INFORMASI PELANGGAN -->

        <div class="info-box">

            <p>
                <strong>Pelanggan:</strong>
                <?= htmlspecialchars($data['nama_pelanggan']); ?>
            </p>

            <p>
                <strong>Kendaraan:</strong>
                <?= htmlspecialchars($data['no_polisi']); ?>
                -
                <?= htmlspecialchars($data['merk']); ?>
                <?= htmlspecialchars($data['tipe']); ?>
            </p>

        </div>


        <!-- FORM -->

        <form method="POST">


            <div class="form-group">

                <label for="keluhan">
                    Keluhan
                </label>

                <textarea
                    name="keluhan"
                    id="keluhan"
                    class="form-control"
                    required
                ><?= htmlspecialchars($data['keluhan']); ?></textarea>

            </div>


            <div class="form-group">

                <label for="lokasi">
                    Lokasi Servis
                </label>

                <input
                    type="text"
                    name="lokasi"
                    id="lokasi"
                    class="form-control"
                    value="<?= htmlspecialchars($data['lokasi']); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="status">
                    Status Permintaan
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option
                        value="menunggu"
                        <?= $data['status'] == 'menunggu' ? 'selected' : ''; ?>
                    >
                        Menunggu
                    </option>

                    <option
                        value="diterima"
                        <?= $data['status'] == 'diterima' ? 'selected' : ''; ?>
                    >
                        Diterima
                    </option>

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