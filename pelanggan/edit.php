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


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan WHERE id = $id"
);


$pelanggan = mysqli_fetch_assoc($query);


if (!$pelanggan) {
    header("Location: index.php");
    exit;
}


if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );

    $no_hp = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_hp']
    );

    $alamat = mysqli_real_escape_string(
        $koneksi,
        $_POST['alamat']
    );


    mysqli_query(
        $koneksi,
        "UPDATE pelanggan SET
            nama = '$nama',
            no_hp = '$no_hp',
            alamat = '$alamat'
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

    <title>Edit Pelanggan</title>

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
        .form-group textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-family: Arial, sans-serif;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
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
            <a href="index.php" class="active">
                Pelanggan
            </a>
        </li>

        <li>
            <a href="../kendaraan/index.php">
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

            <h1>Edit Pelanggan</h1>

            <p>
                Perbarui data pelanggan
            </p>

        </div>

    </div>



    <div class="content-card form-card">


        <form method="POST">


            <div class="form-group">

                <label>
                    Nama Pelanggan
                </label>

                <input
                    type="text"
                    name="nama"
                    value="<?= htmlspecialchars($pelanggan['nama']); ?>"
                    required
                >

            </div>



            <div class="form-group">

                <label>
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="<?= htmlspecialchars($pelanggan['no_hp']); ?>"
                >

            </div>



            <div class="form-group">

                <label>
                    Alamat
                </label>

                <textarea
                    name="alamat"
                ><?= htmlspecialchars($pelanggan['alamat']); ?></textarea>

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