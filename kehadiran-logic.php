<?php 
require "koneksidb.php";

//Variabel waktu
$libur      = query("SELECT * FROM tabel_hari_libur")[0];
$clock      = time(); //Jam Saat ini
$date       = date("Y-m-d"); //Tanggal hari ini
$today      = date("l"); //Nama hari ini


//token bot
$TOKEN = $pengaturan["TOKEN"];

//input data nama dari tabel_anggota
  $dataanggota   = query("SELECT * FROM tabel_anggota WHERE Level = 'Anggota'");
  $datakehadiran = query("SELECT * FROM tabel_kehadiran WHERE TANGGAL ='$date' ORDER BY NAMA ASC"); 
  foreach ($dataanggota as $anggota) {
    $ID        = $anggota["ID"];
    $NO_INDUK  = $anggota["NO_INDUK"];
    $NAMA      = $anggota["NAMA"];
    $id_shift  = $anggota["id_shift"];
    foreach ($datakehadiran as $kehadiran) {
      if ($anggota["ID"] == $kehadiran["ID"]) {
        break 2;
      }
    }
  $sql = "INSERT INTO tabel_kehadiran (ID, NO_INDUK, NAMA, TANGGAL,  CHECK_IN, LATE_IN, CHECK_OUT, EARLY_OUT, KET, STAT, id_shift) VALUES ('$ID', '$NO_INDUK', '$NAMA', '$date', '00:00:00', 0, '00:00:00', 0, '', '', '$id_shift')";
        $koneksi->query($sql);
  }

  //pengecekan hari libur
  if ($today == $libur["H_LIBUR_1"] OR $today == $libur["H_LIBUR_2"] OR 
      $date == $libur["T_LIBUR_3"] OR $date == $libur["T_LIBUR_4"] OR $date == $libur["T_LIBUR_5"] OR
      $date >= $libur["T_LIBUR_6A"] AND $date <= $libur["T_LIBUR_6B"] OR 
      $date >= $libur["T_LIBUR_7A"] AND $date <= $libur["T_LIBUR_7B"]){
         $sql = "UPDATE tabel_kehadiran SET CHECK_IN = '00:00:00', CHECK_OUT = '00:00:00', KET = 'LIBUR', STAT = 'libur' WHERE CHECK_IN = '00:00:00'";
      $koneksi->query($sql);
  }

  else{
    //Aturan Presensi/Absensi
      foreach ($dataanggota as $anggota) {
        $id_shift = $anggota["id_shift"];
        $datashift = query("SELECT * FROM tabel_shift WHERE id_shift = '$id_shift'");
        foreach ($datashift as $shift) {   
         $T  = time(); //jam saat ini dalam detik
         $M1 = strtotime($shift["JAM_MASUK_1"]);      $P1 = strtotime($shift["JAM_PULANG_1"]); 
         $M2 = strtotime($shift["JAM_MASUK_2"]);      $P2 = strtotime($shift["JAM_PULANG_2"]);
         $M3 = strtotime($shift["JAM_MASUK_3"]);      $P3 = strtotime($shift["JAM_PULANG_3"]);

         $state1 = query("SELECT * FROM tabel_kehadiran WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN = '00:00:00' AND CHECK_OUT = '00:00:00'");
         $state2 = query("SELECT * FROM tabel_kehadiran WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN !='00:00:00' AND CHECK_OUT = '00:00:00'");
         $state3 = query("SELECT * FROM tabel_kehadiran WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN !='00:00:00' AND CHECK_OUT !='00:00:00'");

         if($state1){
               if($T < $M1){
                  $STAT = "kepagian";
               }
               else if($M1 <= $T AND $T <= $M2){
                  $STAT = "masuk";
               }
               else if($M2 < $T AND $T <= $M3){
                  $STAT = "terlambat";
               }
               else if($M3 < $T){
                  $STAT = "alfa";
               }
           $sql = "UPDATE tabel_kehadiran SET STAT = '$STAT' WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN = '00:00:00' AND CHECK_OUT = '00:00:00' "; 
           $koneksi->query($sql);
         }

         if($state2){
               if($T < $P1){
                 $STAT = "double tap in";
               }
               else if($P1 <= $T AND $T < $P2){
                 $STAT = "pulang cepat";
               }
               else if($P2 <= $T AND $T <= $P3){
                 $STAT = "pulang";
               }
               else if($P3 < $T){
                 $STAT = "bolos";
               } 
             $sql = "UPDATE tabel_kehadiran SET STAT = '$STAT' WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN !='00:00:00' AND CHECK_OUT = '00:00:00'";
             $koneksi->query($sql);
         }

         if($state3){
               if($P1 <= $T){
                 $STAT = "locked";
                 $sql = "UPDATE tabel_kehadiran SET STAT = '$STAT' WHERE id_shift = '$id_shift' AND TANGGAL = '$date' AND CHECK_IN !='00:00:00' AND CHECK_OUT !='00:00:00'";
                 $koneksi->query($sql);
               } 
         }
        }
      }
  } 

 ?>