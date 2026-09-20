<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


/* AMBIL DATA PELANGGAN */

$query_pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);


/* SIMPAN DATA */

if (isset($_POST['simpan'])) {

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


    $query = mysqli_query(
        $koneksi,
        "INSERT INTO kendaraan
        (pelanggan_id, no_polisi, merk, tipe, tahun)
        VALUES
        ($pelanggan_id, '$no_polisi', '$merk', '$tipe', $tahun)"
    );


    if ($query) {

        header("Location: index.php");
        exit;

    } else {

        echo "Gagal menambahkan kendaraan: "
            . mysqli_error($koneksi);

    }

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

    <title>Tambah Kendaraan</title>

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

        .btn-simpan {
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

            <h1>Tambah Kendaraan</h1>

            <p>
                Tambahkan kendaraan pelanggan
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

                    <option value="">
                        -- Pilih Pelanggan --
                    </option>

                    <?php while ($pelanggan = mysqli_fetch_assoc($query_pelanggan)): ?>

                        <option value="<?= $pelanggan['id']; ?>">

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
                    placeholder="Contoh: BE 1234 AB"
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
                    placeholder="Contoh: Honda"
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
                    placeholder="Contoh: Beat"
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
                    min="1900"
                    max="2100"
                    placeholder="Contoh: 2022"
                    required
                >

            </div>



            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan"
                >
                    Simpan
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