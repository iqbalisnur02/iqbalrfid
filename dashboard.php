<?php

require "template.php";

//Permit awaiting
$query8     = "SELECT * FROM tabel_permit WHERE status = 'awaiting'";
$result8    = mysqli_query($koneksi, $query8);
$awaiting   = mysqli_num_rows($result8);




?>

<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
<body>

  <center>
    <h3 class="mb-4 mt-2">DASHBOARD</h3>
    <?php 
     if ($awaiting != 0) {
        echo'<div class="alert alert-danger mx-3" role="alert"><i class="fa fa-hourglass-half"></i>
               Pengajuan Permit Yang Menunggu Respon: <strong>'.$awaiting.'</strong><a href="inboxpermit.php" class="mx-3"> Klik Disini</a>
            </div>';
     }
   ?>



    

    <div class="dashboard-value"></div>
    

</center>

 

</body>
</html> 
