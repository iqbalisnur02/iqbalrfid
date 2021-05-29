<?php 

require "koneksidb.php";

$Tanggal  = date("Y-m-d"); 

$dataakses = query("SELECT * FROM tabel_akses_2 WHERE TANGGAL = '$Tanggal' ORDER BY no DESC");

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<div class="table-responsive-sm">
 <table class="table table-bordered table-striped" style="width:70rem;">
   <tr class="bg-dark text-white text-center"> 
     <th>No.</th>
     <th>Tanggal</th>
     <th>ID Card</th>
     <th>Nama Pengguna</th>
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
   <td class="text-center"><?=$akses["ID"];?></td>
   <td><?=$akses["NAMA"];?></td>
   <td class="text-center"><?=$akses["MASUK"];?></td>
   <?php 

      if ($akses["KELUAR"] == 0) {
        echo '<td class="text-center"></td>';
      }
      else{
         echo '<td class="text-center">'.$akses["KELUAR"].'</td>';
      }
   
      foreach ($dataroom as $room) {
           echo '<td>'.$room["room"].'</td>';
       }  
   ?> 
   </tr>
   <?php $i++; ?>
<?php endforeach; ?>

</table>
</div>  

</body>
</html>