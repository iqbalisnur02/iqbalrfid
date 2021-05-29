<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}



header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Inbox Permit.xls");

 
  $TANGGAL1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]); $waktu2 = $TANGGAL2." 23:59:59";

$datapermit = query("SELECT * FROM tabel_permit WHERE waktu BETWEEN '$waktu1' AND '$waktu2' ORDER BY no DESC");

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
    <center>
      <h3 class="mb-4 mt-2">INBOX PERMIT</h3>
      <div class="table-responsive-sm">
    <table class="table table-bordered table-striped text-center" style="width:78rem;">
      <tr class="bg-dark text-white">
        <th>No</th>
        <th>Waktu</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Periode Permit</th>
        <th>Jenis</th>
        <th>Keterangan</th>
        <th>Status</th>
      </tr>
      <?php 
        $no = 1;
        foreach ($datapermit as $permit) :
            $tgl_awal  = date("d F Y", strtotime($permit["tgl_awal"]));
            $tgl_akhir = date("d F Y", strtotime($permit["tgl_akhir"]));
       ?>
       <tr>
          <td class="text-center"><?=$no;?></td> 
          <td class="text=center"><?=$permit["waktu"];?></td>
          <td class="text-center"><?=$permit["ID"];?></td>
          <td><?=$permit["NAMA"];?></td>
          <td class="text=center"><?=$tgl_awal." s/d ".$tgl_akhir?></td>
          <td class="text-center"><?=$permit["jenis"];?></td>
          <td><?=$permit["keterangan"];?></td>
          <td class="text-center"><?=$permit["status"];?></td>
       </tr>
      <?php 
        $no++;
        endforeach;
      ?>
    </table>
  </div>
    </center>
</body>
</html>

 