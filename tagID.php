<?php 	
	require "template.php";

  $date = date('Y-m-d');

       if(isset($_GET["reject"])){
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap ditolak!!!', 
                text: 'Silakan cek data ID anda!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='tagID.php'; 
                }); 
            </script>
              ";
    
      }

    if(isset($_GET["masuk"])){
         $NAMA = mysqli_escape_string($koneksi, $_GET["NAMA"]); 
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap Masuk Diterima', 
                text: '$NAMA', 
                icon: 'success', 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='kehadiran.php'; 
                }); 
            </script>
              ";
      }

      if(isset($_GET["pulang"])){
        $NAMA = $_GET["NAMA"];
         echo "
           <script> 
             Swal.fire({ 
                title: 'Tap Pulang Diterima', 
                text: '$NAMA', 
                icon: 'success', 
                buttons: [false, 'OK'], 
                }).then(function() { 
                   window.location.href='kehadiran.php'; 
                }); 
            </script>
              ";
      }

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
    <img class="img-fluid responsive-sm" src="img/rfid.jpg" alt="Responsive image" style="width:300px; height:180px;">
 		<h4>SILAKAN MASUKKAN ID ANDA</h4>

 	<div class="container my-5" style="width:20rem;">
 		<form method="get" action="prosesID.php">	
		 		<div class="form-group">
					<div class="input-group mb-3">
					  <div class="input-group-prepend"><span class="input-group-text">ID Card</span></div>
					  <input type="text" autocomplete="off" class="form-control"name = "ID" placeholder="Masukkan ID Anda" required>
					</div>
  		 		  <div class="input-group mb-3">
    					  <input type="text" class="form-control" name = "KEY_API" value="<?=$pengaturan["KEY_API"]?>"hidden>
                <input type="text" class="form-control" name = "Mode" value = "Doorlock" hidden>
                <input type="text" class="form-control" name = "room" value = "2" hidden>
  					</div>
		     </div>
				<button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-edit"></i> Submit</button>
        <button type="reset" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button> 
          </form>
          <br>
         <?php  
               if(isset($_GET["unregister"])){
                 $ID = $_GET["ID"];
                 echo ' 
                    <div class="alert alert-danger alert-dismissible fade show  role="alert">  
                        <p> ID Tidak Terdaftar!!!
                            <button type="button" class="tambah btn btn-sm btn-primary" href="#tambahanggota" data-toggle="modal"data-target="#tambahanggota"  data-placement="bottom" title="Registrasi"><i class="fa fa-user-plus"></i>
                            </button>
                        </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                    </div> 
                   ';
              }
          ?>
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


 </body>
 </html>