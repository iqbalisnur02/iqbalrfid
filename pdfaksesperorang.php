<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}

$ID        = mysqli_escape_string($koneksi, $_GET["ID"]);
$NAMA      = mysqli_escape_string($koneksi, $_GET["NAMA"]);
$Tanggal1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); 
$Tanggal2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]); 

$dataakses = query("SELECT * FROM tabel_akses_2 WHERE ID = '$ID' AND TANGGAL BETWEEN '$Tanggal1' 
             AND '$Tanggal2'ORDER BY no DESC");
// Require composer autoload
require 'vendor/autoload.php';

// Define a default Landscape page size/format by name
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
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
   <p><h2>REKAMAN AKSES RUANGAN</h2></p>
   <p>Nama :'.$NAMA.' || ID : '.$ID.'</p>
  <table border = "1" cellpadding = "8" cellspacing = "1">
   <tr>
   <th>No.</th>
     <th>Tanggal</th>
     <th>Jam Masuk</th>
     <th>Jam Keluar</th>
     <th>Ruangan</th>
   </tr>';
    
    $i = 1;
    foreach ($dataakses as $akses) {
      $id_room     = $akses["id_room"];
      $dataroom    = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'");
      $diff_tgl    = strtotime($akses["TANGGAL"]);
      $tanggal     = date("d F Y", $diff_tgl);
      $cetak .= '<tr>
                 <td>'.$i.'</td>
                 <td>'.$tanggal.'</td>
                 <td>'.$akses["MASUK"].'</td>
                 <td>'.$akses["KELUAR"].'</td>';

      foreach ($dataroom as $room){ 
          $cetak .= '<td>'.$room["room"].'</td>
                     </tr>';
       } 
       $i++;
    }
$cetak .= '</table>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output('Rekaman akses ruangan '.$NAMA.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>