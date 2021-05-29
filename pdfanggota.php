<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}


$data = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 

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
   <p><h2>DATA ANGGOTA</h2></p>
  <table border = "1" cellpadding = "8" cellspacing = "1">
   <tr align="center"> 
   <td><strong>No.</strong></td>
   <td><strong>ID Card</strong></td>
   <td><strong>ID Chat</strong></td>
   <td><strong>No. Induk</strong></td>
   <td><strong>Nama Anggota</strong></td>
   <td><strong>L/P</td>
   <td><strong>Subject</strong></td>
   <td><strong>Shift</strong></td>
   <td><strong>Terdaftar</strong></td>
   </tr>';
    
    $i = 1;
    foreach ($data as $anggota) {
        $diff_tgl  = strtotime($anggota["TERDAFTAR"]);
        $terdaftar = date("d F Y", $diff_tgl);
        $id_sub = $anggota["id_sub"];
        $datasub = query("SELECT * FROM tabel_subject WHERE id_sub ='$id_sub' ");
    
    	$cetak .= '<tr>
    			   <td>'.$i.'</td>
    			   <td>'.$anggota["ID"].'</td>
             <td>'.$anggota["ID_CHAT"].'</td>
    			   <td>'.$anggota["NO_INDUK"].'</td>
    			   <td>'.$anggota["NAMA"].'</td>
             <td>'.$anggota["KELAMIN"].'</td>';

        foreach ($datasub as $subject){ 
           $cetak.='<td class="text-center">'.$subject["SUBJECT"].'</td>';
         } 

      $cetak.='<td>'.$anggota["id_shift"].'</td>
               <td>'.$terdaftar.'</td>
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
$mpdf->Output('data anggota.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>