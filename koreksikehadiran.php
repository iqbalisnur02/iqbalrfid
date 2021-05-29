<?php

require "template.php";

$TOKEN = $pengaturan["TOKEN"];


	 if(isset($_POST["simpan"]) ) {
	   if(koreksikehadiran($_POST) > 0 ) {
       $pesan="Hai ".$_POST["NAMA"]."\n\nData presensi kamu pada Tanggal: \n".$_POST["TANGGAL"]." telah diperbaharui\n\nSilakan lakukan pengecekan ke akun anda. Terimakasih";
       if($pengaturan["SW"] == 1){
          kirimPesan($_POST["ID_CHAT"], $pesan, $TOKEN);
       }
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
	 }




?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>

     <?php 
      if(isset($_GET["no"])){
         $no      = $_GET["no"];
         $ID_CHAT = $_GET["ID_CHAT"];
         $data    = query("SELECT * FROM tabel_kehadiran WHERE no = '$no'")[0];

         $diff_tgl    = strtotime($data["TANGGAL"]);
         $tanggal     = date("d F Y", $diff_tgl);
    ?>

		<h3 class="text-center mt-2">KOREKSI KEHADIRAN</h3>
    <p class="mb-4">Nama: <?=$data["NAMA"];?> || ID: <?=$data["ID"];?></p>

    <div class="card" style="width: 22rem;">
      <div class="card-body">
          <form action="koreksikehadiran.php" method="post">
             <input class="form-control bg-dark text-white" name="no" type="text" autocomplete="off" value="<?=$data["no"]?>" hidden>
            <div class="table-responsive-sm">
             <table class="table table-striped">
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?=$tanggal?></td>
                <input type="text" name="NAMA" value="<?=$data["NAMA"];?>" hidden>
                <input type="text" name="TANGGAL" value="<?=$tanggal;?>" hidden>
              </tr>
              <tr>
                <td>Late In</td>
                <td>:</td>
                <td><input type="text" name="LATE_IN" value="<?=$data["LATE_IN"];?>" autocomplete = "off"></td>
              </tr>
              <tr>
                <td>Early Out</td>
                <td>:</td>
                <td><input type="text" name="EARLY_OUT" value="<?=$data["EARLY_OUT"];?>" autocomplete = "off"></td>
              </tr>
              <tr>
                <input type="text" name="KET_1" value="<?=$data["KET"];?>" hidden>
                <td>Keterangan</td>
                <td>:</td>
                <td><div class="input-group">

                  <?php 
                            $val   = $data["KET"];
                            $hadir = "";
                            $sakit = "";
                            $izin  = "";
                            $alfa  = "";
                            $bolos = "";
                            $lupa  = "";
                            $libur = "";

                      switch ($val) {
                        case 'HADIR':
                            $hadir = "selected";
                          break;

                          case 'SAKIT':
                            $sakit = "selected";
                          break;

                          case 'IZIN':
                            $izin = "selected";
                          break;

                          case 'ALFA':
                            $alfa = "selected";
                          break;

                          case 'BOLOS':
                            $bolos = "selected";
                          break;

                          case 'LUPA':
                            $lupa = "selected";
                          break;

                          case 'LIBUR':
                            $libur = "selected";
                          break;
                      }
                   ?>
                        <div class="input-group-prepend"></div>
                           <select name="KET_2" class="custom-select">
                            <option>---Pilih Keterangan---</option>
                            <option <?=$hadir;?> value="HADIR">Hadir</option>
                            <option <?=$sakit;?> value="SAKIT">Sakit</option>
                            <option <?=$izin;?> value="IZIN">Izin</option>
                            <option <?=$alfa;?> value="ALFA">Alfa</option>
                            <option <?=$bolos;?> value="BOLOS">Bolos</option>
                            <option <?=$lupa;?> value="LUPA">Lupa</option>
                            <option <?=$libur;?> value="LIBUR">Libur</option>
                          </select>
                    </div>
                    <input type="text" name="ID_CHAT" value="<?=$ID_CHAT;?>" hidden>
                </td>
              </tr>
             </table>
            </div>  
              <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
              <a href="dataanggota.php"  name="batal" class="btn btn-danger"><i class="fa fa-undo"></i> Batal</a>       
          </form>
      </div>
    </div>
<?php } ?>
 
             
 </center>
    
   

</body>
</html>