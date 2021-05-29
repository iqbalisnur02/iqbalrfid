<?php 
session_start();

require "koneksidb.php";

$ID_CHAT = $pengaturan["ID_CHAT"];
$TOKEN   = $pengaturan["TOKEN"];
$pesan   = "Anda telah melakukan logout pada\nTanggal= ".date("d F Y")."\nPukul= ".date("H:i:s");

$_SESSION = [];
session_unset();

session_destroy();

setcookie('login', '', time() - 3600);

header("location: index.php");

if($pengaturan["SW_2"] == 1 ){
    kirimpesan($ID_CHAT, $pesan, $TOKEN);
}
exit;

 ?>