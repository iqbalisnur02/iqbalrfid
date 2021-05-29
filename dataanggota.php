<?php

require "template.php";

$data = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota' ORDER BY NAMA ASC"); 
$date = date('Y-m-d');

$TOKEN   = $pengaturan["TOKEN"];

//cek apakah kolom idbaru pada tabel pengaturan kosong atau tidak
if ($pengaturan["idbaru"] !== "") {
    $sql = "UPDATE tabel_pengaturan SET idbaru = ''";
    $koneksi->query($sql);
}

if(isset($_POST["simpan"]))  {
    if( tambahanggota($_POST) > 0 ) {
      //kirim pesan telegram
      $id_sub  = $_POST["id_sub"];
      $datasub = query("SELECT * FROM tabel_subject WHERE id_sub = '$id_sub'")[0];
      $ID_CHAT = $_POST["ID_CHAT"];
      $pesan="SELAMAT BERGABUNG!!!\nData Diri Anda Berhasil ditambahkan\n\nID: ".$_POST['ID']."\nNama: ".$_POST["NAMA"]."\nNo. Induk: ".$_POST["NO_INDUK"]."\nGender: ".$_POST["KELAMIN"]."\nSubject: ".$datasub["SUBJECT"]."\nPassword: ".$_POST["ID"]."\nShift: ".$_POST["id_shift"]."\n\nData ditambahkan pada: \n".date("d F Y H:i:s")."\n\nSegera laporkan ke admin jika terjadi kesalahan input data. Terimakasih";
      kirimpesan($ID_CHAT, $pesan, $TOKEN);
      //insert tabel_kehadiran
      tambahkehadiran($_POST);
            echo "
                 <script> 
                  Swal.fire({ 
                  title: 'BERHASIL',
                  text: 'Data Telah disimpan',
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
    <meta charset="utf-8">
    <title></title>
    

  </head>
<body>

<!--  -->
  <center>
    <h3 class="mb-4 mt-2">DATA ANGGOTA</h3>
    
 <div class="row table-responsive-sm">
    <div class="col mb-1">
      <div class="btn-group">
          <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal" data-placement="bottom" title="Registrasi" data-target="#tambahanggota"><i class="fa fa-user-plus"></i></button>
          <a href="subject.php" class="btn-warning btn mx-3" data-toggle="tooltip" data-placement="bottom" title="Subject"><i class="fa fa-users"></i></a>
          <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Export"><i class="fa fa-download"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                 <a class="dropdown-item" href="pdfanggota.php"><i class="fa fa-file-pdf"></i> PDF</a>
                 <a class="dropdown-item" href="excelanggota.php"><i class="fa fa-file-excel"></i> Excel</a>
              </div>
          </div>
      </div>
    </div>
    <div class="col mb-1">
          <div class="form-group" style="width:20rem;">
                <input class="form-control" id="keywordanggota" placeholder="Masukkan Keyword Pencarian" autocomplete="off"  type="text">
          </div>
    </div>
  </div>

<div id="tabelanggota">
<div class="table-responsive-sm">
<table class="table table-bordered table-hover table-striped" style="width:80rem;">
   <tr class="text-center bg-dark text-white"> 
   <th>No.</th>
   <th>ID Card</th>
   <th>ID Chat</th>
   <th>No. Induk</th>
   <th>Nama Anggota</th>
   <th width="10px">L/P</th>
   <th>Subject</th>
   <th>Shift</th>
   <th>Terdaftar</th>
   <th width="140px">Opsi</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $anggota) :
   $diff_tgl  = strtotime($anggota["TERDAFTAR"]);
   $terdaftar = date("d F Y", $diff_tgl);
   $id_sub    = $anggota["id_sub"];
   $datasub   = query("SELECT * FROM tabel_subject WHERE id_sub ='$id_sub' ");
?> 
   <tr>
   <td class="text-center"><?= $i; ?></td>
   <td class="text-center"><?= $anggota["ID"];?></td>
   <?php
      if ($anggota["ID_CHAT"] == "") {
        echo '<td class="text-center text-danger">--No ID Chat--</td>';
      }
      else{
        echo '<td class="text-center">'.$anggota["ID_CHAT"].'</td>';
      }  
    ?>
   <td class="text-center"><?= $anggota["NO_INDUK"];?></td>
   <td><?= $anggota["NAMA"];?></td>
   <td class="text-center"><?= $anggota["KELAMIN"];?></td>
   <?php
      if ($anggota["id_sub"] == 0) {
           echo '<td class="text-center text-danger">--No Subject--</td>';
         }
      else{
        foreach ($datasub as $subject){ 
            echo '<td class="text-center">'.$subject["SUBJECT"].'</td>';
         }
      }  
    ?>
   <td class="text-center"><?=$anggota["id_shift"];?></td>
   <td class="text-center"><?=$terdaftar;?></td>
   <td align="center">
      <div class="dropdown">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Opsi"><i class="fa fa-filter"></i></button>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="kehadiranperorang.php?ID=<?=$anggota["ID"]; ?>&NAMA=<?=$anggota["NAMA"];?>&ID_CHAT=<?=$anggota["ID_CHAT"];?>"><i class="fa fa-clipboard"></i> 
              Kehadiran</a>
            <a class="dropdown-item" href="aksesperorang.php?Template=template.php&ID=<?=$anggota["ID"]; ?>&NAMA=<?=$anggota["NAMA"];?>"><i class="fa fa-door-open"></i> 
              Akses</a>
              <a class="dropdown-item" href="permit.php?Template=template.php&ID=<?=$anggota["ID"];?>"><i class="fa fa-envelope"></i> 
              Permit</a>
            <a class="dropdown-item" href="ubahanggota.php?ID=<?=$anggota["ID"];?>"><i class="fa fa-edit"></i> Edit</a>
            <a class="dropdown-item alert_hapus" href="hapus.php?ID=<?=$anggota["ID"];?>&ID_CHAT=<?=$anggota["ID_CHAT"];?>"><i class="fa fa-trash-alt"></i> Hapus</a>
            <a class="dropdown-item reset btn btn-sm" href="resetid.php?ID=<?=$anggota["ID"];?>"><i class="fa fa-id-card"></i> Reset ID</a>   
          </div>
      </div>
    </td>
   </tr>
   <?php $i++; ?>
  <?php endforeach; ?>

</table>
</div>
</div>

</center>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="tambahanggota" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-user-plus"></i> FORM TAMBAH ANGGOTA</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="dataanggota.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                      <div class="idmasuk"></div><br>
                          <input class="form-control" name="ID_CHAT" type="text" autocomplete="off" placeholder="ID Chat Bot Telegram"><br>
                          <input class="form-control" name="NO_INDUK" type="text" autocomplete="off" placeholder="Nomor Induk Pegawai" required><br>
                          <input class="form-control" name="NAMA" type="text" autocomplete="off" placeholder="Nama Lengkap" required><br>

                          <div class="row px-5">
                            <div class="col">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="KELAMIN" value="L" required>
                                <label class="form-check-label">Laki laki</label>
                              </div>
                            </div>
                            <div class="col">
                               <div class="form-check">
                                  <input class="form-check-input" type="radio" name="KELAMIN" value="P" required>
                                  <label class="form-check-label">Perempuan</label>
                              </div>
                            </div>
                          </div>
                            
                    <br>
                    <div class="input-group">
                        <div class="input-group-prepend"></div>
                           <select name="id_sub" class="custom-select col-md-5"><
                            <option selected>---Pilih Subject---</option>

                            <?php
                             $subject = query("SELECT * FROM tabel_subject");
                             foreach ($subject as $i) {
                                echo "<option value=".$i['id_sub'].">".$i['SUBJECT']."</option>"; 
                            } ?> 

                          </select>
                        <div class="input-group-prepend"></div>
                           <select name="id_shift" class="custom-select col-md-5"><
                            <option selected>---Pilih Shift---</option>

                            <?php
                             $shift = query("SELECT * FROM tabel_shift");
                             foreach ($shift as $i) {
                               $masuk  = $i["JAM_MASUK_2"];
                               $pulang = $i["JAM_PULANG_2"];
                                echo "<option value=".$i['id_shift'].">".$i['id_shift'].
                                " (".$masuk."-".$pulang.")</option>"; 
                            } ?> 

                          </select>
                    </div>
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
        var keyword = document.getElementById('keywordanggota');
        var tabelanggota = document.getElementById('tabelanggota');
        
          keyword.addEventListener('keyup', function() {
              var xhr = new XMLHttpRequest();

              xhr.onreadystatechange = function() {
                  if(xhr.readyState == 4 && xhr.status == 200){
                   tabelanggota.innerHTML = xhr.responseText;
                  }
              }

              xhr.open('GET', 'js/tabelanggota.php?keywordanggota='+keyword.value, true);
              xhr.send();
          });
      </script>

</body>
</html> 
