<?php 

if (isset($_GET["Template"])) {
  require $_GET["Template"];
}
else{
  require "template_2.php";
}

if (isset($_GET["ID"])) {
  $ID  = mysqli_escape_string($koneksi, $_GET["ID"]);
  $form_permit = '';
}
else{
   $ID = $_SESSION["ID"];
   $form_permit = '
                    <button type="button" class="tambah btn btn-primary" href="#" data-toggle="modal"data-target="#tambahpermit" data-placement="bottom" title="Permit"><i class="fa fa-envelope"></i> </button>
                  ';
}


$TOKEN   = $pengaturan["TOKEN"];

if(isset($_GET["TANGGAL1"]) AND isset($_GET["TANGGAL2"])){
  $TANGGAL1  = $_GET["TANGGAL1"]; $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = $_GET["TANGGAL2"]; $waktu2 = $TANGGAL2." 23:59:59";
}
else{
  $TANGGAL1  = date("Y-m-d"); $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = date("Y-m-d"); $waktu2 = $TANGGAL2." 23:59:59";
}


  $data       = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
  $NAMA       = $data["NAMA"];
  $ID_CHAT    = $data["ID_CHAT"];
  $dataadmin  = query("SELECT * FROM tabel_anggota WHERE Level = 'Admin'")[0];
  $datapermit = query("SELECT * FROM tabel_permit WHERE ID = '$ID' AND waktu BETWEEN '$waktu1' AND '$waktu2' ORDER BY no DESC");


if(isset($_POST["kirim"]))  {
    if(tambahPermit($_POST) > 0 ) {
      if ($data["SW"] == 1) {
         $pesan = "Permit Anda berhasil diajukan dan sedang menunggu respon dari Admin";
         kirimPesan($ID_CHAT, $pesan, $TOKEN);
      }
      if ($dataadmin["SW"] == 1) {
         $pesan = "Anda menerima pengajuan permit baru yang menunggu respon\n\nID: ".$ID."\nNama: ".$NAMA;
         kirimPesan($dataadmin["ID_CHAT"], $pesan, $TOKEN);
      }
      
            echo "
                 <script> 
                  Swal.fire({ 
                  title: 'BERHASIL',
                  text: 'Permit Berhasil Diajukan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                      window.location.href='permit.php?ID=".$ID."&Template=template_2.php'; 
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
                window.location.href='permit.php?ID=".$ID."&Template=template_2.php'; 
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
 	<h3 class="mt-2">RIWAYAT PERMIT</h3>
  <p>Nama : <?=$NAMA;?> || ID : <?=$ID;?></p>
 	
  <div class="row mb-2" >
      <div class="col">
           <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" data-placement="bottom" title="Export"><i class="fa fa-download"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdfpermit.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
                  <a class="dropdown-item" href="excelpermit.php?ID=<?=$ID;?>&NAMA=<?=$NAMA;?>&TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-excel"></i> Excel</a>
              </div>
           </div>
       </div>
       <div class="col">
          <?=$form_permit; ?>
       </div>
       <div class="col">
          <button type="button" class="tambah btn btn-danger" href="#" data-toggle="modal" data-target="#filter" data-placement="bottom" title="Tanggal"><i class="fa fa-calendar"></i> </button>
      </div>
  </div>
 	

 	<div class="table-responsive-sm">
 		<table class="table table-bordered table-striped text-center" style="width:77rem;">
 			<tr class="bg-dark text-white">
 				<th>No</th>
 				<th>Waktu</th>
        <th>Periode Permit</th>
        <th>Jenis</th>
 			  <th>Keterangan</th>
        <th>Dokumen</th>
        <th>Status</th>
 			</tr>
      <?php 
        $no = 1;
        foreach ($datapermit as $permit) :
            $tgl_awal  = date("d F Y", strtotime($permit["tgl_awal"]));
            $tgl_akhir = date("d F Y", strtotime($permit["tgl_akhir"]));
       ?>
       <tr>
          <td class="text-center"><?=$no;?></td> 
          <td class="text=center"><?=$permit["waktu"];?></td>
          <td class="text=center"><?=$tgl_awal." s/d ".$tgl_akhir?></td>
          <td class="text-center"><?=$permit["jenis"];?></td>
          <td><?=$permit["keterangan"];?></td>
          <?php 
          if ($permit["nama_file"] != "") {
            echo'<td><a href="download.php?nama_file='.$permit["nama_file"].'" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download</a></td>';
          }
          else{
            echo "<td class='text-center'>--No File--</td>";
          }

            if($permit["status"] == "accepted"){
              echo '<td class="text-center text-success"><i class="fa fa-check-circle"></i> Accepted</td>';
           }
           else if($permit["status"] == "rejected"){
              echo '<td class="text-center text-danger"><i class="fa fa-times-circle"></i> Rejected</td>';
           }
           else{
               echo '<td class="text-center text-warning"><i class="fa fa-hourglass-half"></i> Awaiting</td>';
           }

           ?>
       </tr>
      <?php 
        $no++;
        endforeach;
      ?>
 		</table>
 	</div>
 </center>

 <!-- Modal Filter Tanggal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-calendar"></i> FILTER TANGGAL</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="get" action="permit.php">
        <div class="modal-body">
          <input type="text" name="ID" value="<?=$ID;?>" hidden>
          <span>Tanggal Awal</span>
          <input type="date" name="TANGGAL1"><br><br>
          <span>Tanggal Akhir</span>
          <input type="date" name="TANGGAL2">
          <input type="text" name="Template" value="<?=$_GET['Template'];?>" hidden>
        </div>
      <div class="modal-footer">
        <button type="submit" value="Filter" class="btn btn-success"><i class="fa fa-filter"></i> Filter </button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Permit -->
<div class="modal fade" id="tambahpermit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-envelope"></i> AJUKAN PERMIT BARU</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="permit.php" method="post" enctype="multipart/form-data">
         <div class="modal-body mx-2">
              <div class="form-group row">
                <input type="text" name="ID" value="<?=$ID;?>" hidden>
                <input type="text" name="NAMA" value="<?=$NAMA;?>" hidden>
                <label class="col-sm-3 col-form-label">Awal Permit</label>
                <div class="col">
                  <input type="date" name = "tgl_awal" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Akhir Permit</label>
                <div class="col">
                  <input type="date" name = "tgl_akhir" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Jenis Permit</label>
                 <div class="col">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="jenis" value="SAKIT" required>
                      <label class="form-check-label">Sakit</label>
                    </div>
                  </div>
                  <div class="col">
                     <div class="form-check">
                     <input class="form-check-input" type="radio" name="jenis" value="IZIN" required>
                      <label class="form-check-label">Izin</label>
                     </div>
                 </div>
             </div>  
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Keterangan</label>
                <div class="col">
                  <textarea type="text" name = "keterangan" class="form-control"  autocomplete="off" placeholder="Masukkan Keterangan Permit..." required></textarea>
                </div>
              </div>   
              <div class="form-group row">
               <label class="col-sm-3 col-form-label">Unggah File</label>
                  <div class="col">
                       <input type="file" name="file">
                       <label class="text-danger" style="font-style: italic; font-size: 13px;">(Ekstensi file yang diperbolehkan PDF, JPG, PNG)</label>
                  </div>
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