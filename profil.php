<?php 	
	require "template_2.php";

  $Token_bot  = $pengaturan["TOKEN"];
  $ID         = $_SESSION['ID']; 
  $data       = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];

//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan admin
    if(aturAdmin($_POST) > 0) {
      $pesan = "Data ID Chat anda telah diubah\n\nID Chat: ".$_POST["ID_CHAT"];
      if($data["SW"] == 1){
         kirimpesan($_POST["ID_CHAT"], $pesan, $Token_bot);
      }
            echo "
        <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data ID Chat berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='profil.php'; 
                  }); 
			   </script>
                ";      
    }
    else {
      $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah ID Chat anda";
      if($data["SW"] == 1){
         kirimpesan($data["ID_CHAT"], $pesan, $Token_bot);
      }
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data ID Chat gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='profil.php'; 
		            }); 
		         </script>
		        ";
    }
 }  

 //Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["ubah"]))  { //pengaturan admin
    if(ubahPassword($_POST) > 0) {
      $pesan = "Password telah diperbarui\n\nPassword: ".$_POST['passbaru'];                  
            echo "
                 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Password telah berhasil diubah',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='profil.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
        $pesan = "PERINGATAN!!!\n\nAda yang berusaha mengubah password anda";
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Password telah gagal diubah!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='profil.php'; 
		            }); 
		         </script>
		        ";
    }
      if($data["SW"] == 1){
         kirimpesan($data["ID_CHAT"], $pesan, $Token_bot);
      }
 }

 //Proses status Telegram User/Member
 if(isset($_GET["state"])){
    $state = $_GET['state'];
    $sql    = "UPDATE tabel_anggota SET SW = '$state' WHERE ID = '$ID'";
    $koneksi->query($sql);
       if($state == 1){
         $val = "ON";
       }
       else{
         $val = "OFF";
       }
     $pesan = "Notifikasi Telegram: ".$val;
     kirimpesan($data["ID_CHAT"], $pesan, $Token_bot);
 }
  

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3>PROFIL</h3>


  <div class="card mt-4" style="width:23rem;">
    <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                  <th><i class="fa fa-id-card"></i> ID Card</th>
                  <td><?=$data["ID"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-comment"></i> ID Chat</th>
                  <td><?=$data["ID_CHAT"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-user"></i> Nama</th>
                  <td><?=$data["NAMA"];?></td>
                </tr>
                <tr>
                  <th><i class="fa fa-venus-mars"></i> Gender</th>
                  <?php   
                      if ($data["KELAMIN"] == "L") {
                        echo '<td>Laki Laki</td>';
                      }
                      if ( $data["KELAMIN"] == "P") {
                         echo '<td>Perempuan</td>';
                      }
                   ?>
                </tr>
                <tr>
                 <th><i class="fa fa-user-tie"></i> Subject</th>
                    <?php 
                      $id_sub  = $data["id_sub"];
                      $datasub = query("SELECT * FROM tabel_subject WHERE id_sub = '$id_sub'")[0];
                      echo "<td>".$datasub["SUBJECT"]."</td>";
                     ?>
                </tr>
                <tr>
                  <th><i class="fa fa-bell"></i> Notifikasi</th>
                  <?php if($data["SW"] == 0) {
                         echo '<td><input type="checkbox" onchange="dataMember(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger"></td>';
                       }
                        else{ 
                          echo '<td><input type="checkbox" checked onchange="dataMember(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger"></td>';
                       } 
                   ?> 
                </tr>
            </table>
          <button type="button" class="btn btn-block btn-success" href="#ubahPassword" data-toggle="modal"data-target="#ubahPassword"><i class="fa fa-key"></i> Ubah Password</button>
          <button type="button" class="btn btn-block btn-warning" href="#ubahIdchat" data-toggle="modal"data-target="#ubahIDchat"><i class="fa fa-comment"></i> Ubah ID Chat</button> 
        </div>
    </div>
  </div>


 	</center>

  <!-- Modal Atur Password -->
<div class="modal fade" id="ubahPassword" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-key"></i> UBAH PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="profil.php" method="post">
      <div class="modal-body">
             <div class="form-group">
                <div class="input-group mb-3">
                    <input class="form-control" name="passlama" type="password" autocomplete="off" placeholder="Masukkan Password Lama">
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" name="passbaru" type="password" autocomplete="off" placeholder="Masukkan Password Baru">
                </div>
                <div class="input-group mb-3">
                    <input class="form-control" name="passbaru2" type="password" autocomplete="off" placeholder="Konfirmasi Password Baru">
                </div>
                    <input type="text" name="ID" value="<?=$ID;?>" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="ubah" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


 	<!-- Modal Ubah ID Chat -->
<div class="modal fade" id="ubahIDchat" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-comment"></i> UBAH ID CHAT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="profil.php" method="post">
         <div class="modal-body">
             <div class="form-group">
                <div class="input-group mb-3">
				            <input class="form-control" name="ID_CHAT" type="text" autocomplete="off" placeholder="Masukkan ID Chat Baru">
				        </div>
				        <div class="input-group mb-3">
				            <input class="form-control" name="Password" type="password" autocomplete="off" placeholder="Masukkan Password Anda">
				        </div>
                    <input type="text" name="ID" value="<?=$ID;?>" hidden>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

 <script>
          //send data
              function dataMember(e){
              var xhr = new XMLHttpRequest();
                  if(e.checked){
                    xhr.open("GET", "profil.php?state= 1", true);
                  }
                  else{
                    xhr.open("GET", "profil.php?state= 0", true);
                  }
                xhr.send();
              }
  </script>

 </body>
 </html>