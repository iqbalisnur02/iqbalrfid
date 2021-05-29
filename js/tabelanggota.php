<?php 

require "../koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}

$keywordanggota = $_GET["keywordanggota"];

$data    =  query("SELECT * FROM tabel_anggota WHERE ID LIKE '%$keywordanggota%' OR NO_INDUK 
            LIKE '%$keywordanggota%' OR NAMA LIKE '%$keywordanggota%' ORDER BY NAMA ASC");

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>

<div class="table-responsive-sm">
<table class="table table-bordered table-hover table-striped" style="width:80rem;">
   <tr class="text-center bg-dark text-white"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>No. Induk</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Subject</th>
   <th>Shift</th>
   <th>Terdaftar</th>
   <th width="140px">Opsi</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $anggota) : 
    $diff_tgl  = strtotime($anggota["TERDAFTAR"]);
    $terdaftar = date("d F Y", $diff_tgl);
    $id_sub = $anggota["id_sub"];
    $datasub = query("SELECT * FROM tabel_subject WHERE id_sub ='$id_sub' ");
?>
   <tr>
   <td class="text-center"><?= $i; ?></td>
   <td class="text-center"><?= $anggota["ID"];?></td>
   <td class="text-center"><?= $anggota["ID_CHAT"];?></td>
   <td class="text-center"><?= $anggota["NO_INDUK"];?></td>
   <td><?= $anggota["NAMA"];?></td>
   <td class="text-center"><?= $anggota["KELAMIN"];?></td>   
   <?php
       foreach ($datasub as $subject){ 
          echo '<td class="text-center">'.$subject["SUBJECT"].'</td>';
        }  
    ?>
   <td class="text-center"><?= $anggota["id_shift"];?></td>
   <td class="text-center"><?=$terdaftar;?></td>
   <td align="center">
      <div class="dropdown">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-filter"></i></button>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="kehadiranperorang.php?ID=<?=$anggota["ID"]; ?>&NAMA=<?=$anggota["NAMA"];?>&ID_CHAT=<?=$anggota["ID_CHAT"];?>"><i class="fa fa-clipboard"></i> 
              Kehadiran</a>
            <a class="dropdown-item" href="ubahanggota.php?ID=<?=$anggota["ID"];?>"><i class="fa fa-edit"></i> Edit</a>
            <a class="dropdown-item alert_hapus" href="hapus.php?ID=<?=$anggota["ID"];?>&ID_CHAT=<?=$anggota["ID_CHAT"];?>"><i class="fa fa-trash-alt"></i> Hapus</a>
          </div>
      </div>
   </td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div> 	
   

    <!-- My Javascript/jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>
 
 </body>
 </html>