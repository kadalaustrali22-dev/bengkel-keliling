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


/* DATA KENDARAAN */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM kendaraan WHERE id = $id"
);

$kendaraan = mysqli_fetch_assoc($query);


if (!$kendaraan) {
    header("Location: index.php");
    exit;
}


/* DATA PELANGGAN */

$query_pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);


/* UPDATE */

if (isset($_POST['update'])) {

    $pelanggan_id = (int) $_POST['pelanggan_id'];

    $no_polisi = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_polisi']
    );

    $merk = mysqli_real_escape_string(
        $koneksi,
        $_POST['merk']
    );

    $tipe = mysqli_real_escape_string(
        $koneksi,
        $_POST['tipe']
    );

    $tahun = (int) $_POST['tahun'];


    mysqli_query(
        $koneksi,
        "UPDATE kendaraan SET
            pelanggan_id = $pelanggan_id,
            no_polisi = '$no_polisi',
            merk = '$merk',
            tipe = '$tipe',
            tahun = $tahun
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

    <title>Edit Kendaraan</title>

    <link
        rel="stylesheet"
        href="../assets/css/dashboard.css"
    >

    <style>

        .form-card {
            max-width: 700px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            background: white;
        }

        .form-actions {
            display: flex;
            gap: 10px;
        }

        .btn-update {
            border: none;
            padding: 11px 18px;
            background: #2563eb;
            color: white;
            border-radius: 7px;
            cursor: pointer;
        }

        .btn-kembali {
            padding: 11px 18px;
            background: #e5e7eb;
            color: #172033;
            text-decoration: none;
            border-radius: 7px;
        }

    </style>

</head>


<body>


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
            <a href="../booking/index.php">
                Booking
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



<main class="main-content">


    <div class="page-header">

        <div>

            <h1>Edit Kendaraan</h1>

            <p>
                Perbarui data kendaraan
            </p>

        </div>

    </div>



    <div class="content-card form-card">


        <form method="POST">


            <div class="form-group">

                <label>
                    Pemilik Kendaraan
                </label>

                <select
                    name="pelanggan_id"
                    required
                >

                    <?php while ($pelanggan = mysqli_fetch_assoc($query_pelanggan)): ?>

                        <option
                            value="<?= $pelanggan['id']; ?>"
                            <?= $pelanggan['id'] == $kendaraan['pelanggan_id'] ? 'selected' : ''; ?>
                        >

                            <?= htmlspecialchars($pelanggan['nama']); ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>



            <div class="form-group">

                <label>
                    Nomor Polisi
                </label>

                <input
                    type="text"
                    name="no_polisi"
                    value="<?= htmlspecialchars($kendaraan['no_polisi']); ?>"
                    required
                >

            </div>



            <div class="form-group">

                <label>
                    Merk
                </label>

                <input
                    type="text"
                    name="merk"
                    value="<?= htmlspecialchars($kendaraan['merk']); ?>"
                    required
                >

            </div>



            <div class="form-group">

                <label>
                    Tipe
                </label>

                <input
                    type="text"
                    name="tipe"
                    value="<?= htmlspecialchars($kendaraan['tipe']); ?>"
                    required
                >

            </div>



            <div class="form-group">

                <label>
                    Tahun
                </label>

                <input
                    type="number"
                    name="tahun"
                    value="<?= htmlspecialchars($kendaraan['tahun']); ?>"
                    min="1900"
                    max="2100"
                    required
                >

            </div>



            <div class="form-actions">

                <button
                    type="submit"
                    name="update"
                    class="btn-update"
                >
                    Update
                </button>


                <a
                    href="index.php"
                    class="btn-kembali"
                >
                    Kembali
                </a>

            </div>


        </form>


    </div>


</main>


</body>

</html>