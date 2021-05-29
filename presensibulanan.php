<?php 
require "template.php";

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

      <style type="text/css">
          .hadir {
            color: green;
          }
          .sakit {
            color: orange;
          }
          .izin {
             color: blue;
          }
          .alfa{
            color: purple;
          }
          .bolos{
            color: brown;
          }
          .lupa{
            color: lightblue;
          }
          .libur {
            color: red;
          }
      </style>

  <center>
  	<h3 class="mt-2">PRESENSI BULANAN</h3>
    <p>Periode: <?=$TB;?></p>
  	

	 <div class="row mb-4">
    <div class="col">
      <button type="button" class="btn btn-danger" href="#" data-toggle="modal" data-target="#filter" data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i></button>
    </div>
    <div class="col">
       <a href="rekapdata.php?tahun=<?=$thn;?>&bulan=<?=$bln;?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Rekap Data"><i class="fa fa-table"></i> </a>
    </div>
     <div class="col">
        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Export"><i class="fa fa-download"></i>
           </button>
           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="pdfpresensibulanan.php?bulan=<?=$bln;?>&tahun=<?=$thn;?>"><i class="fa fa-file-pdf"></i> PDF</a>
              <a class="dropdown-item" href="excelpresensibulanan.php?bulan=<?=$bln;?>&tahun=<?=$thn;?>"><i class="fa fa-file-excel"></i> Excel</a>
           </div>
        </div>
     </div>
  </div>
	

<div class="table-responsive-sm">
  <table class="table table-bordered table-hover table-striped" style="font-size: 11px;">
     <tr class="text-center text-white bg-dark"> 
       <th rowspan="2" class="py-3">No.</th>
       <th rowspan="2" class="py-3 px-5">Nama</th> 
       <th colspan="<?=$lengthday;?>" class="py-1">Tanggal</th>   
     </tr>
      <tr class="text-center text-white bg-dark">
         <?php  for($d=1; $d <= $lengthday; $d++){
           if ($d < 10){
                  $d = "0".(String)$d;
                }
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
                       case 'HADIR': $col = "green";     $ket = "H";  $tooltip  = "Hadir";    break;
                       case 'SAKIT': $col = "yellow";    $ket = "S";  $tooltip  = "Sakit";    break;
                       case 'IZIN' : $col = "blue";      $ket = "I";  $tooltip  = "Izin";     break;
                       case 'ALFA' : $col = "purple";    $ket = "A";  $tooltip  = "Alfa";     break;
                       case 'BOLOS': $col = "brown";     $ket = "B";  $tooltip  = "Bolos";    break;
                       case 'LUPA' : $col = "lightblue"; $ket = "LT"; $tooltip  = "Lupa Tap"; break;
                       case 'LIBUR': $col = "red";       $ket = "L";  $tooltip  = "Libur";    break;
                       case ''     : $col = "";          break;
                    }
                       echo '<td data-toggle="tooltip" data-placement="bottom" title='.$tooltip.' style="background-color:'.$col.';">'.$ket.'</td>';
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

<!-- Modal Filter Bulan Tahun -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-calendar"></i> FILTER PERIODE</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="get" action="presensibulanan.php">
        <div class="modal-body">
            <div class="input-group">
              <div class="input-group-prepend"></div>
                  <select name="bulan" class="custom-select"><
                    <option selected>---Pilih Bulan---</option>
                       <?php
                            $bulan = ["Januari" => "01", "Februari" => "02", "Maret" => "03", 
                                      "April" => "04", "Mei" => "05", "Juni" => "06",
                                      "Juli" => "07", "Agustus" => "08", "September" => "09",
                                      "Oktober" => "10", "November" => "11", "Desember" => "12"];
                             
                            foreach ($bulan as $key => $val) {
                              echo "<option value=".$val.">".$key."</option>"; 
                            }
                         ?>
                  </select>
              </div>
              <div class="form-group mt-3">
                 <input class="form-control" type="number" name="tahun" placeholder=" Masukkan Tahun..." autocomplete="off" required>
              </div>
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