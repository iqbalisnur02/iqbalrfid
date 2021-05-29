<?php
	if(isset($_REQUEST['nama_file'])){
	 $nama_file = $_REQUEST['nama_file'];
	 
	  //header("Cache-Control: public");
	  //header("Content-Description: File Transfer");
	 header("Content-Disposition: attachment; filename=".basename($nama_file));
	 header("Content-Type: application/octet-stream;");
	  //header("Content-Transfer-Encoding: binary");
	 readfile("dokumen/".$nama_file);
}
?> 