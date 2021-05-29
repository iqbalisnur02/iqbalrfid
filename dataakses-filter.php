<?php 

require "template.php";

   $Tanggal1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); 
   $Tanggal2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]); 

$dataakses = query("SELECT * FROM tabel_akses_2 WHERE TANGGAL BETWEEN '$Tanggal1' AND '$Tanggal2' ORDER BY no DESC");

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
    <h3 class="mb-4 mt-2">DATA AKSES RUANGAN</h3>
    

  <div class="row mb-2">
      <div class="col">
        <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i></button>
      </div>
      <div class="col">
         <a href="dataruangan.php" class="btn btn-warning"><i class="fa fa-door-open"></i></a>
      </div>
      <div class="col">
        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" ><i class="fa fa-download"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="pdfdataakses.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
            <a class="dropdown-item" href="exceldataakses.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Excel</a>
          </div>
        </div>
       </div>
  </div>


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
   $diff_tgl    = strtotime($akses["TANGGAL"]);
   $tanggal     = date("d F Y", $diff_tgl);
?>
   <tr>
   <td class="text-center"><?=$i;?></td>
   <td class="text-center"><?=$tanggal;?></td>
   <td class="text-center"><?=$akses["ID"];?></td>
   <td><?=$akses["NAMA"];?></td>
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
    
    <!-- Modal Filter Tanggal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-calendar"></i> FILTER TANGGAL</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="get" action="dataakses-filter.php">
        <div class="modal-body">
          <span>Tanggal Awal</span>
          <input type="date" name="TANGGAL1"><br><br>
          <span>Tanggal Akhir</span>
          <input type="date" name="TANGGAL2">
        </div>
      <div class="modal-footer">
        <button type="submit" value="Filter" class="btn btn-success"><i class="fa fa-filter"></i> Filter </button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

</body>
</html>