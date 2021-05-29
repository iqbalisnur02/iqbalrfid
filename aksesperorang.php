<?php 

require $_GET["Template"];

if(isset($_GET["TANGGAL1"]) AND isset($_GET["TANGGAL2"])){
  $TANGGAL1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]);
  $TANGGAL2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]);
}
else{
  $TANGGAL1  = date("Y-m-d");
  $TANGGAL2  = date("Y-m-d");
}

if (isset($_GET["ID"])) {
  $ID        = mysqli_escape_string($koneksi, $_GET["ID"]);
  $NAMA      = mysqli_escape_string($koneksi, $_GET["NAMA"]);
}
else{
   $ID    = $_SESSION["ID"];
   $NAMA  = $_SESSION["Nama"];
}



$dataakses = query("SELECT * FROM tabel_akses_2 WHERE ID = '$ID' AND TANGGAL BETWEEN '$TANGGAL1' AND '$TANGGAL2' ORDER BY no DESC");



 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
   <center>
 	<h4 class="mt-2">REKAMAN AKSES RUANGAN</h4>
  <p>Nama : <?=$NAMA;?> || ID : <?=$ID;?></p>
 	
  <div class="row mb-2" >
      <div class="col">
           <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Export"><i class="fa fa-download"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdfaksesperorang.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
                  <a class="dropdown-item" href="excelaksesperorang.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-excel"></i> Excel</a>
              </div>
            </div>
      </div>
      <div class="col">
        <a class="btn btn-warning" href="hakaksesmember.php?Template=template_2.php&ID=<?=$ID;?>&NAMA=<?=$NAMA;?>" data-toggle="tooltip" data-placement="bottom" title="Hak Akses"><i class="fa fa-door-open"></i></a>
      </div>
       <div class="col">
        <button type="button" class="btn btn-danger" href="#" data-toggle="modal"data-target="#filter" data-toggle="tooltip" data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i></button>
      </div>
  </div>
 	

 	<div class="table-responsive-sm">
 		<table class="table table-bordered table-striped text-center" style="width:60rem;">
 			<tr class="bg-dark text-white text-center"> 
         <th>No.</th>
         <th>Tanggal</th>
         <th>Jam Masuk</th>
         <th>Jam Keluar</th>
         <th>Ruangan</th>
      </tr>
<?php 
    $i = 1;
    foreach ($dataakses as $akses) :
     $id_room     = $akses["id_room"];
     $dataroom    = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'");
     $diff_tgl    = strtotime($akses["TANGGAL"]);
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
      <form method="get" action="aksesperorang.php">
        <div class="modal-body">
          <span>Tanggal Awal</span>
          <input type="date" name="TANGGAL1"><br><br>
          <span>Tanggal Akhir</span>
          <input type="date" name="TANGGAL2">
          <input type="text" name="Template" value="<?=$_GET['Template'];?>" hidden>
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