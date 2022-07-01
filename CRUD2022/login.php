<?php
   session_start();
   include "koneksi.php";
   


   if (isset($_POST['user'])) {
      
      $user = $_POST['user'];
      $password = $_POST['password'];
   }

   $data = mysqli_query($koneksi, "SELECT * FROM loginn WHERE user='$user' and password='$password'");  // Read data from database

   $cek = mysqli_num_rows($data);

   if ($cek > 0) {
      $_SESSION['user'] = $user;
      $_SESSION['status'] = "login";
      header("location:admin/index.php");
   } else {
      // header("location:login.php?pesan=gagal");
      header("location:index.php");
   }
?>