<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);


$kendaraan = mysqli_query($koneksi, "
    SELECT kendaraan.*, pelanggan.nama AS nama_pelanggan
    FROM kendaraan
    JOIN pelanggan ON kendaraan.pelanggan_id = pelanggan.id
    ORDER BY kendaraan.id DESC
");


if (isset($_POST['simpan'])) {

    $pelanggan_id = $_POST['pelanggan_id'];
    $kendaraan_id = $_POST['kendaraan_id'];
    $keluhan = $_POST['keluhan'];
    $lokasi = $_POST['lokasi'];

    mysqli_query($koneksi, "
        INSERT INTO permintaan_servis
        (pelanggan_id, kendaraan_id, keluhan, lokasi)
        VALUES
        ('$pelanggan_id', '$kendaraan_id', '$keluhan', '$lokasi')
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

    <title>Tambah Permintaan Servis - Bengkel Keliling</title>

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

            <h1>Tambah Permintaan Servis</h1>

            <p>
                Masukkan data permintaan servis pelanggan
            </p>

        </div>

    </div>


    <div class="content-card">

        <form method="POST">


            <!-- PELANGGAN -->

            <div class="form-group">

                <label for="pelanggan_id">
                    Pelanggan
                </label>

                <select
                    name="pelanggan_id"
                    id="pelanggan_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Pelanggan --
                    </option>

                    <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

                        <option value="<?= $p['id']; ?>">

                            <?= htmlspecialchars($p['nama']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <!-- KENDARAAN -->

            <div class="form-group">

                <label for="kendaraan_id">
                    Kendaraan
                </label>

                <select
                    name="kendaraan_id"
                    id="kendaraan_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Kendaraan --
                    </option>

                    <?php while ($k = mysqli_fetch_assoc($kendaraan)) { ?>

                        <option value="<?= $k['id']; ?>">

                            <?= htmlspecialchars($k['no_polisi']); ?>
                            -
                            <?= htmlspecialchars($k['merk']); ?>
                            <?= htmlspecialchars($k['tipe']); ?>
                            (<?= htmlspecialchars($k['nama_pelanggan']); ?>)

                        </option>

                    <?php } ?>

                </select>

            </div>


            <!-- KELUHAN -->

            <div class="form-group">

                <label for="keluhan">
                    Keluhan
                </label>

                <textarea
                    name="keluhan"
                    id="keluhan"
                    class="form-control"
                    placeholder="Contoh: Motor tiba-tiba mati dan tidak bisa dinyalakan."
                    required
                ></textarea>

            </div>


            <!-- LOKASI -->

            <div class="form-group">

                <label for="lokasi">
                    Lokasi Servis
                </label>

                <input
                    type="text"
                    name="lokasi"
                    id="lokasi"
                    class="form-control"
                    placeholder="Contoh: Jl. Raya Pringsewu No. 10"
                    required
                >

            </div>


            <!-- BUTTON -->

            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn-primary"
                >
                    Simpan Permintaan
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