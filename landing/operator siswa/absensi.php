<?php
require "../../koneksi.php";
require "../../functions/login_function.php";
require "../../functions/absensi_siswa_function.php";

// cek user apakah sudah login atau belum
if (!isLoggedIn()) {
  Header("Location: ../../login.php");
  exit();
}

// cek user apakah memiliki role yang benar
if (!hasRole("operator siswa")) {
  Header("Location: ../errorLevel.php");
  exit();
}

include("../../data/data_siswa.php");

$hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

$kehadiran = cekKehadiran($conn, $dataUser['id']);


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
  <script src="https://kit.fontawesome.com/64f5e4ae10.js" crossorigin="anonymous"></script>
  <title>halaman operator siswa</title>
</head>

<body>
  <div class="sidebar">
    <div class="head-sidebar">
      <div class="image-profile">
        <img src="../../image/profile.jpg" alt="image-profile">
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
        <a href="operator_siswa.php">Home</a>
      </div>
      <div class="menu" id="active">
        <a href="#">Absensi</a>
      </div>
      <div class="menu">
        <a href="mapel.php">Jadwal Pelajaran</a>
      </div>
      <div class="menu">
        <a href="absensi/data_absensi.php">Isi Absensi</a>
      </div>
      <div class="menu">
        <a href="agenda/agenda.php">Isi Agenda</a>
      </div>
    </div>
    <div class="footer-sidebar">
      <div class="menu-logout">
        <a href="../../logout.php?id=<?= $dataUser["id_operator"] ?>">Keluar</a>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="wrapper">
      <div class="text-date">
        <h1>Absensi</h1>
        <p><?= $hari[date("w")] ?>, <?= date("d") ?> <?= $bulan[date("n") - 1] ?> <?= date("Y") ?></p>
      </div>
      <div class="icon-field">
        <?php if ($kehadiran !== false) : ?>
          <i class="fas fa-frown icon sad"></i>
          <p>Anda <?= $kehadiran["kehadiran"] ?> hari ini</p>
        <?php else : ?>
          <i class="fas fa-smile icon"></i>
          <p>Anda berada di kelas</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>

</html>