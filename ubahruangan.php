<?php 
require "template.php";

if(isset($_POST["ubahruangan"]))  {
    if(ubahRuangan($_POST) > 0) {
            echo "
                 <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Data Ruangan berhasil diubah',
			            icon: 'success', buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='dataruangan.php'; 
			            });  
				</script>
                ";   
        }
                
   
    else {
      echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Data Ruangan Gagal diubah!!!', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dataruangan.php'; 
            }); 
         </script>
        ";
    }
  }



 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Data Ruangan</title>
</head>
<body>
	<center>
		<h3 class="mb-4 mt-2">UBAH DATA RUANGAN</h3>
		

		   <?php 
               if(isset($_GET["id_room"])){
               	 $id_room = mysqli_escape_string($koneksi, $_GET["id_room"]); 
                 $data   = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'")[0];
           ?>
				 <div class="container table- responsive-sm" style="width: 23rem;">
					  <form method="post" action="ubahruangan.php">
	  					<table class="table">
						    	<tr>
						    		<th>Kode</th>
						    		<td class="text-center"><?=$data['id_room'];?></td>
						    		<input class="text-center" type="text" name="id_room" value="<?=$data["id_room"];?>" hidden>
						    	</tr>	
						    	<tr>
						    		<th>Ruangan</th>
						    		<td><input class="text-center" type="text" name="room" value="<?=$data["room"];?>" autocomplete="off" required></td>
						    	</tr>
						 </table> 
						 <button type="submit" name="ubahruangan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
						  <a href="dataruangan.php" type="button" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a>
					   </form>
			         </div>
			        
             <?php  
			    }
			 ?>

     
	</center>

</body>
</html>