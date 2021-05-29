<?php 
require "template.php";

if(isset($_POST["ubahsubject"]))  {
    if(ubahsubject($_POST) > 0) {
            echo "
                 <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Nama Subject berhasil diubah',
			            icon: 'success', buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='subject.php'; 
			            });  
				</script>
                ";   
        }
                
   
    else {
      echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Nama Subject Gagal diubah!!!', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='subject.php'; 
            }); 
         </script>
        ";
    }
  }



 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Pengaturan</title>
</head>
<body>
	<center>
		<h3 class="mb-4 mt-2">UBAH SUBJECT </h3>

		   <?php 
               if(isset($_GET["id_sub"])){
               	 $id_sub = mysqli_escape_string($koneksi, $_GET["id_sub"]); 
                 $data   = query("SELECT * FROM tabel_subject WHERE id_sub = '$id_sub'")[0];
                 //Menghitung jumlah subject
                $sub      = $data["SUBJECT"];
                $query    = "SELECT * FROM tabel_anggota WHERE id_sub = '$id_sub'";
                $result   = mysqli_query($koneksi, $query);
                $val      = mysqli_num_rows($result);
           ?>
				 
				    <div class="container responsive-sm" style="width: 23rem;">
					  <form method="post" action="ubahsubject.php">
	  					<table class="table text-center">
						    	<tr>
						    		<th>Subject</th>
						    		<td><input class="text-center" type="text" name="SUBJECT" value="<?=$sub;?>" autocomplete = "off"></td>
						    	</tr>	
						    	<tr>
						    		<th>Jumlah</th>
						    		<td><?=$val;?> orang</td>
						    		<input type="text" name="id_sub" value="<?=$data["id_sub"];?>" hidden>
						    	</tr>
						 </table> 
						 <button type="submit" name="ubahsubject" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
						  <a href="subject.php" type="button" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a>
					   </form>
			         </div>
			        
             <?php  
			    }
			 ?>

     
	</center>

</body>
</html>