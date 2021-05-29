<?php

require "template.php"; 

 $TOKEN = $pengaturan["TOKEN"];


    if(isset($_GET["ID"])){    
        if( hapusanggota($_GET ["ID"]) > 0 ) {
              $pesan = "Data Diri anda telah dihapus!!!\nSilakan konfirmasi ke Admin";
              if($pengaturan["SW"] == 1){
                  kirimpesan($_GET["ID_CHAT"], $pesan, $TOKEN);
               }

              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Anggota Telah dihapus',
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
                      text: 'Data gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href=''; 
                      }); 
             </script>
           ";
        }
  }

  if(isset($_GET["id_sub"])){
    if (hapussubject($_GET["id_sub"]) > 0) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Subject Telah dihapus',
                          icon: 'success', buttons: [false, 'OK'], 
                          }).then(function() { 
                              window.location.href='subject.php'; 
                          });  
                 </script>
            ";
           }
      else {
           echo "
                <script> 
                   Swal.fire({ 
                      title: 'OOPS', 
                      text: 'Data gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href=''; 
                      }); 
             </script>
           ";
        }
  }

  if(isset($_GET["id_room"])){
    if (hapusRuangan($_GET["id_room"]) > 0) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Ruangan Telah dihapus',
                          icon: 'success', buttons: [false, 'OK'], 
                          }).then(function() { 
                              window.location.href='dataruangan.php'; 
                          });  
                 </script>
            ";
           }
      else {
           echo "
                <script> 
                   Swal.fire({ 
                      title: 'OOPS', 
                      text: 'Data ruangan gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href=''; 
                      }); 
             </script>
           ";
        }
  }

  if(isset($_GET["id_shift"])){
    if (hapusShift($_GET["id_shift"]) > 0) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Data Shift Telah dihapus',
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
                      text: 'Data Shift gagal dihapus', 
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
  if(isset($_GET["no"])){
    $room = $_GET["room"];
    if (hapusAkses($_GET["no"]) > 0) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'BERHASIL',
                          text: 'Hak Akses Telah dihapus',
                          icon: 'success', buttons: [false, 'OK'], 
                          }).then(function() { 
                              window.location.href='hakakses.php?id_room=".$room."'; 
                          });  
                 </script>
            ";
           }
      else {
           echo "
                <script> 
                   Swal.fire({ 
                      title: 'OOPS', 
                      text: 'Hak Akses Gagal dihapus', 
                      icon: 'warning', 
                      dangerMode: true, 
                      buttons: [false, 'OK'], 
                      }).then(function() { 
                          window.location.href='hakakses.php?id_room=".$room."'; 
                      }); 
             </script>
           ";
        }
  }

$koneksi->close();

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>';



 ?>