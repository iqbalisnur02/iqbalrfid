<?php 

require "template.php";

$subject    = query("SELECT * FROM tabel_subject");

if(isset($_POST["kirimsubject"]))  {
    if( tambahsubject($_POST) > 0) {
            echo "
          <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Data Telah disimpan',
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
            text: 'Data gagal ditambahkan', 
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
		<h3 class="mb-4 mt-2">DATA SUBJECT </h3>
		
   				<div class="container">
					    <button type="button" class="btn btn-primary mb-2" href="#" data-toggle="modal"data-target="#tambahsubject"><i class="fa fa-plus"></i> Tambah Subject
					    </button>
          </div>

          <div class="table-responsive-sm">
  					<table class="table table-striped" style="width:22rem;">
					    	<tr class="text-white text-center bg-dark">
					    		<th>No.</th>
					    		<th>Subject</th>
					    		<th>Jumlah</th>
					    		<th>Opsi</th>
					    	</tr>	
					     <?php 
					     $no = 1;
					     foreach ($subject as $i) : 
                //Menghitung jumlah subject
                $id_sub   = $i["id_sub"];
                $query    = "SELECT * FROM tabel_anggota WHERE id_sub = '$id_sub'";
                $result   = mysqli_query($koneksi, $query);
                $val      = mysqli_num_rows($result);

					     ?> 
					    	<tr>
					    		<td class="text-center"><?=$no;?></td>
					    		<td><?=$i["SUBJECT"];?></td>
					    		<td class="text-center"><?=$val;?></td>
					    		<td>
					    			 <a class="ubah btn btn-success btn-sm" href="ubahsubject.php?id_sub=<?=$i["id_sub"];?>"><i class="fa fa-edit"></i></a>
       								 <a class="hapus btn btn-danger btn-sm alert_hapus" href="hapus.php?id_sub=<?=$i["id_sub"];?>"><i class="fa fa-trash-alt"></i></a>
					    	    </td>
					    	</tr>
					     <?php 
					        $no++;
					        endforeach; 
					     ?>
					 </table> 
			  </div>		  
     
	</center>

<!-- Modal Tambah Subject -->
<div class="modal fade" id="tambahsubject" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-users"></i> TAMBAH SUBJECT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="subject.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" name="SUBJECT" type="text" autocomplete="off" placeholder="Masukkan Nama Subject yang Baru..." required>        
                    </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="kirimsubject" class="btn btn-success"><i class="fa fa-save"></i> Kirim</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


</body>
</html>
