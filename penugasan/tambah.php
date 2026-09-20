<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


$permintaan = mysqli_query($koneksi, "
    SELECT
        ps.id,
        p.nama AS nama_pelanggan,
        k.no_polisi,
        k.merk,
        k.tipe,
        ps.keluhan,
        ps.lokasi
    FROM permintaan_servis ps
    JOIN pelanggan p ON ps.pelanggan_id = p.id
    JOIN kendaraan k ON ps.kendaraan_id = k.id
    WHERE ps.status IN ('diterima', 'menunggu')
    ORDER BY ps.id DESC
");


$mekanik = mysqli_query($koneksi, "
    SELECT *
    FROM mekanik
    WHERE status = 'tersedia'
    ORDER BY nama ASC
");


if (isset($_POST['simpan'])) {

    $permintaan_id = $_POST['permintaan_id'];
    $mekanik_id = $_POST['mekanik_id'];

    mysqli_query($koneksi, "
        INSERT INTO penugasan
        (permintaan_id, mekanik_id, tanggal_penugasan)
        VALUES
        ('$permintaan_id', '$mekanik_id', NOW())
    ");

    mysqli_query($koneksi, "
        UPDATE permintaan_servis
        SET status = 'ditugaskan'
        WHERE id = '$permintaan_id'
    ");

    mysqli_query($koneksi, "
        UPDATE mekanik
        SET status = 'sedang_servis'
        WHERE id = '$mekanik_id'
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

    <title>Tambah Penugasan - Bengkel Keliling</title>

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

            <h1>Tambah Penugasan</h1>

            <p>
                Tentukan mekanik untuk permintaan servis
            </p>

        </div>

    </div>


    <div class="content-card">

        <form method="POST">

            <div class="form-group">

                <label for="permintaan_id">
                    Permintaan Servis
                </label>

                <select
                    name="permintaan_id"
                    id="permintaan_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Permintaan Servis --
                    </option>

                    <?php while ($p = mysqli_fetch_assoc($permintaan)) { ?>

                        <option value="<?= $p['id']; ?>">

                            <?= htmlspecialchars($p['nama_pelanggan']); ?>
                            -
                            <?= htmlspecialchars($p['no_polisi']); ?>
                            -
                            <?= htmlspecialchars($p['keluhan']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <div class="form-group">

                <label for="mekanik_id">
                    Mekanik
                </label>

                <select
                    name="mekanik_id"
                    id="mekanik_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Mekanik --
                    </option>

                    <?php while ($m = mysqli_fetch_assoc($mekanik)) { ?>

                        <option value="<?= $m['id']; ?>">

                            <?= htmlspecialchars($m['nama']); ?>
                            -
                            <?= htmlspecialchars($m['no_hp']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn-primary"
                >
                    Simpan Penugasan
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