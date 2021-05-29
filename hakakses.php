<?php 

require "template.php";
$TOKEN = $pengaturan["TOKEN"];

if(isset($_POST["kirim"]))  {
  $id_room  = $_POST["id_room"];
  $ID       = $_POST["ID"];
  $dataroom = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'")[0];
  $data     = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
  $room     = $dataroom["room"];
  $ID_CHAT  = $data["ID_CHAT"];
    if( tambahhakakses($_POST) > 0) {
        $pesan = "Anda telah diregistrasikan sebagai penerima akses di ".$room;
        kirimPesan($ID_CHAT, $pesan, $TOKEN);
    
            echo "
          <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Data hak akses telah disimpan',
			            icon: 'success', buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='hakakses.php?id_room=".$id_room."'; 
			            });  
				   </script>
                ";   
        }
                
   
    else {
      echo "
        <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'Data hak akses gagal ditambahkan', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='hakakses.php?id_room=".$_POST["id_room"]."'; 
            }); 
         </script>
        ";
    }
  }
   


 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>
		<h3 class="mt-2">DATA HAK AKSES</h3>

<?php if (isset($_GET["id_room"])): 
      $id_room       = $_GET["id_room"];
      $dataroom      = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'")[0];
      $datahakakses  = query("SELECT * FROM tabel_hak_akses WHERE id_room = '$id_room'");
?>
  
    <p class="mb-4"><?=$dataroom["room"];?></p>

          <div class="container table-responsive-sm">
              <button type="button" class="btn btn-primary mb-2" href="#" data-toggle="modal"data-target="#tambahhakakses"><i class="fa fa-user-plus"></i> Hak Akses
              </button>
          </div>
          <div class="table-responsive-sm">
  					<table class="table table-striped" style="width:30rem;">
					    	<tr class="text-white bg-dark">
					    		<th class="text-center">No</th>
					    		<th class="text-center">ID</th>
                  <th>Nama</th>
					    		<th class="text-center">Opsi</th>
					    	</tr>	
    					     <?php 
      					     $no = 1;
      					     foreach ($datahakakses as $i) :
                    ?> 
					    	<tr>
                    <td class="text-center"><?=$no;?></td>
  					    		<td class="text-center"><?=$i["ID"];?></td>
  					    		<td><?=$i["NAMA"];?></td>
  					    		<td class="text-center">
         								 <a class="hapus btn btn-danger btn-sm alert_hapus" href="hapus.php?no=<?=$i["no"];?>&room=<?=$i["id_room"];?>" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash-alt"></i></a>
  					    	  </td>
					    	</tr>
					     <?php endforeach; ?>
					 </table> 
			  </div> 
     
	</center>

<!-- Modal Tambah Hak Akses -->
<div class="modal fade" id="tambahhakakses" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-user-plus"></i> TAMBAH HAK AKSES</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="hakakses.php" method="post">
         <div class="modal-body">
            <div class="input-group-prepend"></div>
              <select name="ID" class="custom-select"><
                  <option selected>---Pilih Nama Anggota---</option>
                    <?php
                      $anggota = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota'");
                      foreach ($anggota as $i) {
                          echo "<option value=".$i['ID'].">".$i['NAMA']; 
                      } 
                    ?> 
              </select>
             <input type="text" name="id_room" value="<?=$id_room;?>" hidden> 
      </div>
      <div class="modal-footer">
        <button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-save"></i> Kirim</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

<?php endif ?>    

</body>
</html>
