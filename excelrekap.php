<?php

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekapitulasi Presensi.xls");

if(isset($_GET["bulan"]) AND isset($_GET["tahun"])){
   $bln = mysqli_escape_string($_GET["bulan"]);
   $thn = mysqli_escape_string($_GET["tahun"]);
}
else{
   $bln = date("m"); //bulan saat ini
   $thn = date("Y"); //tahun saat ini
}

$tgl_1 = $thn."-".$bln."-01";
$tgl_2 = $thn."-".$bln."-31";

switch ($bln) {
  case '01': $month = "Januari";  break;   case '07': $month = "Juli";      break;
  case '02': $month = "Februari"; break;   case '08': $month = "Agustus";   break;
  case '03': $month = "Maret";    break;   case '09': $month = "September"; break;
  case '04': $month = "April";    break;   case '10': $month = "Oktober";   break;
  case '05': $month = "Mei";      break;   case '11': $month = "November";  break;
  case '06': $month = "Juni";     break;   case '12': $month = "Desember";  break;
}

$dataanggota = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <center>
    <h3>REKAPITULASI PRESENSI BULANAN</h3>
  
<p style="font-weight: bold">Periode: <?=$month." ".$thn; ?></p>

<div class="table-responsive-sm mx-5">
<table>
   <tr> 
   <th>No.</th>
   <th>No. Induk</th>
   <th>Nama Anggota</th>
   <th>H</th> 
   <th>S</th>
   <th>I</th>
   <th>A</th>
   <th>B</th>
   <th>L</th>
   <th>T</th>
   <th>P</th>
   <th>Late In</th>
   <th>Early Out</th>
   </tr>
<?php $i =1;?>

<?php 

foreach ($dataanggota as $anggota) :
     $ID = $anggota["ID"];
   
          
          //Menghitung jumlah ALFA
          $query =  "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'ALFA' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result   = mysqli_query($koneksi, $query);
          $alfa     = mysqli_num_rows($result);

          //menghitung jumlah SAKIT
          $query2 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'SAKIT' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result2   = mysqli_query($koneksi, $query2);
          $sakit     = mysqli_num_rows($result2);

          //menghitung jumlah IZIN
          $query3 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'IZIN' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result3   = mysqli_query($koneksi, $query3);
          $izin      = mysqli_num_rows($result3);

          //menghitung jumlah BOLOS
          $query4 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'BOLOS' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result4   = mysqli_query($koneksi, $query4);
          $bolos     = mysqli_num_rows($result4);

          //menghitung jumlah LUPA
          $query5 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'LUPA' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result5   = mysqli_query($koneksi, $query5);
          $lupa     = mysqli_num_rows($result5);

          //Menghitung jumlah HADIR
          $query6 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'HADIR' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result6   = mysqli_query($koneksi, $query6);
          $hadir     = mysqli_num_rows($result6);

          //Menghitung jumlah TERLAMBAT
          $query7      = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result7     = mysqli_query($koneksi, $query7);
          $terlambat   = mysqli_num_rows($result7);

          //Menghitung jumlah PULANG CEPAT
          $query8      = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND EARLY_OUT != 0 AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result8     = mysqli_query($koneksi, $query8);
          $plg_cepat   = mysqli_num_rows($result8);

          //Menghitung jumlah JAM TERLAMBAT
          $query9      = "SELECT SUM(LATE_IN) AS 'sum_late' FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND CHECK_IN != '00:00:00' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2' ";
          $result9     = mysqli_query($koneksi, $query9);
          $late_in     = mysqli_fetch_array($result9);
          $f_late_in   = date("H:i:s", $late_in["sum_late"] - $det);

          //Menghitung jumlah JAM PULANG CEPAT
          $query10      = "SELECT SUM(EARLY_OUT) AS 'sum_early' FROM tabel_kehadiran WHERE ID = '$ID' AND EARLY_OUT != 0 AND CHECK_OUT != '00:00:00' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result10     = mysqli_query($koneksi, $query10);
          $early_out    = mysqli_fetch_array($result10);
          $f_early_out   = date("H:i:s", $early_out["sum_early"] - $det);


 ?>


   <tr>
   <td><?= $i; ?></td>
   <td>'<?= $anggota["NO_INDUK"];?></td>
   <td><?= $anggota["NAMA"];?></td>
   <td><?= $hadir?></td>
   <td><?= $sakit;?></td>
   <td><?= $izin;?></td>
   <td><?= $alfa;?></td>
   <td><?= $bolos;?></td>
   <td><?= $lupa;?></td>
   <td><?= $terlambat;?></td>
   <td><?= $plg_cepat;?></td>
   <td><?= $f_late_in;?></td>
   <td><?= $f_early_out;?></td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>
</table>
</div>

    


  </center>

  
  

</body>
</html>