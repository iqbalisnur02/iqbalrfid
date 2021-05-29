<?php 	
	require "template.php";

	$ID        = $_SESSION["ID"];
	$TOKEN     = $pengaturan["TOKEN"];
    $data      = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];


//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan jam kerja
    if(ubahShift($_POST) > 0) {
            echo "
                 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data jam kerja telah berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='shift.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data jam kerja telah gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='shift.php'; 
		            }); 
		         </script>
		        ";
    }
 } 

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3 class="mb-4 mt-2">PANEL JAM KERJA</h3>

 	<?php 
        if(isset($_GET["id_shift"])){
           $id_shift     = mysqli_escape_string($koneksi, $_GET["id_shift"]);
	       $shift        = query("SELECT * FROM tabel_shift WHERE id_shift = '$id_shift'")[0];
	       $JAM_MASUK_1  = $shift["JAM_MASUK_1"];
	       $JAM_MASUK_2  = $shift["JAM_MASUK_2"];
	       $JAM_MASUK_3  = $shift["JAM_MASUK_3"];
	       $JAM_PULANG_1 = $shift["JAM_PULANG_1"];
	       $JAM_PULANG_2 = $shift["JAM_PULANG_2"];
	       $JAM_PULANG_3 = $shift["JAM_PULANG_3"];
     ?>

 	   <div class="table-responsive-sm">
 		<form method="post" action="ubahshift.php">	
 			<table class="table table-bordered" style="width:24rem;">
 				            <tr>
					    		<td>Shift</td>
					    		<td class="text-center"><?=$shift["id_shift"];?></td>
					    		<input type="text" name="id_shift" value="<?=$shift["id_shift"]?>" hidden>
					    	</tr>
					    	<tr>
					    		<td>Mulai Masuk</td>
					    		<td><input class="form-control" name="JAM_MASUK_1" type="time" autocomplete="off" value="<?=$JAM_MASUK_1;?>"></td>
					    	</tr>
					    	<tr>
					    		<td>Jam Masuk</td>
					    		<td><input class="form-control" name="JAM_MASUK_2" type="time" autocomplete="off" value="<?=$JAM_MASUK_2;?>"></td>
					    	</tr>
					    	<tr>
					    		<td>Akhir Masuk</td>
					    		<td><input class="form-control" name="JAM_MASUK_3" type="time" autocomplete="off" value="<?=$JAM_MASUK_3;?>"></td>
					    	</tr>
					    	<tr>
					    		<td>Mulai Pulang</td>
					    		<td><input class="form-control" name="JAM_PULANG_1" type="time" autocomplete="off" value="<?=$JAM_PULANG_1;?>"></td>
					    	</tr>
					    	<tr>
					    		<td>Jam Pulang</td>
					    		<td><input class="form-control" name="JAM_PULANG_2" type="time" autocomplete="off" value="<?=$JAM_PULANG_2;?>"></td>
					    	</tr>
					    	<tr>
					    		<td>Akhir Pulang</td>
					    		<td><input class="form-control" name="JAM_PULANG_3" type="time" autocomplete="off" value="<?=$JAM_PULANG_3;?>"></td>
					    	</tr>
					    </table> 
					     <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                         <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button>
                      </form>
		</div>  
	<?php 	} ?>   

 	</center>
 </body>
 </html>