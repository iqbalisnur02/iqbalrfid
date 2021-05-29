<?php

		  require "template.php";

      $TOKEN = $pengaturan["TOKEN"];

	  
	if(isset($_POST["simpan"]) ) {
	   if( ubahanggota($_POST) > 0 ) {
      $id_sub  = $_POST["id_sub"];
      $datasub = query("SELECT * FROM tabel_subject WHERE id_sub = '$id_sub'")[0];
      $pesan="Data Diri Anda Telah diperbarui\n\nNama: ".$_POST["NAMA"]."\nNo. Induk: ".$_POST["NO_INDUK"]."\nGender: ".$_POST["KELAMIN"]."\nSubject: ".$datasub["SUBJECT"]."\nShift: ".$_POST["id_shift"]."\n\nData diperbarui pada: \n".date("d F Y H:i:s")."\n\nSegera laporkan ke admin jika terjadi kesalahan input data. Terimakasih";
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Perubahan data telah disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='dataanggota.php'; 
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
                window.location.href='dataanggota.php'; 
            }); 
         </script>
        ";
	   }
     if($pengaturan["SW"] == 1){
        kirimpesan($_POST["ID_CHAT"], $pesan, $TOKEN);
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
		<h3 class="mb-4 mt-2">UBAH DATA ANGGOTA</h3>

    
    <?php 
        if(isset($_GET["ID"])){
      $ID       = mysqli_escape_string($koneksi, $_GET["ID"]);
      $data     = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
      $subject  = query("SELECT * FROM tabel_subject");
      $shift    = query("SELECT * FROM tabel_shift");
     ?>
			
    <div class="card" style="width: 22rem;">
      <div class="card-body bg-dark text-white">
        <h5 class="card-title">ID Card: <?=$data["ID"];?></h5>
          <form action="ubahanggota.php" method="post">
                    <div class="form-group">
                      <input type="text" name="ID"  class="form-control bg-dark text-white" value="<?=$data["ID"];?>" hidden ><br>
                      <input type="text" name="ID_CHAT"  class="form-control bg-dark text-white" placeholder="Masukkan ID Chat...." autocomplete="off" value="<?=$data["ID_CHAT"];?>" ><br>
                      <input type="text" name="NO_INDUK"  class="form-control bg-dark text-white" placeholder="Masukkan NIS...." autocomplete="off" value="<?=$data["NO_INDUK"];?>" ><br>
                      <input type="text" name="NAMA"  class="form-control bg-dark text-white" placeholder="Masukkan Nama...." autocomplete="off" value="<?=$data["NAMA"];?>" ><br>

                      <div class="row">
                        <?php if($data["KELAMIN"] == "L") {
                            echo '
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="KELAMIN" value="L" checked="checked">
                                        <label class="form-check-label">Laki laki</label>
                                    </div>
                                  </div>
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="KELAMIN" value="P">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                  </div>
                                ';}

                                    else if($data["KELAMIN"] == "P") {
                            echo '
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="KELAMIN" value="L">
                                        <label class="form-check-label">Laki laki</label>
                                    </div>
                                  </div>
                                  <div class ="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="KELAMIN" value="P" checked="checked">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                  </div>
                                ';}
                        ?>
                       </div>

                      <br>

                       <div class="input-group">
                        <div class="input-group-prepend">
                        </div>
                           <select name="id_sub" class="custom-select col-md-7 bg-dark text-white">
                            <option>---Pilih Subject---</option>
                            <?php 
                              foreach ($subject as $i) {
                                  if ($data['id_sub'] == $i['id_sub']) {
                                     $select="selected";
                                   }
                                  else {
                                       $select="";
                                  }
                                  echo "<option value=".$i['id_sub']." $select>".$i['SUBJECT']."</option>"; 
                                }
                             ?>
                          </select>
                          <div class="input-group-prepend"></div>
                           <select name="id_shift" class="custom-select bg-dark text-white col-md-7"><
                            <option selected>---Pilih Shift---</option>
                              <?php 
                              foreach ($shift as $i) {
                                $masuk  = date("H:i:s", $i["JAM_MASUK_2"]);
                                $pulang = date("H:i:s", $i["JAM_PULANG_2"]);
                                  if ($data['id_shift'] == $i['id_shift']) {
                                     $select="selected";
                                   }
                                  else {
                                       $select="";
                                  }
                                  echo "<option value=".$i['id_shift']." $select>".$i['id_shift'].
                                " (".$masuk."-".$pulang.")</option>"; 
                                }
                             ?>
                            
                          </select>
                    </div><br>
                         <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                         <a href="dataanggota.php" name="batal" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a> 
                    </div>
                  </form>
      </div>
    </div>
  <?php   } ?>

 </center>
    
   

</body>
</html>


