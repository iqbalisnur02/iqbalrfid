<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}

$ID   = mysqli_escape_string($koneksi, $_GET["ID"]);
$NAMA = mysqli_escape_string($koneksi, $_GET["NAMA"]);


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekaman Akses Ruangan ".$NAMA.".xls");

  $Tanggal1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); 
  $Tanggal2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]);  


$dataakses = query("SELECT * FROM tabel_akses_2 WHERE ID = '$ID' AND TANGGAL BETWEEN '$Tanggal1' 
             AND '$Tanggal2' ORDER BY no DESC");

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3>REKAMAN AKSES RUANGAN</h3>
     <p>Nama : <?=$NAMA;?> || ID : <?=$ID;?></p>

<div class="table-responsive-sm" style="width: 70rem;">
 <table class="table table-bordered table-striped">
   <tr class="bg-dark text-white text-center"> 
   <th>No.</th>
   <th>Tanggal</th>
   <th>Jam Masuk</th>
   <th>Jam Keluar</th>
   <th>Ruangan</th>
   </tr>
<?php $i =1;?>

<?php foreach ($dataakses as $akses) :
   $id_room     = $akses["id_room"];
   $dataroom    = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'");
   $diff_tgl     = strtotime($akses["TANGGAL"]);
   $tanggal     = date("d F Y", $diff_tgl);
?>
   <tr>
   <td class="text-center"><?=$i;?></td>
   <td class="text-center"><?=$tanggal;?></td>
   <td class="text-center"><?=$akses["MASUK"];?></td>
   <td class="text-center"><?=$akses["KELUAR"];?></td>
   <?php 
        foreach ($dataroom as $room) {
           echo '<td>'.$room["room"].'</td>';
       }  
   ?> 
   </tr>
   <?php $i++; ?>
<?php endforeach; ?>

</table>
</div>  


  </center>	

</body>
</html>