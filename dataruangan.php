<?php 

require "template.php";

$dataruangan    = query("SELECT * FROM tabel_room ORDER BY id_room ASC");

if(isset($_POST["kirim"]))  {
    if( tambahruangan($_POST) > 0) {
            echo "
          <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Data ruangan Telah disimpan',
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
            text: 'Data ruangan gagal ditambahkan', 
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
		<h3 class="mb-4 mt-2">DATA RUANGAN</h3>

   				<div class="container table-responsive-sm">
					    <button type="button" class="btn btn-primary mb-2" href="#" data-toggle="modal"data-target="#tambahruangan"><i class="fa fa-plus"></i> Tambah Ruangan
					    </button>
          </div>
          <div class="table-responsive-sm">
  					<table class="table table-striped" style="width:22rem;">
					    	<tr class="text-white bg-dark">
					    		<th class="text-center">Kode</th>
					    		<th class="text-center">Nama Ruangan</th>
					    		<th class="text-center">Opsi</th>
					    	</tr>	
					     <?php 
					     $no = 1;
					     foreach ($dataruangan as $i) :?> 
					    	<tr>
					    		<td class="text-center"><?=$i["id_room"];?></td>
					    		<td><?=$i["room"];?></td>
					    		<td class="text-center">
                       <a class="ubah btn btn-warning btn-sm" href="hakakses.php?id_room=<?=$i["id_room"];?>"><i class="fa fa-user-lock" data-toggle="tooltip" data-placement="bottom" title="Hak Akses"></i></a>
					    			   <a class="ubah btn btn-success btn-sm" href="ubahruangan.php?id_room=<?=$i["id_room"];?>" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="fa fa-edit"></i></a>
       								 <a class="hapus btn btn-danger btn-sm alert_hapus" href="hapus.php?id_room=<?=$i["id_room"];?>" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash-alt"></i></a>
					    	    </td>
					    	</tr>
					     <?php endforeach; ?>
					 </table> 
			  </div>		  
     
	</center>

<!-- Modal Tambah Ruangan -->
<div class="modal fade" id="tambahruangan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">TAMBAH RUANGAN</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dataruangan.php" method="post">
         <div class="modal-body">
            <div class="form-group">
                <input class="form-control" name="id_room" type="text" autocomplete="off" placeholder="Masukkan Kode Ruangan" required>  
             </div>
             <div class="form-group">
                <input class="form-control" name="room" type="text" autocomplete="off" placeholder="Masukkan Nama Ruangan" required>  
             </div>    
      </div>
      <div class="modal-footer">
        <button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-save"></i> Kirim</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

</body>
</html>
