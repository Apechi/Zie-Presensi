<?php
require "../../functions/functions.php"; // !memanggil file functions.php
require "../../functions/function_data_absensi.php"; // !memanggil file functions_data_absensi.php

checkSession("login_operator siswa"); // !menjalankan fungi untuk mengecek session

$dataUser = ""; // !membuat variabel untuk menyimpan data user

if (getDataFromCookie() !== false) { // !mengecek apakah function getDataFromCookie tidak sama dengan false
    $dataUser = getDataFromCookie(); // !menyimpan data yang dikembalikan ke dalam variabel dataUser
} else { // !ketika function getDataFromCookie mengembalikan false
    $dataUser = getDataFromSession();
}

$kodeKelas = strtolower($dataUser["kode"]);

$dataAbsensi = getDataAbsensi("SELECT * FROM absensi WHERE kelas = '$kodeKelas'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/base.css">
    <link rel="stylesheet" href="../../css/sidebar.css">
    <link rel="stylesheet" href="../../css/data_absensi.css">
    <title>halaman operator siswa</title>
</head>

<body>
    <div class="sidebar">
        <div class="head-sidebar">
            <div class="image-profile">
                <img src="../../image/profile.jpg" alt="image-profile">
            </div>
            <div class="name-profile">
                <h2><?= $dataUser["nama"] ?></h2>
            </div>
            <div class="class-profile">
                <p><?= $dataUser["level"] ?></p>
            </div>
        </div>
        <div class="body-sidebar">
            <div class="menu">
                <a href="operator_siswa.php">Home</a>
            </div>
            <div class="menu">
                <a href="absensi.php">Absensi</a>
            </div>
            <div class="menu">
                <a href="mapel.php">Jadwal Pelajaran</a>
            </div>
            <div class="menu" id="active">
                <a href="#">Data Absensi</a>
            </div>
        </div>
        <div class="footer-sidebar">
            <div class="menu-logout">
                <a href="../../logout.php">Keluar</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <h1>Data Absensi</h1>
            <form action="" method="post">
                <input type="text" name="search" id="keyword" placeholder="Cari data absensi">
                <button name="cari" type="submit" id="button-cari">Cari</button>

            </form>
            <div class="data-field" data-kelas="<?= $dataUser["kode"] ?>">
                <table border="1" cellspacing="0">
                    <thead>
                        <th>No</th>
                        <th>No Absen</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($dataAbsensi as $data) : ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $data["no_absen"] ?></td>
                                <td><?= $data["nama"] ?></td>
                                <td><?= $data["tanggal"] ?></td>
                                <td><?= $data["status"] ?></td>
                                <td><?= $data["keterangan"] ?></td>
                                <td>
                                    <a href="edit_absensi.php">Edit</a> | <a href="hapus_absensi.php" onclick="return confirm('Apakah anda yakin ingin mengahpusnya?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../js/script.js"></script>
</body>

</html>