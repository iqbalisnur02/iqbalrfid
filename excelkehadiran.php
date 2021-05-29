<?php


require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Presensi.xls");


$TANGGAL1      = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]);
$TANGGAL2      = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]);

$datakehadiran = query("SELECT * FROM tabel_kehadiran WHERE TANGGAL BETWEEN '$TANGGAL1' AND '$TANGGAL2' ORDER BY TANGGAL DESC");

?>

<!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>
    <center>
       <h3>DATA PRESENSI ANGGOTA</h3>
<div class="table-responsive-sm">
<table>
   <tr> 
       <th  rowspan="2">No.</th>
       <th  rowspan="2">No. Induk</th>
       <th  rowspan="2">Nama Anggota</th>
       <th  rowspan="2">Tanggal</th>
       <th  rowspan="2">Shift</th>
       <th  colspan="2">Jam Masuk</th>
       <th  colspan="2">Jam Pulang</th>
       <th  rowspan="2">Keterangan</th>
   </tr>
   <tr>
       <th >Check In</th>
       <th >Late In</th>
       <th >Check Out</th>
       <th >Early Out</th>
   </tr>
<?php 
    $i =1;
    foreach ($datakehadiran as $kehadiran) :
        $diff_tgl     = strtotime($kehadiran["TANGGAL"]);
        $tanggal      = date("d F Y", $diff_tgl);
        $late_in     = date("H:i:s", $kehadiran["LATE_IN"] - $det);
        $early_out   = date("H:i:s", $kehadiran["EARLY_OUT"] - $det);

    if ($kehadiran["STAT"] =="alfa"){
        $sql = "UPDATE tabel_kehadiran SET  CHECK_IN = '00:00:00', CHECK_OUT = '00:00:00', EARLY_OUT = 0, KET = 'ALFA' WHERE STAT = 'alfa'";
        $koneksi->query($sql); 
    }
    else if ($kehadiran["STAT"] =="bolos"){
        $sql = "UPDATE tabel_kehadiran SET CHECK_OUT = '00:00:00', KET = 'BOLOS' 
               WHERE STAT = 'bolos'";
        $koneksi->query($sql); 
     }
 ?>
   <tr>
   <td><?=$i;?></td>
   <td>'<?=$kehadiran["NO_INDUK"];?></td>
   <td><?=$kehadiran["NAMA"];?></td>
   <td><?= $tanggal;?></td>
   <td><?= $kehadiran["id_shift"];?></td>
   <td><?= $kehadiran["CHECK_IN"];?></td>
   <td><?= $late_in;?></td>
   <td><?= $kehadiran["CHECK_OUT"];?></td>
   <td><?= $early_out;?></td>
   <td><?= $kehadiran["KET"];?></td>
   </tr>
   <?php $i++; ?>
<?php endforeach; ?>

</table>
</div>
    </center>
 </body>
 </html>