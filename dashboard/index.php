<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


/* =========================
   JUMLAH DATA
========================= */

$query_pelanggan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM pelanggan"
);

$total_pelanggan = mysqli_fetch_assoc($query_pelanggan)['total'];


$query_kendaraan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM kendaraan"
);

$total_kendaraan = mysqli_fetch_assoc($query_kendaraan)['total'];


$query_menunggu = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM permintaan_servis
     WHERE status = 'menunggu'"
);

$total_menunggu = mysqli_fetch_assoc($query_menunggu)['total'];


$query_selesai = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM permintaan_servis
     WHERE status = 'selesai'"
);

$total_selesai = mysqli_fetch_assoc($query_selesai)['total'];


/* =========================
   PERMINTAAN SERVIS TERBARU
========================= */

$query_permintaan = mysqli_query(
    $koneksi,
    "SELECT
        ps.id,
        pelanggan.nama AS nama_pelanggan,
        kendaraan.no_polisi,
        ps.keluhan,
        ps.status,
        ps.tanggal_permintaan
     FROM permintaan_servis ps
     INNER JOIN pelanggan
        ON ps.pelanggan_id = pelanggan.id
     INNER JOIN kendaraan
        ON ps.kendaraan_id = kendaraan.id
     ORDER BY ps.id DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - Bengkel Keliling</title>

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
            <a href="index.php" class="active">
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



<!-- MAIN CONTENT -->

<main class="main-content">


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>Dashboard</h1>

            <p>
                Ringkasan aktivitas Bengkel Keliling
            </p>

        </div>


        <div class="admin-info">

            <strong>
                <?= htmlspecialchars($_SESSION['username']); ?>
            </strong>

            <span>
                Administrator
            </span>

        </div>

    </div>



    <!-- STATISTIK -->

    <div class="stat-grid">


        <div class="stat-card">

            <p>Total Pelanggan</p>

            <h2>
                <?= $total_pelanggan; ?>
            </h2>

        </div>


        <div class="stat-card">

            <p>Total Kendaraan</p>

            <h2>
                <?= $total_kendaraan; ?>
            </h2>

        </div>


        <div class="stat-card">

            <p>Permintaan Menunggu</p>

            <h2>
                <?= $total_menunggu; ?>
            </h2>

        </div>


        <div class="stat-card">

            <p>Servis Selesai</p>

            <h2>
                <?= $total_selesai; ?>
            </h2>

        </div>


    </div>



    <!-- PERMINTAAN TERBARU -->

    <div class="content-card">

        <div class="card-header">

            <div>

                <h3>Permintaan Servis Terbaru</h3>

                <p>
                    Daftar permintaan servis yang baru masuk
                </p>

            </div>

            <a
                href="../permintaan/index.php"
                class="btn-primary"
            >
                Lihat Semua
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Pelanggan</th>

                        <th>Kendaraan</th>

                        <th>Keluhan</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query_permintaan) > 0):

                    while ($permintaan = mysqli_fetch_assoc($query_permintaan)):

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($permintaan['nama_pelanggan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($permintaan['no_polisi']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($permintaan['keluhan']); ?>
                        </td>

                        <td>

                            <span class="status status-<?= htmlspecialchars($permintaan['status']); ?>">

                                <?= ucfirst(str_replace('_', ' ', $permintaan['status'])); ?>

                            </span>

                        </td>

                    </tr>

                <?php

                    endwhile;

                else:

                ?>

                    <tr>

                        <td colspan="5" style="text-align:center;">

                            Belum ada permintaan servis.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>


</main>


</body>

</html>