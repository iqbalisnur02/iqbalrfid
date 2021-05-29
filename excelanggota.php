<?php

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Anggota.xls");

$data = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 

?>

<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
    

  </head>
<body>

<!--  -->
  <center>
    <h3>DATA ANGGOTA</h3>


<div class="table-responsive-sm mx-5">
<table>
   <tr > 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>No. Induk</th>
   <th>Nama Anggota</th>
   <th>L/P</th>
   <th>Subject</th>
   <th>Shift</th>
   <th>Terdaftar</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $anggota) :
   $diff_tgl  = strtotime($anggota["TERDAFTAR"]);
   $terdaftar = date("d F Y", $diff_tgl);
   $id_sub = $anggota["id_sub"];
   $datasub = query("SELECT * FROM tabel_subject WHERE id_sub ='$id_sub' ");
?> 
   <tr>
   <td><?= $i; ?></td>
   <td><?= $anggota["ID"];?></td>
   <td><?= $anggota["ID_CHAT"];?></td>
   <td>'<?= $anggota["NO_INDUK"];?></td>
   <td><?= $anggota["NAMA"];?></td>
   <td><?= $anggota["KELAMIN"];?></td>
   <?php
       foreach ($datasub as $subject){ 
          echo '<td class="text-center">'.$subject["SUBJECT"].'</td>';
        }  
    ?>
   <td><?= $anggota["id_shift"];?></td>
   <td class="text-center"><?=$terdaftar;?></td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div>

</center>



</body>
</html> 