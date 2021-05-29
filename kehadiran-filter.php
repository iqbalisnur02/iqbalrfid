<?php 
  
require "template.php";

$TANGGAL1      = mysqli_escape_string($_GET["TANGGAL1"]);
$TANGGAL2      = mysqli_escape_string($_GET["TANGGAL2"]);

$bln = date("m");
$thn = date("Y");

$data = query("SELECT * FROM tabel_kehadiran WHERE TANGGAL BETWEEN '$TANGGAL1' AND '$TANGGAL2'
       ORDER BY TANGGAL DESC");
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<center>
	<h3 class="mb-4 mt-2">DATA PRESENSI ANGGOTA</h3>
  	
  <div class="row mb-3">
      <div class="col">
        <button type="button" class="btn btn-danger" href="#" data-toggle="modal"data-target="#filter" data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i></button>
      </div>
      <div class="col">
          <a type="button" class="btn btn-warning" href="rekapdata.php?bulan=<?=$bln;?>&tahun=<?=$thn;?>" data-toggle="tooltip" data-placement="bottom" title="Rekap Data"><i class="fa fa-table"></i></a>
      </div>
      <div class="col">
         
         <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Export"><i class="fa fa-download"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="pdfkehadiran.php?TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
            <a class="dropdown-item" href="excelkehadiran.php?TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-excel"></i> Excel</a>
          </div>
        </div>
      </div>
  </div>

		
<div class="table-responsive-sm">
<table class="table table-bordered table-striped" style="width: 80rem;">
   <tr class=" bg-dark text-white text-center"> 
   <td class="py-3" rowspan="2">No.</td>
   <td class="py-3" rowspan="2">No. Induk</td>
   <td class="py-3" rowspan="2">Nama Anggota</td>
   <td class="py-3" rowspan="2">Tanggal</td>
   <td class="py-3" rowspan="2">Shift</td>
   <td class="py-1" colspan="2">Jam Masuk</td>
   <td class="py-1" colspan="2">Jam Pulang</td>
   <td class="py-3" rowspan="2">Keterangan</td>
   </tr>
   <tr class=" bg-dark text-white text-center"> 
   <td class="py-1">Check In</td>
   <td class="py-1">Late In</td>
   <td class="py-1">Check Out</td>
   <td class="py-1">Early Out</td>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $kehadiran): 
  $diff_tgl    = strtotime($kehadiran["TANGGAL"]);
  $tanggal     = date("d F Y", $diff_tgl);
  $late_in     = date("H:i:s", $kehadiran["LATE_IN"] - $det);
  $early_out   = date("H:i:s", $kehadiran["EARLY_OUT"] - $det);
?>
   <tr>
   <td class="text-center"><?= $i; ?></td>
   <td class="text-center"><?= $kehadiran["NO_INDUK"];?></td>
   <td><?= $kehadiran["NAMA"];?></td>
   <td class="text-center"><?= $tanggal;?></td>
   <td class="text-center"><?= $kehadiran["id_shift"];?></td>
   <td class="text-center"><?= $kehadiran["CHECK_IN"];?></td>
   <td class="text-center"><?= $late_in;?></td>
   <td class="text-center"><?= $kehadiran["CHECK_OUT"];?></td>
   <td class="text-center"><?= $early_out;?></td>
   <td class="text-center"><?= $kehadiran["KET"];?></td>
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
      <form method="get" action="kehadiran-filter.php">
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