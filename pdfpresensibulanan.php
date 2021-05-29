<?php 
require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}

$thn  = mysqli_escape_string($koneksi, $_GET["tahun"]);
$bln  = mysqli_escape_string($koneksi, $_GET["bulan"]);
$YM   = $thn."-".$bln;
$diff = strtotime($YM);
$TB   = date("F Y", $diff);  

$lengthday = cal_days_in_month(CAL_GREGORIAN, $bln, $thn); 
$dataanggota = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 

// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                        'format' => 'A4-L',
                        'margin_top' => 0
                      ]);



$cetak= '<!DOCTYPE html>
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
            	<h3>PRESENSI BULANAN</h3>

<div style="width:100rem;">
  
       <strong>Keterangan:
       <span class="hadir">Hadir;</span>
       <span class="sakit">Sakit;</span>
       <span class="izin">Izin;</span>
       <span class="alfa">Alfa;</span>
       <span class="bolos">Bolos;</span>
       <span class="lupa">Lupa Tap;</span>
       <span class="libur">Libur</span></strong>
       <p style="font-weight: bold">Periode:'.$TB.'</p>
  
</div>

    <div class="table-responsive-sm">

<table border="1">
   <tr> 
   <th rowspan="2" class="py-3">No.</th>
   <th rowspan="2" class="py-3 px-5">Nama</th> 
   <th colspan="'.$lengthday.'" class="py-1">Tanggal</th>   
   </tr>
    <tr class="text-center text-white bg-dark">';

       for($d=1; $d <= $lengthday; $d++){
         if ($d < 10){
                $d = "0".(String)$d;
              }
          $cetak.='<th class="py-1">'.$d.'</th>';
      }

   $cetak.='</tr>';
      $i =1;

      foreach ($dataanggota as $anggota) :
    $cetak.='<tr>'; 
        $ID   = $anggota["ID"];
        $nama = $anggota["NAMA"];
        $cetak.= '<td>'.$i.'</td>
                  <td>'.$nama.'</td>'; 

           for ($d=1; $d<=$lengthday; $d++) { 
            if ($d < 10){
                $d = "0".(String)$d;
              }
             $tgl  = date("Y-m-".$d, $diff);
             $read = query("SELECT * FROM tabel_kehadiran WHERE ID = '$ID' AND TANGGAL = '$tgl'");

              if($read){
                foreach ($read as $key) {
                    switch ($key['KET']) {
                       case 'HADIR': $col = "green";     $ket = "H";    break;
                       case 'SAKIT': $col = "yellow";    $ket = "S";    break;
                       case 'IZIN' : $col = "blue";      $ket = "I";    break;
                       case 'ALFA' : $col = "purple";    $ket = "A";    break;
                       case 'BOLOS': $col = "brown";     $ket = "B";    break;
                       case 'LUPA' : $col = "lightblue"; $ket = "LT";   break;
                       case 'LIBUR': $col = "red";       $ket = "L";    break;
                       case ''     : $col = "";          break;
                    }
                       $row='<td style="background-color:'.$col.'">'.$ket.'</td>';
                 }
              }
              else{
                $row ='<td>-</td>';
              }
              $cetak .= $row;

           }
    
$cetak.='</tr>';
    $i++;
   endforeach;

$cetak .= '</table>
            </div>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output('Presensi '.$TB.'.pdf', \Mpdf\Output\Destination::DOWNLOAD);

?>