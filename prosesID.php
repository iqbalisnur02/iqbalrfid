<?php 

require "kehadiran-logic.php";

$today      = date("l");
$date       = date("Y-m-d");
$clock      = date("H:i:s");
$jam_array  = ["Jam" => $clock];


            if(isset($_GET["KEY_API"]) AND isset($_GET["ID"])) {
               //Tangkap data dari mikrokontroller
			   $KEY       = mysqli_escape_string($koneksi, $_GET["KEY_API"]);
			   $ID        = mysqli_escape_string($koneksi, $_GET["ID"]);
			   $Mode      = mysqli_escape_string($koneksi, $_GET["Mode"]);
			   $id_room   = mysqli_escape_string($koneksi, $_GET["room"]);
			   

               if (!isset(query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0])) {
               	 $sql = "UPDATE tabel_pengaturan SET idbaru = '$ID'";
			     $koneksi->query($sql);
               	 $data2 = ["ID" => $ID, "STAT" => "unregister"];
               	 $cetak = array_merge($data2, $jam_array);	
               	 $response = json_encode($cetak);
	             echo $response;
	             header("Location:tagID.php?unregister&ID=".$ID);
               	 die();
               }

               $data      = query("SELECT * FROM tabel_anggota WHERE ID = '$ID'")[0];
               $id_shift  = $data["id_shift"];
               $room      = query("SELECT * FROM tabel_room WHERE id_room = '$id_room'")[0];
               $datashift = query("SELECT * FROM tabel_shift WHERE id_shift = '$id_shift'")[0];
			   
			   

                 //Mode Absensi
				if($KEY == $pengaturan["KEY_API"] AND $ID == $data["ID"] AND $Mode == "Absensi" ){

			       $data2 = query("SELECT * FROM tabel_kehadiran WHERE TANGGAL ='$date' AND ID = '$ID'")[0];
			           
					
					//nomor urut baris data dalam tabel_kehadiran
					$no = $data2["no"];
					//variabel kirim pesan telegram
					$ID_CHAT = $data["ID_CHAT"];
					$TOKEN   = $pengaturan["TOKEN"];
					
					 //ID terdaftar dan tap masuk
					if($data2["CHECK_IN"] == 0 && $data2["CHECK_OUT"] == 0 ) {
					  $ket   = "HADIR";
						 // masuk
						 if ($data2["STAT"] == "masuk") { 
							$LATE_IN = 0;
							$stat    = "Masuk";
							tapMasuk($id_shift, $clock, $LATE_IN, $ket, $ID, $date); //update tabel_kehadiran
							 //Status Telegram ON
    						  if ($data["SW"] == 1) {
    						     $pesan = "Anda Telah Melakukan CHECK IN\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: ".$stat;
    							 kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
    						  }
						 }
						 //terlambat
						 if ($data2["STAT"] == "terlambat") { 
							 $LATE_IN   = time() - strtotime($datashift["JAM_MASUK_2"]);
							 $stat      = "TERLAMBAT";
							 tapMasuk($id_shift, $clock, $LATE_IN, $ket, $ID, $date); //update tabel_kehadiran
							  //Status Telegram ON
    						  if ($data["SW"] == 1) {
    						     $pesan = "Anda Telah Melakukan CHECK IN\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: ".$stat;
    							 kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
    						  }
						  } 
						 
						header("Location:tagID.php?masuk&NAMA=".$data["NAMA"]); 
					}

					//ID terdaftar dan Tap Pulang
					if($data2["CHECK_IN"] != 0 && $data2["CHECK_OUT"] == 0) {
					  $ket   = "HADIR";
						 // Pulang cepat
						 if ($data2["STAT"] == "pulang cepat") { 
							$EARLY_OUT = strtotime($datashift["JAM_PULANG_2"]) - time();
							$stat      = "PULANG CEPAT";
							tapPulang($clock, $EARLY_OUT, $ID, $date); //update data tabel_kehadiran
							 //Status Telegram ON
    						  if ($data["SW"] == 1) {
    						     $pesan = "Anda Telah Melakukan CHECK OUT\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: ".$stat;
    							 kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
    						  }
						 }
						 //pulang
						 if ($data2["STAT"] == "pulang") { 
							 $EARLY_OUT = 0;
							 $stat      = "Pulang";
							 tapPulang($clock, $EARLY_OUT, $ID, $date); //update data tabel_kehadiran
							  //Status Telegram ON
    						  if ($data["SW"] == 1) {
    						     $pesan = "Anda Telah Melakukan CHECK OUT\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: ".$stat;
    							 kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
    						  }
						  } 
						header("Location:tagID.php?pulang&NAMA=".$data["NAMA"]); 
					}
					//locked
					if($data2["STAT"] == "locked" OR $data2["STAT"] == "kepagian" OR 
					   $data2["STAT"] == "double tap in"){
					   header("Location:tagID.php?reject");
					}
					if($data2["KET"] == "ALFA" OR $data2["STAT"] == "alfa"){
						$stat  = $data2["KET"];
						if($data["SW"] == 1){
	                        $pesan = "Mohon Maaf CHECK IN anda DITOLAK!!!\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: Alfa";
						    kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
						 }
						header("Location:tagID.php?reject");
					}
					if($data2["KET"] == "BOLOS" OR $data2["STAT"] == "bolos"){
						$stat  = $data2["KET"];
						if($data["SW"] == 1){
	                        $pesan = "Mohon Maaf CHECK OUT anda DITOLAK!!!\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: Bolos";
						    kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
						 }
						header("Location:tagID.php?reject");
					}
					if($data2["KET"] == "LIBUR" OR $data2["STAT"] == "libur"){
						$stat  = $data2["KET"];
						if($data["SW"] == 1){
	                        $pesan = "Mohon Maaf CHECK IN anda DITOLAK!!!\n\nNama: ".$data["NAMA"]."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nStatus: ".$stat;
						    kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
						 }
						header("Location:tagID.php?reject");
					}
			}
			//Mode Doorlock
			else if($KEY == $pengaturan["KEY_API"] AND $ID == $data["ID"] AND $Mode == "Doorlock"){
				$ID_CHAT    = $data["ID_CHAT"];
			    $TOKEN      = $pengaturan["TOKEN"];
			    $NAMA       = $data["NAMA"];
			    $hakakses   = query("SELECT * FROM tabel_hak_akses WHERE id_room = '$id_room'");
			   
			    $akses = query("SELECT * FROM tabel_akses_2 WHERE ID = '$ID' ORDER BY no DESC")[0];
			    $no    = $akses["no"];

                foreach($hakakses as $hak){
	                if ($ID == $hak["ID"]) {
	                	if ($akses["MASUK"] == null OR $akses["KELUAR"] != 0) {
							tapIn($ID, $NAMA, $date, $clock, $id_room);
							$data2 = ["ID" => $ID, "NAMA" => $NAMA, "room" => $room["room"], "STAT" => "In"];
							$pesan = "Anda Telah Melakukan TAP MASUK RUANGAN\n\nNama: ".$NAMA."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nRuangan: ".$room["room"];
							break;
						}
						else if($akses["KELUAR"] == 0){
							tapOut($no, $clock);
							$data2 = ["ID" => $ID, "NAMA" => $NAMA, "room" => $room["room"], "STAT" => "Out"];
							$pesan = "Anda Telah Melakukan TAP KELUAR RUANGAN\n\nNama: ".$NAMA."\nNo. Induk: ".$data["NO_INDUK"]."\nTanggal: ".$date."\nJam: ".$clock."\nRuangan: ".$room["room"];
							break;
						}
	                }
	                else{
	                   $data2 = ["ID" => $ID, "NAMA" => $NAMA, "room" => $room["room"], "STAT" => "rejected"];
	                   $pesan = "Anda Tidak Memiliki Hak Akses ke ".$room["room"];
	                }
	            }
			   
				
				//Status Telegram ON
    			if ($data["SW"] == 1) {
    				kirimPesan($ID_CHAT, $pesan, $TOKEN);//kirim pesan via telegram
    			}
    			 //header("Location:dataakses.php");
			}
			
			else if($KEY != $pengaturan["KEY_API"]){
	           $data2 = ["Auth" => "Auth Rejected!!!"];
	           header("Location:tagID.php?reject");
	            }

            //penggabungan array
	            $cetak = array_merge($data2, $jam_array);	
	            //cetak data json ke browser
	            $response = json_encode($cetak);
	            echo $response;
                $koneksi->close();		
	}


	


 ?>