<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

include "../koneksi.php";


if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );

    $no_hp = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_hp']
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );


    $query = mysqli_query(
        $koneksi,
        "INSERT INTO mekanik
        (nama, no_hp, status)
        VALUES
        ('$nama', '$no_hp', '$status')"
    );


    if ($query) {

        header("Location: index.php");
        exit;

    } else {

        echo "Gagal menambahkan mekanik: "
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

    <title>Tambah Mekanik - Bengkel Keliling</title>

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

            <h1>Tambah Mekanik</h1>

            <p>
                Tambahkan mekanik baru ke sistem
            </p>

        </div>

    </div>


    <div class="content-card">

        <form method="POST">


            <div class="form-group">

                <label for="nama">
                    Nama Mekanik
                </label>

                <input
                    type="text"
                    name="nama"
                    id="nama"
                    class="form-control"
                    placeholder="Contoh: Andi"
                    required
                >

            </div>


            <div class="form-group">

                <label for="no_hp">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    id="no_hp"
                    class="form-control"
                    placeholder="Contoh: 081234567890"
                >

            </div>


            <div class="form-group">

                <label for="status">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option value="tersedia">
                        Tersedia
                    </option>

                    <option value="sedang_servis">
                        Sedang Servis
                    </option>

                    <option value="tidak_aktif">
                        Tidak Aktif
                    </option>

                </select>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    name="simpan"
                    class="btn-primary"
                >
                    Simpan Mekanik
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