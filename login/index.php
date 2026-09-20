<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Bengkel Keliling</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>

<body class="login-page">

    <div class="login-container">

        <div class="login-card">

            <div class="text-center mb-4">

                <h2>Bengkel Keliling</h2>

                <p class="text-muted">
                    Layanan servis motor di lokasi Anda
                </p>

            </div>

            <?php if (isset($_GET['error'])): ?>

                <div class="alert alert-danger">
                    Username atau password salah.
                </div>

            <?php endif; ?>


            <form action="proses.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Masuk
                </button>

            </form>

        </div>

    </div>

</body>

</html>