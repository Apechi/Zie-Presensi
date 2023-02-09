<?php
require "../../../functions/functions.php"; // !memanggil file functions.php
require "../../../functions/function_data_absensi.php"; // !memanggil file functions_data_absensi.php

checkSession("login_wali kelas"); // !menjalankan fungi untuk mengecek session

$dataUser = ""; // !membuat variabel untuk menyimpan data user

if (getDataFromCookie() !== false) { // !mengecek apakah function getDataFromCookie tidak sama dengan false
    $dataUser = getDataFromCookie(); // !menyimpan data yang dikembalikan ke dalam variabel dataUser
} else { // !ketika function getDataFromCookie mengembalikan false
    $dataUser = getDataFromSession();
}

$kodeKelas = strtolower($dataUser["kelas"]);

$dataAbsensi = getDataAbsensi("SELECT * FROM absensi WHERE kelas = '$kodeKelas'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/base.css">
    <link rel="stylesheet" href="../../../css/sidebar.css">
    <link rel="stylesheet" href="../../../css/data_absensi.css">
    <script src="https://kit.fontawesome.com/64f5e4ae10.js" crossorigin="anonymous"></script>
    <script src="../../../js/upload.js"></script>
    <script src="../../../js/jquery-3.6.3.min.js"></script>
    <script src="../../../js/script.js"></script>
    <title>halaman wali kelas</title>
</head>

<body>
    <div class="sidebar">
        <div class="head-sidebar">
            <div class="image-profile">
                <img <?php if (strlen($dataUser["foto"]) > 0) {
                            echo "src='../../../image/$dataUser[foto]'";
                        } else {
                            echo "src='../../../image/profile.jpg'";
                        } ?> alt="image-profile">
                <div class="text-foto">
                    <span>Edit Foto</span>
                </div>
            </div>
            <div class="name-profile">
                <h2><?= ucwords($dataUser["nama"]) ?></h2>
            </div>
            <div class="class-profile">
                <p><?= ucwords($dataUser["level"]) ?></p>
            </div>
        </div>
        <div class="body-sidebar">
            <div class="menu">
                <a href="../wali_kelas.php">Home</a>
            </div>
            <div class="menu">
                <a href="../absensi.php">Absensi</a>
            </div>
            <div class="menu">
                <a href="../mapel.php">Jadwal Pelajaran</a>
            </div>
            <div class="menu" id="active">
                <a href="#">Absensi Kelas</a>
            </div>
            <div class="menu">
                <a href="../agenda/data_agenda.php">Agenda Kelas</a>
            </div>
        </div>
        <div class="footer-sidebar">
            <div class="menu-logout">
                <a href="../../../logout.php?id=<?= $dataUser["id"] ?>">Keluar</a>
            </div>
        </div>
    </div>

    <div class="wrapper-popup">
        <div class="popup">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="image">
                    <i class="fa-solid fa-upload"></i>
                    <span>Upload Image</span>
                </label>
                <input type="file" name="image" id="image" onchange="this.form.submit()">
            </form>
            <i class="fa-solid fa-xmark close-popup"></i>
        </div>
    </div>


    <div class="container">
        <div class="wrapper">
            <h1>Data Absensi <?= strtoupper($dataUser["kelas"]) ?></h1>
            <form action="" method="post">
                <input type="text" name="search" id="keyword" placeholder="Cari data absensi">
                <a href="tambah_data_absensi.php">Tambah Data</a>
            </form>
            <div class="data-field" data-kelas="<?= $dataUser["kelas"] ?>">
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
                                <td><?= ucwords($data["nama"]) ?></td>
                                <td><?= $data["tanggal"] ?></td>
                                <td class="status" <?php
                                                    switch ($data["status"]) {
                                                        case "hadir":
                                                            echo "style='background: #54B435;'";
                                                            break;
                                                        case "izin":
                                                            echo "style='background: #4B56D2;'";
                                                            break;
                                                        case "sakit":
                                                            echo "style='background: #FF1E1E;'";
                                                            break;
                                                        default:
                                                            echo "style='background: #2C3333;'";
                                                    }
                                                    ?>><?= ucwords($data["status"]) ?></td>
                                <td><?= ucfirst($data["keterangan"]) ?></td>
                                <td>
                                    <a href="edit_absensi.php?id=<?= $data['id'] ?>">Edit</a> | <a href="hapus_absensi.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapusnya?')">Hapus</a>
                                </td>
                            </tr>
                            <?php $no++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    if (isset($_FILES["image"])) {
        if (uploadImage($dataUser["nama"], "../../../image/$dataUser[foto]", "../../../image/") > 0) {
            echo "<script>
        alert ('Foto profile berhasil diedit!');
        document.location.href = './data_absensi.php';
        </script>";
        }
    }

    ?>

</body>

</html>