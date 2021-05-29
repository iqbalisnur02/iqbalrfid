<?php 

require "template.php";

$TOKEN = $pengaturan["TOKEN"];

if(isset($_GET["TANGGAL1"]) AND isset($_GET["TANGGAL2"])){
  $TANGGAL1  = mysqli_escape_string($koneksi, $_GET["TANGGAL1"]); $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = mysqli_escape_string($koneksi, $_GET["TANGGAL2"]); $waktu2 = $TANGGAL2." 23:59:59";
}
else{
  $TANGGAL1  = date("Y-m-d"); $waktu1 = $TANGGAL1." 00:00:00";
  $TANGGAL2  = date("Y-m-d"); $waktu2 = $TANGGAL2." 23:59:59";
}


$datapermit = query("SELECT * FROM tabel_permit WHERE waktu BETWEEN '$waktu1' AND '$waktu2' ORDER BY no DESC");

        if(isset($_GET["status"])){ 
          $status = $_GET["status"];
          $no     = $_GET ["no"];
          $tgl1   = $_GET["tgl1"];
          $tgl2   = $_GET["tgl2"];
          $permit = query("SELECT * FROM tabel_permit WHERE no = '$no'")[0];
          $ID     = $permit["ID"];
          $data   = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
          $ID_CHAT = $data["ID_CHAT"];
            if (ubahStatus($status, $no) > 0 ) {

              if ($data["SW"] == 1) {
                $pesan = "Respon Permit dari Admin\n\nWaktu Pengajuan: ".$permit["waktu"]."\nJenis Permit: ".$permit["jenis"]."\nAwal Permit: ".$permit["tgl_awal"]."\nAkhir Permit: ".$permit["tgl_akhir"]."\nStatus: ".$status;
                kirimPesan($ID_CHAT, $pesan, $TOKEN);
              }
             
                
              
                echo "
                   <script>
                         Swal.fire({ 
                            title: 'BERHASIL',
                            text: 'Permit Berhasil Diproses',
                            icon: 'success', buttons: [false, 'OK'], 
                            }).then(function() { 
                                window.location.href='inboxpermit.php?TANGGAL1=".$tgl1."&TANGGAL2=".$tgl2."'; 
                            });  
                   </script>
              ";
             }
             
             else {
               echo "
                    <script> 
                       Swal.fire({ 
                          title: 'OOPS', 
                          text: 'Permit Gagal Diproses!!!', 
                          icon: 'warning', 
                          dangerMode: true, 
                          buttons: [false, 'OK'], 
                          }).then(function() { 
                              window.location.href='inboxpermit.php?TANGGAL1=".$tgl1."&TANGGAL2=".$tgl2."'; 
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
  <h3 class="mt-2">INBOX PERMIT</h3>
  
  <div class="row mb-2" >
      <div class="col">
           <div class="dropdown">
              <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i> Export
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="pdfinboxpermit.php?TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
                  <a class="dropdown-item" href="excelinboxpermit.php?TANGGAL1=<?=$TANGGAL1;?>&TANGGAL2=<?=$TANGGAL2;?>"><i class="fa fa-file-excel"></i> Excel</a>
              </div>
            </div>
       </div>
       <div class="col">
          <button type="button" class="btn btn-danger" href="#filter" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i> Filter</button>
      </div>
  </div>
  

  <div class="table-responsive-sm">
    <table class="table table-bordered table-striped text-center" style="width:78rem;">
      <tr class="bg-dark text-white">
        <th>No</th>
        <th>Waktu</th>
        <th>Nama</th>
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
          <td><?=$permit["NAMA"];?></td>
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
           if ($permit["status"] == "awaiting") {
          ?>
            <td>  
                <a class="btn btn-success btn-sm" href="inboxpermit.php?no=<?=$permit["no"];?>&status=accepted&tgl1=<?=$TANGGAL1;?>&tgl2=<?=$TANGGAL2;?>"><i class="fa fa-check-circle"></i></a>
                <a class="btn btn-danger btn-sm" href="inboxpermit.php?no=<?=$permit["no"];?>&status=rejected&tgl1=<?=$TANGGAL1;?>&tgl2=<?=$TANGGAL2;?>"><i class="fa fa-times-circle"></i></a>  
            </td>
           <?php }
           else if($permit["status"] == "accepted"){
              echo '<td class="text-center text-success"><i class="fa fa-check-circle"></i> Accepted</td>';
           }
           else if($permit["status"] == "rejected"){
              echo '<td class="text-center text-danger"><i class="fa fa-times-circle"></i> Rejected</td>';
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
      <form method="get" action="inboxpermit.php">
        <div class="modal-body">
          <span>Tanggal Awal</span>
          <input type="date" name="TANGGAL1"><br><br>
          <span>Tanggal Akhir</span>
          <input type="date" name="TANGGAL2">
          <!-- -->
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




 </body>
 </html>