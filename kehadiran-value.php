<?php 

require "kehadiran-logic.php";
session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    $TOKEN   = $pengaturan["TOKEN"];
    $ID_CHAT = $pengaturan["ID_CHAT"];
    $pesan   = "PERINGATAN!!!\n\nAda yang berusaha mengakses akun anda secara paksa (tanpa melalui login)";
    header("location:index.php");
    kirimPesan($ID_CHAT, $pesan, $TOKEN);
    exit;
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>

<div class="table-responsive-sm">
<table class="table table-bordered table-striped" style="width: 80rem;">
   <tr class="bg-dark text-white text-center"> 
   <td class="py-3" rowspan="2">No.</td>
   <td class="py-3" rowspan="2">No. Induk</td>
   <td class="py-3" rowspan="2">Nama Anggota</td>
   <td class="py-3" rowspan="2">Tanggal</td>
   <td class="py-3" rowspan="2">Shift</td>
   <td class="py-1" colspan="2">Jam Masuk</td>
   <td class="py-1" colspan="2">Jam Pulang</td>
   <td class="py-3" rowspan="2">Keterangan</td>
   </tr>
   <tr class="bg-dark text-white text-center"> 
   <td class="py-1">Check In</td>
   <td class="py-1">Late In</td>
   <td class="py-1">Check Out</td>
   <td class="py-1">Early Out</td>
   </tr>
<?php $i =1;?>

<?php foreach ($datakehadiran as $kehadiran) :
     $diff_tgl    = strtotime($kehadiran["TANGGAL"]);
     $tanggal     = date("d F Y", $diff_tgl);
     $late_in     = date("H:i:s", $kehadiran["LATE_IN"] - $det);
     $early_out   = date("H:i:s", $kehadiran["EARLY_OUT"] - $det);

  if ($kehadiran["STAT"] =="alfa"){
     $sql = "UPDATE tabel_kehadiran SET  CHECK_IN = '00:00:00', CHECK_OUT = '00:00:00', EARLY_OUT = 0, KET = 'ALFA' WHERE STAT = 'alfa'";
     $koneksi->query($sql); 
   }
  else if ($kehadiran["STAT"] =="bolos"){
     $sql = "UPDATE tabel_kehadiran SET CHECK_OUT = '00:00:00', KET = 'BOLOS' WHERE STAT = 'bolos'";
     $koneksi->query($sql); 
   }
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


 
 </body>
 </html>