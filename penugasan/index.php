<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT
        pt.id,
        p.nama AS nama_pelanggan,
        k.no_polisi,
        k.merk,
        k.tipe,
        m.nama AS nama_mekanik,
        ps.keluhan,
        ps.lokasi,
        pt.tanggal_penugasan,
        pt.status
    FROM penugasan pt
    JOIN permintaan_servis ps ON pt.permintaan_id = ps.id
    JOIN pelanggan p ON ps.pelanggan_id = p.id
    JOIN kendaraan k ON ps.kendaraan_id = k.id
    JOIN mekanik m ON pt.mekanik_id = m.id
    ORDER BY pt.id DESC
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

    <title>Penugasan Mekanik - Bengkel Keliling</title>

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
            <h1>Penugasan Mekanik</h1>

            <p>
                Kelola penugasan servis kepada mekanik
            </p>
        </div>

        <a
            href="tambah.php"
            class="btn-primary"
        >
            + Tambah Penugasan
        </a>

    </div>


    <div class="content-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Keluhan</th>
                        <th>Lokasi</th>
                        <th>Mekanik</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                            <?= htmlspecialchars($data['keluhan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['lokasi']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['nama_mekanik']); ?>
                        </td>

                        <td>

                            <span class="status status-<?= htmlspecialchars($data['status']); ?>">
                                <?= ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $data['status']
                                    )
                                ); ?>
                            </span>

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="edit.php?id=<?= $data['id']; ?>"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <?php if ($data['status'] == 'diproses'): ?>

                                    <a
                                        href="../servis/tambah.php"
                                        class="btn-finish"
                                    >
                                        Selesaikan
                                    </a>

                                <?php endif; ?>

                                <a
                                    href="hapus.php?id=<?= $data['id']; ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Hapus penugasan ini?')"
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
                            colspan="8"
                            class="empty-state"
                        >
                            Belum ada penugasan mekanik.
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