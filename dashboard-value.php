<?php 

require "koneksidb.php";

//Waktu
$date  = date('Y-m-d');
$diff  = strtotime($date); $tgl_f = date("d F Y", $diff);
$clock = date('H:i:s');

//Total Anggota
$query      = "SELECT * FROM tabel_anggota WHERE Level = 'Anggota'";
$result     = mysqli_query($koneksi, $query);
$anggota    = mysqli_num_rows($result);

//Total Hadir
$query2      = "SELECT * FROM tabel_kehadiran WHERE TANGGAL = '$date' AND KET = 'HADIR'";
$result2     = mysqli_query($koneksi, $query2);
$hadir       = mysqli_num_rows($result2);

//Total Tidak Hadir
$query3      = "SELECT * FROM tabel_kehadiran WHERE TANGGAL = '$date' AND 
                (KET = 'ALFA' OR KET = 'SAKIT' OR KET ='IZIN' OR KET = 'BOLOS')";
$result3     = mysqli_query($koneksi, $query3);
$absen       = mysqli_num_rows($result3);

//Total Terlambat
$query4      = "SELECT * FROM tabel_kehadiran WHERE TANGGAL = '$date' AND LATE_IN != 0
                AND CHECK_IN != '00:00:00'";
$result4     = mysqli_query($koneksi, $query4);
$terlambat   = mysqli_num_rows($result4);

//Total Izin Pulang
$query5      = "SELECT * FROM tabel_kehadiran WHERE TANGGAL = '$date' AND EARLY_OUT != 0
                AND CHECK_OUT != '00:00:00'";
$result5     = mysqli_query($koneksi, $query5);
$izin_pulang = mysqli_num_rows($result5);

//Total check out
$query6      = "SELECT * FROM tabel_kehadiran WHERE TANGGAL = '$date' AND CHECK_OUT != '00:00:00'";
$result6     = mysqli_query($koneksi, $query6);
$check_out   = mysqli_num_rows($result6);

//Total check in
$check_in    = $hadir - $check_out;

//Total ruangan
$query7     = "SELECT * FROM tabel_room";
$result7    = mysqli_query($koneksi, $query7);
$room       = mysqli_num_rows($result7);







 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>



<!-- <div class="container"> -->

  <div class="row my-3 mx-1">

      <div class="col-sm-3">
          <div class="card text-white mb-3" style="background-color: #9400D3">
            <div class="card-header" style="font-size:20px;">Total Anggota</div>
            <div class="card-body" style="font-size: 45px;"><i class="fa fa-users"></i> <?= $anggota; ?> </div>
          </div>
      </div>

      <div class="col-sm-3">
        <div class="card text-white mb-3" style="background-color: #32CD32">
          <div class="card-header" style="font-size: 20px;">Total Hadir</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-user-check"></i> <?=$hadir; ?></div>
        </div>
      </div>

       <div class="col-sm-3">
        <div class="card text-white mb-3" style="background-color: #008B8B" >
          <div class="card-header" style="font-size:20px;">Total Check In</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-sign-in-alt"></i> <?=$check_in; ?></div>
        </div>
      </div> 

      <div class="col-sm-3">
        <div class="card text-white mb-3" style="background-color: #4682B4">
          <div class="card-header" style="font-size: 20px;">Total Terlambat</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-user-clock"></i> <?=$terlambat;?></div>
        </div>
      </div>

       <div class="col-sm-3">
        <div class="card text-white mb-3" style="background-color: #FF1493">
          <div class="card-header" style="font-size: 20px;">Total Ruangan</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-door-open"></i> <?=$room;?></div>
        </div>
      </div>
      
      <div class="col-sm-3">
        <div class="card text-white bg-danger mb-3" >
          <div class="card-header" style="font-size:20px;">Total Tidak Hadir</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-user-times"></i> <?=$absen;?></div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card text-white mb-3" style="background-color: #DAA520">
          <div class="card-header" style="font-size: 20px;">Total Check Out</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-sign-out-alt"></i> <?=$check_out; ?></div>
        </div>
      </div>

       <div class="col-sm-3">
        <div class="card text-white bg-secondary mb-3">
          <div class="card-header" style="font-size: 20px;">Total Izin Pulang</div>
          <div class="card-body" style="font-size: 45px;"><i class="fa fa-edit"></i> <?=$izin_pulang; ?></div>
        </div>
      </div> 

  </div>
<!-- </div> -->


 
    </div>
  </div>
</div>	

	</center>


</body>
</html>