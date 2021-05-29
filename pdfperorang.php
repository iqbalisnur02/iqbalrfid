<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}


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

// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Define a default Landscape page size/format by name
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                        'format' => 'A4-L',
                        'margin_top' => 0
                      ]);

$cetak = '<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<br>
  <center>
   <h2>REKAMAN PRESENSI</h2>
   <p>Nama :'.$NAMA.' || ID : '.$ID.'</p>
   
  <table border = "1" cellpadding = "8" cellspacing = "1">
   <tr class="bg-dark text-white">
        <th class="py-3" rowspan="2">No.</th>
        <th class="py-3" rowspan="2">Tanggal</th>
        <th class="py-3" rowspan="2">Shift</th>
        <th class="py-1" colspan="2">Jam Masuk</th>
        <th class="py-1" colspan="2">Jam Pulang</th>
        <th class="py-3" rowspan="2">Keterangan</th>
      </tr>
      <tr class="bg-dark text-white">
        <th class="py-1">Check In</th>
        <th class="py-1">Late In</th>
        <th class="py-1">Check Out</th>
        <th class="py-1">Early Out</th>
      </tr>';
    
    $i = 1;
    foreach ($data as $kehadiran) {
      $diff_tgl = strtotime($kehadiran["TANGGAL"]);
      $tanggal  = date("d F Y", $diff_tgl);
      $late_in     = date("H:i:s", $kehadiran["LATE_IN"] - $det);
      $early_out   = date("H:i:s", $kehadiran["EARLY_OUT"] - $det);
      
    	$cetak .= '<tr>
    			   <td>'.$i.'</td>
    			   <td>'.$tanggal.'</td>
             <td>'.$kehadiran["id_shift"].'</td>
    			   <td>'.$kehadiran["CHECK_IN"].'</td>
    			   <td>'.$late_in.'</td>
             <td>'.$kehadiran["CHECK_OUT"].'</td>
             <td>'.$early_out.'</td>
             <td>'.$kehadiran["KET"].'</td>
    	</tr>';
       $i++;
       }
$cetak .= '</table>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output($NAMA.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>