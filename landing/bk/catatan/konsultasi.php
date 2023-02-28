<?php
require "../../../koneksi.php";
require "../../../functions/login_function.php";
require "../../../functions/konsultasi_function.php";

// cek user apakah sudah login atau belum
if (!isLoggedIn()) {
    Header("Location: ../../../login.php");
    exit();
}

// cek user apakah memiliki role yang benar
if (!hasRole("bk")) {
    Header("Location: ../../errorLevel.php");
    exit();
}

include("../../../data/data_guru.php");

$dataKonsul = getDataForm($conn, "SELECT konsultasi.id, konsultasi.tanggal, konsultasi.status, siswa.nama FROM konsultasi JOIN siswa ON siswa.id = konsultasi.id_siswa");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/base.css">
    <link rel="stylesheet" href="../../../css/sidebar.css">
    <link rel="stylesheet" href="../../../css/konsultasi.css">
    <script src="https://kit.fontawesome.com/64f5e4ae10.js" crossorigin="anonymous"></script>
    <title>halaman wali kelas</title>
</head>

<body>
    <div class="sidebar">
        <div class="head-sidebar">
            <div class="image-profile">
                <img src="../../../image/profile.jpg" alt="image-profile">
                <div class="text-foto">
                    <span>Edit Foto</span>
                </div>
            </div>
            <div class="name-profile">
                <h2><?= ucwords($dataUser["username"]) ?></h2>
            </div>
            <div class="class-profile">
                <p><?= ucwords($dataUser["role"]) ?></p>
            </div>
        </div>
        <div class="body-sidebar">
            <div class="menu">
                <a href="../bk.php">Home</a>
            </div>
            <div class="menu">
                <a href="../absensi.php">Absensi</a>
            </div>
            <div class="menu" id="active">
                <a href="#">Konsultasi Siswa</a>
            </div>
            <div class="menu">
                <a href="../editData/editData.php?id=<?= $dataUser["id"] ?>">Edit Data</a>
            </div>
        </div>
        <div class="footer-sidebar">
            <div class="menu-logout">
                <a href="../../../logout.php?id=<?= $dataUser["id_operator"] ?>">Keluar</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <h1>Catatan Konsultasi Siswa</h1>
            <div class="filter-field">
                <a href="tambahCatatan.php" class="tambah">Tambah Catatan</a>
            </div>
            <div class="catatan">
                <?php foreach ($dataKonsul as $data) : ?>
                    <div class="row <?php if ($data["status"] == 'diproses') {
                                        echo "diproses";
                                    } else {
                                        echo "selesai";
                                    } ?>">
                        <h3><?= ucwords($data["nama"]) ?></h3>
                        <p><?= $data["tanggal"] ?></p>
                        <a href="detailCatatan.php?id=<?= $data["id"] ?>" class="detail"><i class="fa-sharp fa-solid fa-arrow-right"></i></a>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </div>

</body>

</html>