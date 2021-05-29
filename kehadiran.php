<?php 
require "template.php";

$TANGGAL1 = date("Y-m-d");
$TANGGAL2 = date("Y-m-d");

$bln = date("m");
$thn = date("Y");

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


  	<div class="kehadiran-value"></div>


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