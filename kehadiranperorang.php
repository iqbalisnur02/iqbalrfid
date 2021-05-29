<?php 

require "template.php";

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
 	<h3 class="mt-2">REKAMAN PRESENSI</h3>
  <p>Nama : <?=$NAMA;?> || ID : <?=$ID;?></p>
 	
  <div class="row mb-2" >
      <div class="col">
           <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i> Export
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdfperorang.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
                  <a class="dropdown-item" href="excelperorang.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-excel"></i> Excel</a>
              </div>
            </div>
      </div>
       <div class="col">
        <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i> Filter</button>
      </div>
  </div>
 	

 	<div class="table-responsive-sm">
 		<table class="table table-bordered table-striped text-center" style="width:80rem;">
 			<tr class="bg-dark text-white">
 				<th class="py-3" rowspan="2">No</th>
 				<th class="py-3" rowspan="2">Tanggal</th>
        <th class="py-3" rowspan="2">Shift</th>
 				<th class="py-1" colspan="2">Jam Masuk</th>
 			  <th class="py-1" colspan="2">Jam Pulang</th>
 			  <th class="py-3" rowspan="2">Keterangan</th>
 			  <th class="py-3" rowspan="2">Aksi</th>
 			</tr>
 			<tr class="bg-dark text-white">
 				<th class="py-1">Check In</th>
 				<th class="py-1">Late In</th>
 				<th class="py-1">Check Out</th>
 				<th class="py-1">Early Out</th>
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
 				<td>
 				<a class="ubah btn btn-warning btn-sm"  href="koreksikehadiran.php?no=<?=$kehadiran["no"];?>&
 					ID_CHAT=<?=$ID_CHAT;?>" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="fa fa-edit"></i></a>
 				</td>
 			</tr>
 	<?php
     $i++;
     endforeach; ?>
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
      <form method="get" action="kehadiranperorang.php">
        <div class="modal-body">
          <span>Tanggal Awal</span>
          <input type="date" name="TANGGAL1"><br><br>
          <span>Tanggal Akhir</span>
          <input type="date" name="TANGGAL2">
          <input type="text" name="ID" value="<?=$ID;?>" hidden>
	      <input type="text" name="NAMA" value="<?=$NAMA;?>" hidden>
		  <input type="text" name="ID_CHAT" value="<?=$ID_CHAT;?>" hidden>
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