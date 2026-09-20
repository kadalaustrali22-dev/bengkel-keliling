<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT
        s.id,
        p.nama AS nama_pelanggan,
        k.no_polisi,
        k.merk,
        k.tipe,
        m.nama AS nama_mekanik,
        s.tindakan,
        s.sparepart,
        s.biaya,
        s.tanggal_servis
    FROM servis s
    JOIN penugasan pt ON s.penugasan_id = pt.id
    JOIN permintaan_servis ps ON pt.permintaan_id = ps.id
    JOIN pelanggan p ON ps.pelanggan_id = p.id
    JOIN kendaraan k ON ps.kendaraan_id = k.id
    JOIN mekanik m ON pt.mekanik_id = m.id
    ORDER BY s.id DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Servis - Bengkel Keliling</title>

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
            <a href="../penugasan/index.php">
                Penugasan
            </a>
        </li>

        <li>
            <a href="index.php" class="active">
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

            <h1>Riwayat Servis</h1>

            <p>
                Daftar servis yang telah selesai
            </p>

        </div>

    </div>


    <div class="content-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Mekanik</th>
                        <th>Tindakan</th>
                        <th>Sparepart</th>
                        <th>Biaya</th>
                        <th>Tanggal</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0):

                    while ($data = mysqli_fetch_assoc($query)):

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['nama_pelanggan']); ?>
                        </td>

                        <td>

                            <div class="vehicle-info">

                                <strong>
                                    <?= htmlspecialchars($data['no_polisi']); ?>
                                </strong>

                                <br>

                                <small>
                                    <?= htmlspecialchars($data['merk']); ?>
                                    <?= htmlspecialchars($data['tipe']); ?>
                                </small>

                            </div>

                        </td>

                        <td>
                            <?= htmlspecialchars($data['nama_mekanik']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['tindakan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['sparepart'] ?? '-'); ?>
                        </td>

                        <td>

                            <strong>
                                Rp <?= number_format(
                                    $data['biaya'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </strong>

                        </td>

                        <td>

                            <?= date(
                                'd-m-Y H:i',
                                strtotime($data['tanggal_servis'])
                            ); ?>

                        </td>

                    </tr>

                <?php

                    endwhile;

                else:

                ?>

                    <tr>

                        <td
                            colspan="8"
                            class="empty-state"
                        >
                            Belum ada riwayat servis.
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