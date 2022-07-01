<?php
    //Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "crud_db";

    $koneksi = mysqli_connect($server,$user, $pass, $database)or die(mysqli_error($koneksi));

    //If Button Save Clicked
    if(isset($_POST['bsimpan']))
    {
        //Test if the data is edited or saved
        if($_GET['hal'] == "edit")
        {
        	//Data edited
        	$edit = mysqli_query($koneksi, " UPDATE tkyr set
        		                             id = '$_POST[tid]',
        		                             nama = '$_POST[tnama]',
        		                             alamat = '$_POST[talamat]',
        		                             email = '$_POST[temail]'
        		                             WHERE id_tkry = '$_GET[id]'
    		");
    if($edit) //when edit success
    {
      echo "<script>
             Swal.fire(
  'Selamat!',
  'Edit Data Berhasil!',
  'success');
  document.location = 'index.php';
            </script>";
    }
    else
    {
    	echo "<script>
             Swal.fire(
  'Maaf!',
  'Edit Data Gagal!',
  'fail');
  document.location = 'index.php';
            </script>";
    }
        }
        else
        {
        	//Data saved
        	$simpan = mysqli_query($koneksi, "INSERT INTO tkyr (id_tkry, nama, alamat, email)
                                          VALUES ('$_POST[tid]', 
                                                 '$_POST[tnama]', 
                                                 '$_POST[talamat]', 
                                                 '$_POST[temail]')
    		");
    if($simpan)
    {
      echo "<script>
             Swal.fire(
  'Selamat!',
  'Data Berhasil Disimpan!',
  'success');
  document.location = 'index.php';
            </script>";
    }
    else
    {
    	echo "<script>
             Swal.fire(
  'Maaf!',
  'Data Tidak Berhasil Disimpan!',
  'fail');
  document.location = 'index.php';
            </script>";
    }
    }

    	
   }

   //Test if the edit/delete button clicked
   if(isset($_GET['hal']))
   {
   	//Test When edit the data
   	if($_GET['hal'] == "edit")
   	{
      //Show the data
   		$tampil = mysqli_query($koneksi, "SELECT * FROM tkyr WHERE id_tkry = '$_GET[id]'");
   		$data = mysqli_fetch_array($tampil);
   		if($data)
   		{
   			//If data found,data in to variable
   			$vid = $data['id_tkry'];
   			$vnama = $data['Nama'];
   			$valamat = $data['Alamat'];
   			$vemail = $data['Email'];
   		}
   	}
   	else if ($_GET['hal'] == "hapus")
   	{
      //Prepare to delete data
   		$hapus = mysqli_query($koneksi,"DELETE FROM tkyr WHERE id_tkry = '$_GET[id]' ");
   		if($hapus){
   			echo "<script>
             Swal.fire(
  'Selamat!',
  'Data Berhasil Dihapus!',
  'success');
  document.location = 'index.php';
            </script>";
   		}
   	}
   }
 ?>

 <?php
   session_start();
      if($_SESSION['status']!="login"){
         header("location:../login.php?pesan=belum_login");
      }

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Form Input Karyawan</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="shortcut icon" href="favicon.co" type="image/x-icon">

</head>
<body style="background-color:#2c3338">
<div class="container">
<h1 class="text-center text-white" >Pemrograman Web</h1>
<h2 class="text-center text-white" >Teknik Informatika</h2>

<!-- First form Card -->
<div class="card mt-4">
  <div class="card-header bg-success text-white">
    Form Input Karyawan
    <a class="btn btn-danger" href="logout.php" style="text-align:right;" > Keluar </a>
  </div>
  <div>

</div>
  <div class="card-body">
  <form method="post" action="">
  	<div class= "form-group">
  		<label>ID</label>
  		<input type="text" name="tid" value="<?=@$vid?>" class="form-control" placeholder="Input ID Anda!" required>
  </div>
  <div class= "form-group">
  		<label>Nama</label>
  		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda!" required>
  </div>
  <div class= "form-group">
  		<label>Alamat</label>
  		<textarea class="form-control" name="talamat" placeholder="Input Alamat Anda!" required>
  		<?=@$valamat?></textarea>
  </div>
  <div class= "form-group">
  		<label>Email</label>
  		<input type="text" name="temail" value= "<?=@$vemail?>" class="form-control" placeholder="Input Email Anda!" required>
  </div>

  <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
  <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
  <!-- The end of card form !-->

<!-- First form Table -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Daftar Karyawan
  </div>
  <div class="card-body">

  	<table class="table table-bordered table-striped">
  		<tr>
  			<th>No.</th>
  			<th>ID</th>
  			<th>Nama</th>
  			<th>Alamat</th>
  			<th>Email</th>
  			<th>Action</th>
  		</tr>
  		<?php
  		 $no = 1;
  		 $tampil = mysqli_query($koneksi, "SELECT * from tkyr order by id_tkry desc");
  		 while($data = mysqli_fetch_array($tampil)) :

  		?>
       <tr>
       <td><?=$no++;?></td>
       <td><?=$data['id_tkry']?></td>
       <td><?=$data['Nama']?></td>
       <td><?=$data['Alamat']?></td>
       <td><?=$data['Email']?></td>
       <td>
       <a href="index.php?hal=edit&id=<?=$data['id_tkry']?>" class="btn btn-warning">Edit</a>
       <a href="index.php?hal=hapus&id=<?=$data['id_tkry']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
   </td>
       </tr>
   <?php endwhile; //Repeat loop closing ?>
  	</table>

  
  <!-- The end of card Table !-->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="dist/sweetalert2.all.min.js"></script> 
</body>
