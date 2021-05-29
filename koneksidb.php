<?php

$server       = "localhost";
$user         = "root";
$password     = "";
$database     = "absensirfid"; //Silakan ganti dengan nama database anda


$koneksi      = mysqli_connect($server, $user, $password, $database);




//Query tabel
$libur      = query("SELECT * FROM tabel_hari_libur")[0];
$pengaturan = query("SELECT * FROM tabel_pengaturan")[0];

//Zona Waktu
$Zona = 'Asia/Makassar'; //Silakan disesuaikan dengan zona waktu wilayah masing-masing
date_default_timezone_set($Zona);

  if ($Zona == 'Asia/Jakarta') { //WIB
    $det = 25200; //7 jam 
  }
  else if ($Zona == 'Asia/Makassar') { //WITA
    $det = 28800; //8 jam 
  }
  else if ($Zona == 'Asia/Jayapura') { //WIT
    $det = 32400; //9 jam 
  }


function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query );
    $box = [];
    while( $siswa = mysqli_fetch_assoc($result) ){
    $box[] = $siswa;
    }
    return $box;
}


   function tambahanggota ($post) {
      global $koneksi;
      $ID       = htmlspecialchars($post ['ID']);
      $ID_CHAT  = htmlspecialchars($post ['ID_CHAT']);
      $NO_INDUK = htmlspecialchars($post ['NO_INDUK']);
      $NAMA     = htmlspecialchars($post ['NAMA']);
      $KELAMIN  = htmlspecialchars($post ['KELAMIN']);
      $id_sub   = htmlspecialchars($post ['id_sub']);
      $SW       = 1;
      $Password = password_hash($post ["ID"], PASSWORD_DEFAULT);
      $TERDAFTAR= date("Y-m-d");
      $Level    = "Anggota";
      $id_shift = htmlspecialchars($post ['id_shift']);

        //insert data ke tabel_anggota
      $query = "INSERT INTO tabel_anggota VALUES
               ('$ID', '$ID_CHAT', '$NO_INDUK', '$NAMA', '$KELAMIN', '$id_sub', '$SW', '$TERDAFTAR', '$Password', '$Level', '$id_shift')";  
             mysqli_query($koneksi, $query);
             return mysqli_affected_rows($koneksi);
    }

    function tambahkehadiran ($post) {
      global $koneksi;
      $ID       = $post ['ID'];
      $NO_INDUK = $post ['NO_INDUK'];
      $NAMA     = $post ['NAMA'];
      $TERDAFTAR= date("Y-m-d");
      $id_shift = $post ['id_shift'];

         //insert data ke tabel_kehadiran
          $query2 = "INSERT INTO tabel_kehadiran (ID, NO_INDUK, NAMA, TANGGAL, CHECK_IN, LATE_IN,  CHECK_OUT, EARLY_OUT, KET, STAT, id_shift)
                   VALUES
                  ('$ID', '$NO_INDUK', '$NAMA', '$TERDAFTAR', '', '', '', '', '', '', '$id_shift')
                  ";  

             mysqli_query($koneksi, $query2);
             return mysqli_affected_rows($koneksi);
    }

    function tambahsubject ($post) {
      global $koneksi;
      $SUBJECT  = htmlspecialchars($post ['SUBJECT']);
        //insert data ke tabel_subject
         $query = "INSERT INTO tabel_subject(SUBJECT) VALUES('$SUBJECT')";
         mysqli_query($koneksi, $query);
         return mysqli_affected_rows($koneksi);
    }

          function tambahShift ($post) {
              global $koneksi;
              $id_shift       = $post ['id_shift'];
              $JAM_MASUK_1    = $post ['JAM_MASUK_1'];
              $JAM_MASUK_2    = $post ['JAM_MASUK_2'];
              $JAM_MASUK_3    = $post ['JAM_MASUK_3'];
              $JAM_PULANG_1   = $post ['JAM_PULANG_1'];
              $JAM_PULANG_2   = $post ['JAM_PULANG_2'];
              $JAM_PULANG_3   = $post ['JAM_PULANG_3'];
             
                //insert data ke tabel_shift
                 $query = "INSERT INTO tabel_shift VALUES 
                    ('$id_shift',
                    '$JAM_MASUK_1',
                    '$JAM_MASUK_2',
                    '$JAM_MASUK_3',
                    '$JAM_PULANG_1',
                    '$JAM_PULANG_2',
                    '$JAM_PULANG_3')";  
             
                     mysqli_query($koneksi, $query);
                     return mysqli_affected_rows($koneksi);
            }

             function tambahhakakses ($post) {
                global $koneksi;
                $id_room  = htmlspecialchars($post ['id_room']);
                $ID       = htmlspecialchars($post ['ID']);
                $data     = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
                $dataroom = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'")[0];
                $NAMA     = $data["NAMA"];
                $room     = $dataroom["room"];
    
                     $query = "INSERT INTO tabel_hak_akses(ID, NAMA, id_room, room) 
                               VALUES('$ID', '$NAMA','$id_room', '$room')";
                     mysqli_query($koneksi, $query);
                     return mysqli_affected_rows($koneksi); 
            }

            function tambahPermit ($post) {
                global $koneksi;
                $waktu      = date("Y-m-d H:i:s", time());
                $ID         = $post["ID"];
                $Nama       = $post["NAMA"];
                $tgl_awal   = htmlspecialchars($post["tgl_awal"]);
                $tgl_akhir  = htmlspecialchars($post["tgl_akhir"]);
                $keterangan = htmlspecialchars($post["keterangan"]);
                $jenis      = htmlspecialchars($post["jenis"]);
                $status     = "awaiting";
                
                if($_FILES["file"]["name"] != ""){
                   //dokumen yang diunggah
                  $ekstensi   = array("pdf", "jpg", "png");
                  $nama_file  = $_FILES["file"]["name"];
                  $x          = explode(".", $nama_file);
                  $ext        = strtolower(end($x));
                  $size       = $_FILES['file']['size'];
                  $file_tmp   = $_FILES['file']['tmp_name'];

                  if(in_array($ext, $ekstensi) === true){   
                     move_uploaded_file($file_tmp, 'dokumen/'.$nama_file);
                     $query = "INSERT INTO tabel_permit (waktu, ID, NAMA, tgl_awal, tgl_akhir, keterangan, jenis, nama_file, status) VALUES 
                       ('$waktu','$ID', '$Nama','$tgl_awal', '$tgl_akhir', '$keterangan', '$jenis', '$nama_file', '$status')";
                  }  
                  else{
                    die(
                            "
                             <script> 
                             Swal.fire({ 
                                title: 'UPLOAD FILE GAGAL!!!', 
                                text: 'Ekstensi File Tidak didukung', 
                                icon: 'warning', 
                                dangerMode: true, 
                                buttons: [false, 'OK'], 
                                }).then(function() { 
                                    window.location.href='permit.php?ID=".$ID."&Template=template_2.php'; 
                                }); 
                             </script>
                            "
                       );
                  } 
                }
                else{
                    $query = "INSERT INTO tabel_permit (waktu, ID, NAMA, tgl_awal, tgl_akhir, keterangan, jenis, status) VALUES 
                     ('$waktu','$ID', '$Nama','$tgl_awal', '$tgl_akhir', '$keterangan', '$jenis', '$status')";
                }
                mysqli_query($koneksi, $query);
                return mysqli_affected_rows($koneksi);  
            }


    function ubahsubject ($post) {
      global $koneksi;
      $SUBJECT  = $post ['SUBJECT'];
      $id_sub   = $post ['id_sub'];

        //update data tabel_subject
         $query = "UPDATE tabel_subject SET SUBJECT = '$SUBJECT' WHERE id_sub = '$id_sub'";
         mysqli_query($koneksi, $query);
         return mysqli_affected_rows($koneksi);
    }

     function ubahStatus ($status, $no) {
         global $koneksi;
        //update data tabel_permit
         $query = "UPDATE tabel_permit SET status = '$status' WHERE no = $no";
         mysqli_query($koneksi, $query);
         return mysqli_affected_rows($koneksi);
    }

   

    function ubahanggota ($post) {
            global $koneksi;
            $ID          = $post ['ID'];
            $ID_CHAT     = $post ['ID_CHAT'];
            $NIS         = $post ['NO_INDUK'];
            $NAMA        = $post ['NAMA'];
            $KELAMIN     = $post ['KELAMIN'];
            $id_sub      = $post ['id_sub'];
            $id_shift    = $post ['id_shift'];

             //update data ke tabel_siswa
            $query = "UPDATE tabel_anggota SET
              
              ID_CHAT   = '$ID_CHAT',
              NO_INDUK  = '$NIS',
              NAMA      = '$NAMA',
              KELAMIN   = '$KELAMIN',
              id_sub    = '$id_sub',
              id_shift  = '$id_shift'
              WHERE ID  = '$ID'
                ";  
   
           mysqli_query($koneksi, $query);
           return mysqli_affected_rows($koneksi);

        }

        
          function ubahShift ($post) {
              global $koneksi;
              $id_shift       = $post ['id_shift'];
              $JAM_MASUK_1    = $post ['JAM_MASUK_1'];
              $JAM_MASUK_2    = $post ['JAM_MASUK_2'];
              $JAM_MASUK_3    = $post ['JAM_MASUK_3'];
              $JAM_PULANG_1   = $post ['JAM_PULANG_1'];
              $JAM_PULANG_2   = $post ['JAM_PULANG_2'];
              $JAM_PULANG_3   = $post ['JAM_PULANG_3'];
             
                //insert data ke tabel_shift
                 $query = "UPDATE tabel_shift SET 
                    JAM_MASUK_1  = '$JAM_MASUK_1',
                    JAM_MASUK_2  = '$JAM_MASUK_2',
                    JAM_MASUK_3  = '$JAM_MASUK_3',
                    JAM_PULANG_1 = '$JAM_PULANG_1',
                    JAM_PULANG_2 = '$JAM_PULANG_2',
                    JAM_PULANG_3 = '$JAM_PULANG_3'
                    WHERE id_shift  = '$id_shift';
                      ";  
             
                     mysqli_query($koneksi, $query);
                     return mysqli_affected_rows($koneksi);
            }

             
            function aturToken ($post) {
              global $koneksi;
              $TOKEN      = $post ['TOKEN'];
              $KEY_API    = $post ['KEY_API'];
              $password   =  query("SELECT * FROM tabel_anggota WHERE Level = 'Admin'")[0];
              $password_2 = mysqli_real_escape_string($koneksi, $post["Password"]);
              
               if(password_verify($password_2, $password["Password"])){
                   //update data ke tabel_pengaturan
                   $query = "UPDATE tabel_pengaturan SET TOKEN = '$TOKEN', KEY_API = '$KEY_API'";  
                   mysqli_query($koneksi, $query);
                   return mysqli_affected_rows($koneksi);
                }
            }

            function aturAdmin ($post) {
                global $koneksi;
                $ID         =  $post ["ID"];
                $anggota    =  query("SELECT * FROM tabel_anggota WHERE ID  = '$ID'")[0];
                $ID_CHAT    =  $post ["ID_CHAT"];
                $Password   =  mysqli_real_escape_string($koneksi, $post["Password"]);
              
                 //cek password
                 if(password_verify($Password, $anggota["Password"])){
                    $query = "UPDATE tabel_anggota SET ID_CHAT = '$ID_CHAT' 
                              WHERE ID  = '$ID'";
                    mysqli_query($koneksi, $query);
                    return mysqli_affected_rows($koneksi);
                  }
            }

            function ubahPassword ($post) {
                global $koneksi;
                $ID         =  $post ["ID"];
                $anggota    =  query("SELECT * FROM tabel_anggota WHERE ID  = '$ID'")[0];
                $passlama   =  mysqli_real_escape_string($koneksi, $post["passlama"]);
                $passbaru   =  mysqli_real_escape_string($koneksi, $post["passbaru"]);
                $passbaru2  =  mysqli_real_escape_string($koneksi, $post["passbaru2"]);

                 //cek password
                 if(password_verify($passlama, $anggota["Password"]) AND $passbaru == $passbaru2 ){
                    $password = password_hash($passbaru, PASSWORD_DEFAULT);//enkripsi password
                    //set password baru ke tabel_anggota
                    $query = "UPDATE tabel_anggota SET Password = '$password' 
                              WHERE ID = '$ID'";
                    mysqli_query($koneksi, $query);
                    return mysqli_affected_rows($koneksi);
                  }
            }

            function aturLibur ($post) {
              global $koneksi;
              $HL_1   = $post ['H_LIBUR_1'];    
              $HL_2   = $post ['H_LIBUR_2'];
              $TL_3   = $post ['T_LIBUR_3'];  
              $TL_4   = $post ['T_LIBUR_4'];  
              $TL_5   = $post ['T_LIBUR_5'];  
              $TL_6A  = $post ['T_LIBUR_6A'];  
              $TL_6B  = $post ['T_LIBUR_6B'];  
              $TL_7A  = $post ['T_LIBUR_7A'];  
              $TL_7B  = $post ['T_LIBUR_7B'];  
              
               
                //insert data ke tabel_hari_libur
                 $query = "UPDATE tabel_hari_libur SET 
                    H_LIBUR_1   = '$HL_1',  H_LIBUR_2   = '$HL_2',
                    T_LIBUR_3   = '$TL_3',  T_LIBUR_4   = '$TL_4',
                    T_LIBUR_5   = '$TL_5',  T_LIBUR_6A  = '$TL_6A',  T_LIBUR_6B   = '$TL_6B',
                    T_LIBUR_7A  = '$TL_7A', T_LIBUR_7B = '$TL_7B' 
                      ";  
             
                     mysqli_query($koneksi, $query);
                     return mysqli_affected_rows($koneksi);
            }

           
        function tapMasuk($id_shift, $clock, $LATE_IN, $ket, $ID, $date){
          global $koneksi;
          $sql     = "UPDATE tabel_kehadiran SET CHECK_IN = '$clock', LATE_IN = '$LATE_IN', KET = '$ket', id_shift = '$id_shift' WHERE ID = '$ID' AND TANGGAL = '$date'";
          $koneksi->query($sql);
          return;
        }

        function tapPulang($clock, $EARLY_OUT, $ID, $date){
          global $koneksi;
          $sql     = "UPDATE tabel_kehadiran SET CHECK_OUT = '$clock', EARLY_OUT = '$EARLY_OUT' WHERE ID = '$ID' AND TANGGAL = '$date'";
          $koneksi->query($sql);
          return;
        }

       
        function tapIn($ID, $NAMA, $date, $clock, $id_room){
          global $koneksi;
          $sql  = "INSERT INTO tabel_akses_2 (ID, NAMA, TANGGAL, MASUK, KELUAR, id_room) VALUES ('$ID', '$NAMA', '$date', '$clock', '', '$id_room')";
          $koneksi->query($sql);
          return;
        }

        function tapOut($no, $clock){
          global $koneksi;
          $sql     = "UPDATE tabel_akses_2 SET KELUAR = '$clock' WHERE no = '$no'";
          $koneksi->query($sql);
          return;
        }

        function tambahruangan ($post) {
          global $koneksi;
          $id_room  = htmlspecialchars($post ['id_room']);
          $room  = htmlspecialchars($post ['room']);
            //insert data ke tabel_room
             $query = "INSERT INTO tabel_room(id_room, room) VALUES('$id_room','$room')";
             mysqli_query($koneksi, $query);
             return mysqli_affected_rows($koneksi);
        }

         function ubahRuangan ($post) {
            global $koneksi;
            $id_room = $post ['id_room'];
            $room    = $post ['room'];

            //update data tabel_room
            $query = "UPDATE tabel_room SET room = '$room' WHERE id_room = '$id_room'";
            mysqli_query($koneksi, $query);
            return mysqli_affected_rows($koneksi);
          }

          function sendRequest ($post) {
            global $koneksi;
            $id_presensi = $post ['id_presensi'];
            $ID          = $post ['ID'];
            $request     = $post ['request'];
            $keterangan  = $post ['keterangan'];
            $tanggal     = $post ['TANGGAL'];
            $status      = "awaiting";

            //update data tabel_request
            $query = "INSERT INTO tabel_request(waktu, id_presensi, ID, request, keterangan, status) 
                      VALUES('$tanggal', '$id_presensi', '$ID', '$request', '$keterangan', '$status')";
            mysqli_query($koneksi, $query);
            return mysqli_affected_rows($koneksi);
          }


        function koreksikehadiran($post) {
          global $koneksi;
          $no          = $post ['no'];
          $LATE_IN     = $post ["LATE_IN"];  
          $EARLY_OUT   = $post ["EARLY_OUT"];
          $KET         = $post ['KET_2'];
          $data        = query("SELECT * FROM tabel_kehadiran WHERE no = '$no'")[0];

          //update data ke tabel_kehadiran
          $query = "UPDATE tabel_kehadiran SET 
                    LATE_IN   = '$LATE_IN',
                    EARLY_OUT = '$EARLY_OUT',
                    KET       = '$KET', 
                    STAT      = 'locked' 
                    WHERE  no = $no";  
          mysqli_query($koneksi, $query);
          return mysqli_affected_rows($koneksi);
        }

         function hapusRuangan ($id_room) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tabel_room WHERE id_room = '$id_room'");
            return mysqli_affected_rows($koneksi);
        }

        function hapusanggota ($ID ) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tabel_anggota WHERE ID = '$ID'");
            return mysqli_affected_rows($koneksi);
        }

        function hapussubject ($id_sub) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tabel_subject WHERE id_sub = '$id_sub'");
            return mysqli_affected_rows($koneksi);
        }

         function hapusShift ($id_shift) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tabel_shift WHERE id_shift = '$id_shift'");
            return mysqli_affected_rows($koneksi);
        }

        function hapusAkses ($no) {
            global $koneksi;
            mysqli_query($koneksi, "DELETE FROM tabel_hak_akses WHERE no = '$no'");
            return mysqli_affected_rows($koneksi);
        }

         function resetID($post){
            global $koneksi;
            $ID     = $post['ID'];
            $IDlama = $post['IDlama']; 
            // update data ke tabel_anggota
              $query = "UPDATE tabel_anggota SET ID = '$ID' WHERE ID  = '$IDlama'";
              mysqli_query($koneksi, $query);
              return mysqli_affected_rows($koneksi);
          }


        //function kirim pesan telegram
        function kirimPesan($ID_CHAT, $pesan, $TOKEN) {
          $url = "https://api.telegram.org/bot" . $TOKEN . "/sendMessage?parse_mode=markdown&chat_id=" . $ID_CHAT;
              $url = $url . "&text=" . urlencode($pesan);
              $ch = curl_init();
              $optArray = array(
                      CURLOPT_URL => $url,
                      CURLOPT_RETURNTRANSFER => true
              );
              curl_setopt_array($ch, $optArray);
              $result = curl_exec($ch);
              curl_close($ch);
          }

          //function kirim pesan telegram
        function kirimFoto($ID_CHAT, $pesan, $TOKEN) {
          $url = "https://api.telegram.org/bot" . $TOKEN . "/sendMessage?chat_id=" . $ID_CHAT;
              $url = $url . "&text=" . $pesan;
              $ch = curl_init();
              $optArray = array(
                      CURLOPT_URL => $url,
                      CURLOPT_RETURNTRANSFER => true
              );
              curl_setopt_array($ch, $optArray);
              $result = curl_exec($ch);
              curl_close($ch);
          }

 ?>