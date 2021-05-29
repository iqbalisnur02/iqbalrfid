<?php 	
	require "template.php";

  $ID      = $_SESSION["ID"];
  $TOKEN   = $pengaturan["TOKEN"];
  $data    = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];

	//Cek tombol simpan apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan token
    if(aturToken($_POST) > 0) {
        $pesan = "Data telah diperbarui\n\nToken Bot: ".$_POST["TOKEN"]."\nKey API: ".$_POST["KEY_API"];
            echo "
           <script>
				        Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data telah berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturtoken.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
      $pesan = "Data Token Bot/Key API gagal diperbarui";
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data telah gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='aturtoken.php'; 
		            }); 
		         </script>
		        ";
    }
     if($data["SW"] == 1){
         kirimpesan($data["ID_CHAT"], $pesan, $_POST["TOKEN"]);
      }
 }  
 
 //Proses status Telegram User
 if(isset($_GET["state_1"])){
 	$state1 = $_GET['state_1'];
  $sql = "UPDATE tabel_pengaturan SET SW = '$state1'";
 	$koneksi->query($sql);
   if($state1 == 1){
    $val = "ON";
   }
   else{
     $val = "OFF";
   }
    if($pengaturan["SW_2"]){
      $pesan = "Notifikasi User: ".$val;
      kirimpesan($ID_CHAT, $pesan, $TOKEN);
    }
 }
 //Proses status Telegram Admin
 if(isset($_GET["state_2"])){
  $state2 = $_GET['state_2'];
  $sql    = "UPDATE tabel_pengaturan SET SW_2 = '$state2'";
  $koneksi->query($sql);
   if($state2 == 1){
    $val = "ON";
   }
   else{
     $val = "OFF";
   }
      $pesan = "Notifikasi Admin: ".$val;
      kirimpesan($ID_CHAT, $pesan, $TOKEN);
 }


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3 class="mb-4 mt-2">AUTENTIKASI</h3>

 	
 		<form method="post" action="aturtoken.php">	
 		  <div class="table-responsive-sm">
             <table class="table" style="width: 40rem;">
             	<tr class="bg-dark text-white">
             		<th class="text-center">Variabel</th>
             		<th class="text-center">Autentikasi</th>
             		<!-- <th class="text-center" colspan="2">Notifikasi</th> -->
             	</tr>
             	<tr>
             		<td>Telegram</td>
             		<td><input type="text" class="form-control"name = "TOKEN" autocomplete="off" value="<?=$pengaturan["TOKEN"]?>"></td>
             		<!-- <td class="text-center">
             			<?php if($pengaturan["SW"] == 0) {
                         echo '<input type="checkbox" onchange="dataUser(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger">';
                       }
                        else{ 
                          echo '<input type="checkbox" checked onchange="dataUser(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger">';
                       } 
                      ?> User
             		</td>
                <td class="text-center">
                  <?php if($pengaturan["SW_2"] == 0) {
                         echo '<input type="checkbox" onchange="dataAdmin(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger">';
                       }
                        else{ 
                          echo '<input type="checkbox" checked onchange="dataAdmin(this)" data-toggle="toggle" data-onstyle="primary" data-offstyle="danger">';
                       } 
                      ?> Admin
                </td> -->
             	</tr>
             	<tr>
             		<td>Web</td>
             		<td><input type="text" class="form-control"name = "KEY_API" autocomplete="off" value="<?=$pengaturan["KEY_API"]?>"></td>
             		<!-- <td class="text-center" colspan="2">---</td> -->
             	</tr>
              <tr>
                <td>Password</td>
                <td><input type="password" class="form-control"name = "Password" autocomplete="off" placeholder="Masukkan Password" required></td>
              </tr>
             </table>
          </div>
				       <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
               <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button>
          </form>
		   

 	</center>

   <script>
          //send data
           function dataUser(e){
              var xhr = new XMLHttpRequest();
                  if(e.checked){
                    xhr.open("GET", "aturtoken.php?state_1= 1", true);
                  }
                  else{
                    xhr.open("GET", "aturtoken.php?state_1= 0", true);
                  }
                xhr.send();
              }
              function dataAdmin(e){
              var xhr = new XMLHttpRequest();
                  if(e.checked){
                    xhr.open("GET", "aturtoken.php?state_2= 1", true);
                  }
                  else{
                    xhr.open("GET", "aturtoken.php?state_2= 0", true);
                  }
                xhr.send();
              }
      </script>


 </body>
 </html>