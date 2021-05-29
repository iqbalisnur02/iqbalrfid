<?php 

require "koneksidb.php";

session_start();

if (!isset($_SESSION["Level"]) == "Admin") {
    header("Location:index.php");
    exit;
}
  

 ?>

 <!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>

  <div class="input-group">
      <div class="input-group-prepend">
       <span class="input-group-text" id="inputGroup-sizing-default">ID</span>
      </div>
        <input type="text" class="form-control text-center" name="ID" autocomplete="off" value=
          <?=

             $pengaturan["idbaru"];  
        
        ?>
        >
    </div>


    

 
 </body>
 </html>