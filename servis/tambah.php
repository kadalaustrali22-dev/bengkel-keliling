<?php
include "../koneksi.php";

$penugasan = mysqli_query($koneksi, "
    SELECT
        pt.id,
        p.nama AS nama_pelanggan,
        k.no_polisi,
        k.merk,
        k.tipe,
        m.nama AS nama_mekanik,
        ps.keluhan,
        ps.lokasi
    FROM penugasan pt
    JOIN permintaan_servis ps ON pt.permintaan_id = ps.id
    JOIN pelanggan p ON ps.pelanggan_id = p.id
    JOIN kendaraan k ON ps.kendaraan_id = k.id
    JOIN mekanik m ON pt.mekanik_id = m.id
    WHERE pt.status = 'diproses'
    ORDER BY pt.id DESC
");

if (isset($_POST['simpan'])) {

    $penugasan_id = $_POST['penugasan_id'];
    $tindakan = $_POST['tindakan'];
    $sparepart = $_POST['sparepart'];
    $biaya = $_POST['biaya'];

    mysqli_query($koneksi, "
        INSERT INTO servis
        (penugasan_id, tindakan, sparepart, biaya)
        VALUES
        ('$penugasan_id', '$tindakan', '$sparepart', '$biaya')
    ");

    mysqli_query($koneksi, "
        UPDATE penugasan
        SET status = 'selesai'
        WHERE id = '$penugasan_id'
    ");

    $data_penugasan = mysqli_fetch_assoc(mysqli_query($koneksi, "
        SELECT mekanik_id, permintaan_id
        FROM penugasan
        WHERE id = '$penugasan_id'
    "));

    mysqli_query($koneksi, "
        UPDATE mekanik
        SET status = 'tersedia'
        WHERE id = '{$data_penugasan['mekanik_id']}'
    ");

    mysqli_query($koneksi, "
        UPDATE permintaan_servis
        SET status = 'selesai'
        WHERE id = '{$data_penugasan['permintaan_id']}'
    ");

    header("Location: ../riwayat/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Selesaikan Servis - Bengkel Keliling</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">

</head>

<body>

<div class="dashboard-container">

    <aside class="sidebar">

        <h2>Bengkel Keliling</h2>

        <nav>

            <a href="../dashboard/">Dashboard</a>
            <a href="../pelanggan/">Pelanggan</a>
            <a href="../kendaraan/">Kendaraan</a>
            <a href="../permintaan/">Permintaan Servis</a>
            <a href="../mekanik/">Mekanik</a>
            <a href="../penugasan/" class="active">Penugasan</a>
            <a href="../riwayat/">Riwayat Servis</a>
            <a href="../login/logout.php">Logout</a>

        </nav>

    </aside>

    <main class="main-content">

        <div class="page-header">

            <div>
                <h1>Selesaikan Servis</h1>
                <p>Catat hasil pekerjaan mekanik.</p>
            </div>

        </div>

        <div class="content-card">

            <form method="POST">

                <div class="form-group">

                    <label for="penugasan_id">Penugasan</label>

                    <select
                        name="penugasan_id"
                        id="penugasan_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            -- Pilih Penugasan --
                        </option>

                        <?php while ($p = mysqli_fetch_assoc($penugasan)) { ?>

                            <option value="<?= $p['id']; ?>">

                                <?= htmlspecialchars($p['nama_pelanggan']); ?>
                                -
                                <?= htmlspecialchars($p['no_polisi']); ?>
                                -
                                <?= htmlspecialchars($p['nama_mekanik']); ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="tindakan">Tindakan Servis</label>

                    <textarea
                        name="tindakan"
                        id="tindakan"
                        class="form-control"
                        placeholder="Contoh: Mengganti busi dan membersihkan karburator."
                        required
                    ></textarea>

                </div>

                <div class="form-group">

                    <label for="sparepart">Sparepart</label>

                    <input
                        type="text"
                        name="sparepart"
                        id="sparepart"
                        class="form-control"
                        placeholder="Contoh: Busi NGK"
                    >

                </div>

                <div class="form-group">

                    <label for="biaya">Biaya</label>

                    <input
                        type="number"
                        name="biaya"
                        id="biaya"
                        class="form-control"
                        min="0"
                        placeholder="Contoh: 50000"
                        required
                    >

                </div>

                <div class="action-buttons">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn-primary"
                    >
                        Selesaikan Servis
                    </button>

                    <a
                        href="../penugasan/"
                        class="btn-secondary"
                    >
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>