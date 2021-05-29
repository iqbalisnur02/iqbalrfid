<?php 
	require "template_2.php";

  $ID = $_SESSION["ID"];

if(isset($_GET["bulan"]) AND isset($_GET["tahun"])){
   $bln = $_GET["bulan"];
   $thn = $_GET["tahun"];
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

          //Menghitung jumlah HADIR
          $query6 = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND KET = 'HADIR' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result6   = mysqli_query($koneksi, $query6);
          $hadir     = mysqli_num_rows($result6);

          //Menghitung jumlah TERLAMBAT
          $query7      = "SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2'";
          $result7     = mysqli_query($koneksi, $query7);
          $terlambat   = mysqli_num_rows($result7);

          //Menghitung jumlah JAM TERLAMBAT
          $query9      = "SELECT SUM(LATE_IN) AS 'sum_late' FROM tabel_kehadiran WHERE ID = '$ID' AND LATE_IN != 0 AND CHECK_IN != '00:00:00' AND TANGGAL BETWEEN '$tgl_1' AND '$tgl_2' ";
          $result9     = mysqli_query($koneksi, $query9);
          $late_in     = mysqli_fetch_array($result9);
          $f_late_in   = date("H:i:s", $late_in["sum_late"] - $det);

          



 ?>

 <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
<body>

  <center>
    <h3 class="mt-2">DASHBOARD</h3>
    <p class="mb-4">Nama : <?=$_SESSION["Nama"]." || ID : ".$_SESSION["ID"];?></p>
    <p>Statistik Presensi Periode: <?=$month." ".$thn;?>
      <button type="button" class="btn btn-sm btn-danger" href="#" data-toggle="modal" data-target="#filter" data-toggle="tooltip" data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i> </button>
    </p>
          
          


    <div class="col" style="width: 40rem;">
          <div class="alert alert-success" role="alert">
            <i class="fa fa-user-check"></i> Total Kehadiran : <?=$hadir;?>
          </div>
          <div class="alert alert-primary" role="alert">
            <i class="fa fa-user-injured"></i> Total Sakit : <?=$sakit;?>
          </div>
          <div class="alert alert-secondary" role="alert">
            <i class="fa fa-user-edit"></i> Total Izin : <?=$izin;?>
          </div>
          <div class="alert alert-warning" role="alert">
            <i class="fa fa-user-times"></i> Total Alfa : <?=$alfa;?>
          </div>
          <div class="alert alert-danger" role="alert">
           <i class="fa fa-user-clock"></i> Keterlambatan : <?=$terlambat;?> || <?=$f_late_in;?>
          </div>
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
      <form method="get" action="dashboard_2.php">
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