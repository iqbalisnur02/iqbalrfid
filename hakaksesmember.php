<?php 

if (isset($_GET["Template"])) {
  require $_GET["Template"];
}
else{
  require "template_2.php";
}

if(isset($_GET["ID"])){
  $ID   = mysqli_escape_string($koneksi, $_GET["ID"]);
  $NAMA = mysqli_escape_string($koneksi, $_GET["NAMA"]);
}
else{
  $ID   = $_SESSION["ID"];
  $NAMA = $_SESSION["Nama"];
}

$data = query("SELECT * FROM tabel_hak_akses WHERE ID = '$ID'")



 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<center>
 		<h3 class="mt-2">HAK AKSES RUANGAN</h3>
 		 <p>Nama : <?=$NAMA;?> || ID : <?=$ID;?></p>

 		 <div class="table-responsive-sm">
  					<table class="table table-striped" style="width:20rem;">
					    	<tr class="text-white bg-dark">
					    		<th class="text-center">No</th>
                                <th class="text-center">Nama Ruangan</th>
					    	</tr>	
    					     <?php 
	      					     $no = 1;
	      					     foreach ($data as $i) :
                              ?> 
					    	<tr>
                                <td class="text-center"><?=$no;?></td>
  					    		<td class="text-center"><?=$i["room"];?></td>
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