<?php 	
	require "template.php";

	$libur = query("SELECT * FROM tabel_hari_libur")[0];

	$d_LIBUR_3 = strtotime($libur["T_LIBUR_3"]); $T_LIBUR_3 = date("d F Y", $d_LIBUR_3);
	$d_LIBUR_4 = strtotime($libur["T_LIBUR_4"]); $T_LIBUR_4 = date("d F Y", $d_LIBUR_4);
	$d_LIBUR_5 = strtotime($libur["T_LIBUR_5"]); $T_LIBUR_5 = date("d F Y", $d_LIBUR_5);
	$d_LIBUR_6A = strtotime($libur["T_LIBUR_6A"]); $T_LIBUR_6A = date("d F Y", $d_LIBUR_6A);
	$d_LIBUR_6B = strtotime($libur["T_LIBUR_6B"]); $T_LIBUR_6B = date("d F Y", $d_LIBUR_6B);
	$d_LIBUR_7A = strtotime($libur["T_LIBUR_7A"]); $T_LIBUR_7A = date("d F Y", $d_LIBUR_7A);
	$d_LIBUR_7B = strtotime($libur["T_LIBUR_7B"]); $T_LIBUR_7B = date("d F Y", $d_LIBUR_7B);
	
	//Array Nama Hari
	$hari = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

	//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan hari libur
    if(aturLibur($_POST) > 0) {
            echo "
                 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data hari libur telah berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturlibur.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data hari libur telah gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='aturlibur.php'; 
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
 		<h3 class="mb-4 mt-2">PANEL HARI LIBUR</h3>
    
    <form method="post" action="aturlibur.php">	
 	   <div class="table-responsive-sm">
 			<table class="table table-bordered table-striped" style="width:55rem;">
 				            <tr>
 				            	<td>Hari Libur 1</td>
 				            	<?php 
                                     if($libur["H_LIBUR_1"] == "---Pilih Hari---"){
                                     	$h_libur_1 = "---Hari Belum Ditentukan---";
                                     }
                                     else{
                                     	$h_libur_1 = $libur["H_LIBUR_1"];
                                     }
 				            	  ?>
 				            	<td><?=$h_libur_1;?></td>
 				            	<td>
				 				      <div class="input-group">
				                        <div class="input-group-prepend"></div>
				                           <select name="H_LIBUR_1" class="custom-select col-md-5"><
				                            <option selected>---Pilih Hari---</option>
					                            <?php
					                            	foreach($hari as $i ) {
					                            		if ($libur['H_LIBUR_1']===$i) {
						                                     $select="selected";
						                                   }
						                                else {
						                                       $select="";
						                                  }
					                            		echo "<option ".$select.">".$i."</option>"; 
					                            	}
					                            ?> 
				                           </select>
				                       </div>
 				            	</td>
 				            </tr>
 				            <tr>
 				            	<td>Hari Libur 2</td>
 				            	 <?php 
                                     if($libur["H_LIBUR_2"] == "---Pilih Hari---"){
                                     	$h_libur_2 = "---Hari Belum Ditentukan---";
                                     }
                                     else{
                                     	$h_libur_2 = $libur["H_LIBUR_2"];
                                     }
 				            	  ?>
 				            	<td><?=$h_libur_2;?></td>
 				            	<td>
				 				      <div class="input-group">
				                        <div class="input-group-prepend"></div>
				                           <select name="H_LIBUR_2" class="custom-select col-md-5"><
				                            <option selected>---Pilih Hari---</option>
					                            <?php
					                            	foreach($hari as $i ) {
					                            		if ($libur['H_LIBUR_2']===$i) {
						                                     $select="selected";
						                                   }
						                                else {
						                                       $select="";
						                                  }
					                            		echo "<option ".$select.">".$i."</option>"; 
					                            	}
					                            ?> 
				                           </select>
				                       </div>
 				            	</td>
 				            </tr>
              	            <tr>
					    		<td>Hari Libur 3</td>
					    		<?php 	
                                    if($libur["T_LIBUR_3"] == ""){
                                      $t_libur_3 = "---Tanggal belum ditentukan---";
                                    }
                                    else{
                                       $t_libur_3 = $T_LIBUR_3;
                                    }
					    		 ?>
					    		<td><?=$t_libur_3;?></td>
					    		<td><input name="T_LIBUR_3" type="date"></td>
					    	</tr>
					    	<tr>
					    		<td>Hari Libur 4</td>
					    		<?php 	
                                    if($libur["T_LIBUR_4"] == ""){
                                      $t_libur_4 = "---Tanggal belum ditentukan---";
                                    }
                                    else{
                                       $t_libur_4 = $T_LIBUR_4;
                                    }
					    		 ?>
					    		<td><?=$t_libur_4;?></td>
					    		<td><input name="T_LIBUR_4" type="date"></td>
					    	</tr>
					    	<tr>
					    		<td>Hari Libur 5</td>
					    		<?php 	
                                    if($libur["T_LIBUR_5"] == ""){
                                      $t_libur_5 = "---Tanggal belum ditentukan---";
                                    }
                                    else{
                                       $t_libur_5 = $T_LIBUR_5;
                                    }
					    		 ?>
					    		<td><?=$t_libur_5;?></td>
					    		<td><input name="T_LIBUR_5" type="date"></td>
					    	</tr>
					    	<tr>
					    		<td>Hari Libur 6</td>
					    		<?php 	
                                    if($libur["T_LIBUR_6A"] == "" OR 
                                       $libur["T_LIBUR_6B"] == "" ){
                                      $t_libur_6 = "---Tanggal belum ditentukan---";
                                    }
                                    else{
                                       $t_libur_6 = $T_LIBUR_6A." s/d ".$T_LIBUR_6B;
                                    }
					    		 ?>
					    		<td><?=$t_libur_6;?></td>
					    		<td><input name="T_LIBUR_6A" type="date"> s/d 
					    			<input name="T_LIBUR_6B" type="date">
					    	    </td>
					    	</tr>
					    	<tr>
					    		<td>Hari Libur 7</td>
					    		<?php 	
                                    if($libur["T_LIBUR_7A"] == "" OR 
                                       $libur["T_LIBUR_7B"] == "" ){
                                      $t_libur_7 = "---Tanggal belum ditentukan---";
                                    }
                                    else{
                                       $t_libur_7 = $T_LIBUR_7A." s/d ".$T_LIBUR_7B;
                                    }
					    		 ?>
					    		<td><?=$t_libur_7;?></td>
					    		<td><input name="T_LIBUR_7A" type="date"> s/d 
					    			<input name="T_LIBUR_7B" type="date">
					    	    </td>
					    	</tr>
					    </table> 		               
		    </div>
         <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
         <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button> 
	</form>     

 	</center>
 </body>
 </html>