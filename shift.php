<?php 

require "template.php";

$shift    = query("SELECT * FROM tabel_shift");

if(isset($_POST["kirim"]))  {
    if(tambahShift($_POST) > 0) {
            echo "
          <script> 
			        Swal.fire({ 
			            title: 'BERHASIL',
			            text: 'Data Shift Telah disimpan',
			            icon: 'success', buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='shift.php'; 
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
                window.location.href='shift.php'; 
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
		<h3 class="mb-4 mt-2">DATA SHIFT </h3>
		
   				<div class="container">
					    <button type="button" class="btn btn-primary mb-2" href="#" data-toggle="modal"data-target="#tambahshift"><i class="fa fa-plus"></i> Tambah Shift
					    </button>
          </div>

          <div class="table-responsive-sm">
  					<table class="table table-striped" style="width:60rem;">
					    	<tr class="text-white text-center bg-dark">
					    		<th>Shift</th>
					    		<th>Awal Masuk</th>
                  <th>Jam Masuk</th>
                  <th>Akhir Masuk</th>
					    		<th>Awal Pulang</th>
                  <th>Jam Pulang</th>
                  <th>Akhir Pulang</th>
					    		<th>Opsi</th>
					    	</tr>	
					     <?php foreach ($shift as $i) : ?> 
					    	<tr>
					    		<td class="text-center"><?=$i["id_shift"];?></td>
					    		<td class="text-center"><?=$i["JAM_MASUK_1"];?></td>
                  <td class="text-center"><?=$i["JAM_MASUK_2"];?></td>
                  <td class="text-center"><?=$i["JAM_MASUK_3"];?></td>
                  <td class="text-center"><?=$i["JAM_PULANG_1"];?></td>
                  <td class="text-center"><?=$i["JAM_PULANG_2"];?></td>
                  <td class="text-center"><?=$i["JAM_PULANG_3"];?></td>
					    		<td>
					    			 <a class="ubah btn btn-success btn-sm" href="ubahshift.php?id_shift=<?=$i["id_shift"];?>" data-toggle="tooltip" data-placement="bottom" title="Ubah"><i class="fa fa-edit"></i></a>
       								 <a class="hapus btn btn-danger btn-sm alert_hapus" href="hapus.php?id_shift=<?=$i["id_shift"];?>" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="fa fa-trash-alt"></i></a>
					    	    </td>
					    	</tr>
					     <?php 
					        endforeach; 
					     ?>
					 </table> 
			  </div>		  
     
	</center>

<!-- Modal Tambah Subject -->
<div class="modal fade" id="tambahshift" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-plus"></i> TAMBAH SHIFT</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="shift.php" method="post">
         <div class="modal-body mx-5">
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Shift</label>
                <div class="col-sm-5">
                  <input type="number" name = "id_shift" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Awal Masuk</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_MASUK_1" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Jam Masuk</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_MASUK_2" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Akhir Masuk</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_MASUK_3" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Awal Pulang</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_PULANG_1" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Jam Pulang</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_PULANG_2" class="form-control">
                </div>
              </div> 
              <div class="form-group row">
                <label class="col-sm-5 col-form-label">Akhir Pulang</label>
                <div class="col-sm-5">
                  <input type="time" name = "JAM_PULANG_3" class="form-control">
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
