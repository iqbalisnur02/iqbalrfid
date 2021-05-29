<?php 

session_start();

//cek cookie
if(isset($_COOKIE['login'])){
  if ($_COOKIE['login'] == 'true'){
     $_SESSION['login'] = true;
  }
}

require 'koneksidb.php';

 $Token_bot = $pengaturan["TOKEN"];

  if(isset($_POST["login"])) {

    $Username = mysqli_escape_string($koneksi, $_POST["Username"]);
    $Password = mysqli_escape_string($koneksi, $_POST["Password"]);

    $result = mysqli_query($koneksi, "SELECT * FROM tabel_anggota WHERE ID = '$Username'");

    //cek username
    if (mysqli_num_rows($result) == 1) {

    //cek password
      $row = mysqli_fetch_assoc($result);

    if (password_verify($Password, $row["Password"])) {
      $_SESSION ["ID"] = $Username;

          //set session
         if($row["Level"] == "Admin"){
           $_SESSION["Level"] = "Admin";
           header("Location: dashboard.php");
           exit;
         }
         if($row["Level"] == "Anggota"){
           $_SESSION["Level"] = "Anggota";
           $_SESSION["Nama"]  = $row["NAMA"];
           header("Location: dashboard_2.php");
           exit;
         }
          
          //cek remember me
          if(isset($_POST["remember"])) {
            setcookie('login', 'true', time() + 60);
          }
      }
    }
      $error = true;
  }


if(isset($_POST["kirim"])){
  $id_card = mysqli_escape_string($koneksi, $_POST["id_card"]);
  $result  = mysqli_query($koneksi, "SELECT * FROM tabel_anggota WHERE ID = '$id_card'");
  $row     = mysqli_fetch_assoc($result); 

  if($row) {
      $pass_baru  = rand(100000, 999999);
      $pass_hash  = password_hash($pass_baru, PASSWORD_DEFAULT);
      $pesan      = "Password anda telah direset\n\nPassword: ".$pass_baru."\n\nSegera lakukan penggantian Password!";
      kirimpesan($row["ID_CHAT"], $pesan, $Token_bot);
        //update password
      $sql = "UPDATE tabel_anggota SET Password  = '$pass_hash' WHERE ID = '$id_card'";
      $koneksi->query($sql);

      $alert = ' 
            <div class="alert bg-primary alert-dismissible fade show text-center text-white" role="alert"> Akun telah direset
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div> 

           ';

    }
    else{
      $alert = ' 
            <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert"> ID User Tidak Dikenali!!!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div> 

           ';
    }
  }

  
 ?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

    <!-- Font Awesome -->
     <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->

    <title>Absensi Doorlock</title>
  </head>
  <body>

    <center>

    <!--  <img class="img-fluid responsive-sm mb-5 mt-4" src="img/png2.png" alt="Responsive image" style="width:350px; height:45px;"> -->

    <h2 class="mb-4 mt-4"> ABSENSI DOORLOCK PT.BUMI MENARA INTERNUSA </h2>


       
     
          <div class="card bg-dark text-white mb-3" style="max-width: 20rem;">
            <div class="card-body">
              <?php if(isset($error)) : ?>
                  <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert">
                    Cek Ulang Inputan Anda!!!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
              <?php endif;  ?>
               <?php 
                   if(isset($_POST["kirim"])) {
                      echo "$alert";
                   } 
              ?>
              <h5 class="card-title"><i class="fa fa-unlock-alt"></i> ABSENSI DOORLOCK</h5>
                 <form action="index.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="username" name="Username" class="form-control" placeholder="Username" autocomplete="off"><br>
                                <input type="password" name="Password" class="form-control" placeholder="Password"></i><br> 
                                <input type="checkbox" name="remember">
                                <label for="remember" class="mx-3">Ingat saya</label> 
                            </div>
                         </div>
                     <div class="modal-footer">
                        <button type="submit" name="login" class="btn btn-success btn-block"><i class="fa fa-sign-in-alt"></i> Login</button>
                        <button type="button" class="tambah btn btn-danger btn-block" href="#" data-toggle="modal"data-target="#resetakun"><i class="fa fa-sync-alt"></i> Reset Password</button>
                    </div>
                </form>
            </div>
          </div>
          

       <footer><strong>Copyright &copy;2021 Iqbal Project</strong></footer>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetakun" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fa fa-sync-alt"></i> RESET PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" name="id_card" type="text" autocomplete="off" placeholder="Masukkan ID Card">         
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


    

     </center>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

    <!-- My Javascript/jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.all.min.js"></script>


  </body>
</html>