<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT
        kendaraan.*,
        pelanggan.nama AS nama_pelanggan
     FROM kendaraan
     INNER JOIN pelanggan
        ON kendaraan.pelanggan_id = pelanggan.id
     ORDER BY kendaraan.id DESC"
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

    <title>Kendaraan - Bengkel Keliling</title>

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
            <a href="index.php" class="active">
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


    <!-- PAGE HEADER -->

    <div class="page-header">

        <div>

            <h1>Kendaraan</h1>

            <p>
                Kelola data kendaraan pelanggan
            </p>

        </div>


        <a
            href="tambah.php"
            class="btn-primary"
        >
            + Tambah Kendaraan
        </a>

    </div>


    <!-- CONTENT CARD -->

    <div class="content-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Pemilik</th>
                        <th>No. Polisi</th>
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0):

                    while ($kendaraan = mysqli_fetch_assoc($query)):

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['nama_pelanggan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['no_polisi']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['merk']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['tipe']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($kendaraan['tahun']); ?>
                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="edit.php?id=<?= $kendaraan['id']; ?>"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <a
                                    href="hapus.php?id=<?= $kendaraan['id']; ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus kendaraan ini?')"
                                >
                                    Hapus
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php

                    endwhile;

                else:

                ?>

                    <tr>

                        <td
                            colspan="7"
                            class="empty-state"
                        >
                            Belum ada data kendaraan.
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