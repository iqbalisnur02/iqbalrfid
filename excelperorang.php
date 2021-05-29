<?php

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}



header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Presensi Individu.xls");

if(isset($_GET["TANGGAL1"]) AND isset($_GET["TANGGAL2"])){
  $TANGGAL1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]);
  $TANGGAL2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]);
}
else{
  $TANGGAL1  = date("Y-m-d");
  $TANGGAL2  = date("Y-m-d");
}

$ID        = mysqli_escape_string($koneksi, $_GET["ID"]);
$NAMA      = mysqli_escape_string($koneksi, $_GET["NAMA"]);
$ID_CHAT   = mysqli_escape_string($koneksi, $_GET["ID_CHAT"]);

$data = query("SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND TANGGAL BETWEEN '$TANGGAL1' AND '$TANGGAL2' ORDER BY no DESC");

?>

<!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>
   <center>
  <h3>REKAMAN PRESENSI</h3>
  <p>Nama : <?=$NAMA;?> || ID   : <?=$ID;?></p>
  
    <table>
      <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">Shift</th>
        <th colspan="2">Jam Masuk</th>
        <th colspan="2">Jam Pulang</th>
        <th rowspan="2">Keterangan</th>
      </tr>
      <tr>
        <th>Check In</th>
        <th>Late In</th>
        <th>Check Out</th>
        <th>Early Out</th>
      </tr>
  <?php
    $i = 1;
    foreach ($data as $kehadiran) :
      $diff_tgl    = strtotime($kehadiran["TANGGAL"]);
      $tanggal     = date("d F Y", $diff_tgl);
      $late_in     = date("H:i:s", $kehadiran["LATE_IN"] - $det);
      $early_out   = date("H:i:s", $kehadiran["EARLY_OUT"] - $det);
  ?>
      <tr>
        <td><?=$i;?></td>
        <td><?=$tanggal;?></td>
        <td><?=$kehadiran["id_shift"];?></td>
        <td><?=$kehadiran["CHECK_IN"];?></td>
        <td><?=$late_in;?></td>
        <td><?=$kehadiran["CHECK_OUT"];?></td>
        <td><?=$early_out;?></td>
        <td><?=$kehadiran["KET"];?></td>
      </tr>
  <?php 
      $i++;
      endforeach; ?>
    </table>

 </center>
 </body>
 </html>