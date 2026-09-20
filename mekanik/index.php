<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM mekanik ORDER BY id DESC"
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

    <title>Mekanik - Bengkel Keliling</title>

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
            <h1>Mekanik</h1>

            <p>
                Kelola data mekanik Bengkel Keliling
            </p>
        </div>

        <a
            href="tambah.php"
            class="btn-primary"
        >
            + Tambah Mekanik
        </a>

    </div>


    <div class="content-card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($query) > 0):

                    while ($mekanik = mysqli_fetch_assoc($query)):

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mekanik['nama']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mekanik['no_hp']); ?>
                        </td>

                        <td>

                            <span
                                class="status status-<?= htmlspecialchars($mekanik['status']); ?>"
                            >
                                <?= ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $mekanik['status']
                                    )
                                ); ?>
                            </span>

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="edit.php?id=<?= $mekanik['id']; ?>"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <a
                                    href="hapus.php?id=<?= $mekanik['id']; ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus mekanik ini?')"
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
                            colspan="5"
                            class="empty-state"
                        >
                            Belum ada data mekanik.
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