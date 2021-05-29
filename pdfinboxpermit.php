<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}

  $TANGGAL1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]); $waktu2 = $TANGGAL2." 23:59:59";

$datapermit = query("SELECT * FROM tabel_permit WHERE waktu BETWEEN '$waktu1' AND '$waktu2' ORDER BY no DESC");

// Require composer autoload
require 'vendor/autoload.php';

// Define a default Landscape page size/format by name
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
   <center>
  <p><h2 class>INBOX PERMIT</h2><p>

  <table border = "1" cellpadding = "8" cellspacing = "1">
      <tr class="bg-dark text-white">
        <th>No</th>
        <th>Waktu</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Periode Permit</th>
        <th>Jenis</th>
        <th>Keterangan</th>
        <th>Status</th>
      </tr>';
    
   
        $no = 1;
        foreach ($datapermit as $permit) {
            $tgl_awal  = date("d F Y", strtotime($permit["tgl_awal"]));
            $tgl_akhir = date("d F Y", strtotime($permit["tgl_akhir"]));
            $cetak .= '<tr>
                       <td>'.$no.'</td>
                       <td>'.$permit["waktu"].'</td>
                       <td>'.$permit["ID"].'</td>
                       <td>'.$permit["NAMA"].'</td>
                       <td>'.$tgl_awal." s/d ".$tgl_akhir.'</td>
                       <td>'.$permit["jenis"].'</td>
                       <td>'.$permit["keterangan"].'</td>
                       <td>'.$permit["status"].'</td>';
            $no++;
       } 
       
$cetak .= '</table>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output('data inbox permit.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>