<?php

require "template.php";


if(isset($_POST["simpan"]) ) {
    
	if( resetID($_POST) > 0 ) {
      $pesan="ID anda telah direset menjadi ".$_POST["ID"];
       if ($_POST['SW'] == 1) {
        kirimPesan($_POST["ID_CHAT"], $pesan, $pengaturan["TOKEN"]);
      }
		echo "
			 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'ID Anggota berhasil direset',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='dataanggota.php'; 
                  }); 
			 </script>";
	   }
	   else {
	    echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS', 
            text: 'ID Anggota gagal direset', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='dataanggota.php'; 
            }); 
         </script>";
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
		<h3 class="text-center mb-4 mt-2">RESET ID ANGGOTA</h3>

    <?php 
        if(isset($_GET["ID"])){
            $ID   = mysqli_escape_string($koneksi, $_GET["ID"]);
            $data = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
     ?>
			
<div class="card" style="width: 23rem;">
  <div class="card-body">
        <form action="resetID.php" method="post">
          <div class="idmasuk"></div><br>
          <table class="table table-bordered table-striped">
              <tr>
                <th><i class="fa fa-id-card"></i> ID Card</th>
                <td><?=$data["ID"];?></td>
                <input type="text" name="IDlama" value="<?=$data["ID"];?>" hidden>
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
                      if ($data["KELAMIN"] = "L") {
                        echo "<td>Laki laki</td>";
                      }
                      else if ($data["KELAMIN"] = "P") {
                        echo "<td>Perempuan</td>";
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
              <input type="text" name="ID_CHAT" value="<?=$data["ID_CHAT"];?>" hidden>
              <input type="text" name="SW" value="<?=$data["SW"];?>" hidden>
          </table>
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


