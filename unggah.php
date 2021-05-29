<?php 
   require "template.php";
   $TOKEN = $pengaturan["TOKEN"];

   if (isset($_POST["upload"])) {
       // var_dump($_FILES["file"]);
   	    $file_tmp   = $_FILES['file']['tmp_name'];
   	    $nama       = $_FILES['file']['name'];

   	    move_uploaded_file($file_tmp, "dokumen/".$nama);

   	    $pesan = "http://192.168.1.8/rizkyprojects/absenrfiddoorlock/dokumen/".$nama;

       kirimPesan("441884684", $nama, $TOKEN);
   }

 

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
     <center>
     	 <form method="post" action = "unggah.php" enctype="multipart/form-data">
     	 	  <input type="file" name="file">
     	 	  <button type="submit" name="upload">Upload</button>
     	 </form>
     	  
     </center>
 </body>
 </html>