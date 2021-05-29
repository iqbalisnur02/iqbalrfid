<?php 
require "template.php";

if(isset($_GET["bulan"]) AND isset($_GET["tahun"])){
   $bln = mysqli_escape_string($koneksi, $_GET["bulan"]);
   $thn = mysqli_escape_string($koneksi, $_GET["tahun"]);
}
else{
   $bln = date("m"); //bulan saat ini
   $thn = date("Y"); //tahun saat ini
}
 
$tgl_1 = $thn."-".$bln."-01";
$tgl_2 = $thn."-".$bln."-31";

switch ($bln) {
  case '01': $month = "Januari";  break;   case '07': $month = "Juli";      break;
  case '02': $month = "Februari"; break;   case '08': $month = "Agustus";   break;
  case '03': $month = "Maret";    break;   case '09': $month = "September"; break;
  case '04': $month = "April";    break;   case '10': $month = "Oktober";   break;
  case '05': $month = "Mei";      break;   case '11': $month = "November";  break;
  case '06': $month = "Juni";     break;   case '12': $month = "Desember";  break;
}

$dataanggota = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 


?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3 class="mt-2">REKAPITULASI BULANAN</h3>
     <p>Periode: <?=$month." ".$thn; ?></p>
  	
	<div class="row mb-4">
    <div class="col">
      <button type="button" class="btn btn-danger" href="#" data-toggle="modal"data-target="#filter"  data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i></button>
    </div>
    <div class="col">
       <a href="presensibulanan.php?tahun=<?=$thn;?>&bulan=<?=$bln;?>" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Presensi Bulanan"><i class="fa fa-table"></i> </a>
    </div>
     <div class="col">
        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" data-placement="bottom" title="Export"><i class="fa fa-download"></i>
           </button>
           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="pdfrekap.php?bulan=<?=$bln;?>&tahun=<?=$thn;?>"><i class="fa fa-file-pdf"></i> PDF</a>
              <a class="dropdown-item" href="excelrekap.php?bulan=<?=$bln;?>&tahun=<?=$thn;?>"><i class="fa fa-file-excel"></i> Excel</a>
           </div>
        </div>
     </div>
  </div>

		


<div class="table-responsive-sm">
<table class="table table-bordered table-hover table-striped" style="width: 80rem;">
   <tr class="text-center text-white bg-dark"> 
     <th>No.</th>
     <th>No. Induk</th>
     <th>Nama Anggota</th>
     <th>H</th> 
     <th>S</th>
     <th>I</th>
     <th>A</th>
     <th>B</th>
     <th>L</th>
     <th>T</th>
     <th>P</th>
     <th>Late In</th>
     <th>Early Out</th>
   </tr>
<?php 

    $i =1;
   foreach ($dataanggota as $anggota) :
     $ID = $anggota["ID"];
   
          //Menghitung jumlah ALFA
          $query =  "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'ALFA' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result   = mysqli_query($koneksi, $query);
          $alfa     = mysqli_num_rows($result);

          //menghitung jumlah SAKIT
          $query2 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'SAKIT' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result2   = mysqli_query($koneksi, $query2);
          $sakit     = mysqli_num_rows($result2);

          //menghitung jumlah IZIN
          $query3 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'IZIN' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result3   = mysqli_query($koneksi, $query3);
          $izin      = mysqli_num_rows($result3);

          //menghitung jumlah BOLOS
          $query4 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'BOLOS' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result4   = mysqli_query($koneksi, $query4);
          $bolos     = mysqli_num_rows($result4);

          //menghitung jumlah LUPA
          $query5 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'LUPA' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result5   = mysqli_query($koneksi, $query5);
          $lupa     = mysqli_num_rows($result5);

          //Menghitung jumlah HADIR
          $query6 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'HADIR' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result6   = mysqli_query($koneksi, $query6);
          $hadir     = mysqli_num_rows($result6);

          //Menghitung jumlah TERLAMBAT
          $query7      = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result7     = mysqli_query($koneksi, $query7);
          $terlambat   = mysqli_num_rows($result7);

          //Menghitung jumlah PULANG CEPAT
          $query8      = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND EARLY_OUT != 0 AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result8     = mysqli_query($koneksi, $query8);
          $plg_cepat   = mysqli_num_rows($result8);

          //Menghitung jumlah JAM TERLAMBAT
          $query9      = "SELECT SUM(LATE_IN) AS 'sum_late' FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND CHECK_IN != '00:00:00' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2' ";
          $result9     = mysqli_query($koneksi, $query9);
          $late_in     = mysqli_fetch_array($result9);
          $f_late_in   = date("H:i:s", $late_in["sum_late"] - $det);

          //Menghitung jumlah JAM PULANG CEPAT
          $query10      = "SELECT SUM(EARLY_OUT) AS 'sum_early' FROM tabel_kehadiran WHERE ID = '$ID' AND EARLY_OUT != 0 AND CHECK_OUT != '00:00:00' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result10     = mysqli_query($koneksi, $query10);
          $early_out    = mysqli_fetch_array($result10);
          $f_early_out   = date("H:i:s", $early_out["sum_early"] - $det);


 ?>





   <tr>
       <td class="text-center"><?= $i; ?></td>
       <td class="text-center"><?= $anggota["NO_INDUK"];?></td>
       <td><?= $anggota["NAMA"];?></td>
       <td class="text-center"><?= $hadir?></td>
       <td class="text-center"><?= $sakit;?></td>
       <td class="text-center"><?= $izin;?></td>
       <td class="text-center"><?= $alfa;?></td>
       <td class="text-center"><?= $bolos;?></td>
       <td class="text-center"><?= $lupa;?></td>
       <td class="text-center"><?= $terlambat;?></td>
       <td class="text-center"><?= $plg_cepat;?></td>
       <td class="text-center"><?=$f_late_in;?></td>
       <td class="text-center"><?=$f_early_out;?></td>
   </tr>
   <?php $i++; 
         endforeach; ?>
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
      <form method="get" action="rekapdata.php">
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