<?php 
require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}



header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Presensi Bulanan.xls");

$thn  = mysqli_escape_string($koneksi, $_GET["tahun"]);
$bln  = mysqli_escape_string($koneksi, $_GET["bulan"]);
$YM   = $thn."-".$bln;
$diff = strtotime($YM);
$TB   = date("F Y", $diff);  

$lengthday = cal_days_in_month(CAL_GREGORIAN, $bln, $thn); 

$dataanggota = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3>PRESENSI BULANAN</h3>

<div class="table-responsive-sm">

<div class="row" style="width:90rem;">
  <div class="col">
       <p style="font-weight: bold">Periode: <?=$TB; ?></p>
  </div>
</div>

<table class="table table-bordered table-hover table-striped">
   <tr class="text-center text-white bg-dark"> 
   <th rowspan="2" class="py-3">No.</th>
   <th rowspan="2" class="py-3 px-5">Nama</th> 
   <th colspan="<?=$lengthday;?>" class="py-1">Tanggal</th>   
   </tr>
    <tr class="text-center text-white bg-dark">
       <?php  for($d=1; $d <= $lengthday; $d++){
          echo "<th class='py-1'>$d</th>";
      }?>
   </tr>
<?php $i =1;?>

<tr> 
   <?php 

      foreach ($dataanggota as $anggota) :
        $ID   = $anggota["ID"];
        $nama = $anggota["NAMA"];
        echo "<td>".$i."</td>
              <td>".$nama."</td>"; 

           for ($d=1; $d<=$lengthday; $d++) { 
            if ($d < 10){
                $d = "0".(String)$d;
              }
             $tgl  = date("Y-m-".$d, $diff);
             $read = query("SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND TANGGAL = '$tgl'");

              if($read){
                foreach ($read as $key) {
                    switch ($key['KET']) {
                       case 'HADIR': $col = "green";     $ket = "H";    break;
                       case 'SAKIT': $col = "yellow";    $ket = "S";    break;
                       case 'IZIN' : $col = "blue";      $ket = "I";    break;
                       case 'ALFA' : $col = "purple";    $ket = "A";    break;
                       case 'BOLOS': $col = "brown";     $ket = "B";    break;
                       case 'LUPA' : $col = "lightblue"; $ket = "LT";   break;
                       case 'LIBUR': $col = "red";       $ket = "L";    break;
                       case ''     : $col = "";          break;
                    }
                       echo '<td style="background-color:'.$col.';">'.$ket.'</td>';
                 }
              }
              else{
                echo '<td>-</td>';
              }

           }
    ?>
</tr>
   <?php $i++; ?>
  <?php endforeach;?>
</table>
</div>

  	


  </center>

  
	

</body>
</html>