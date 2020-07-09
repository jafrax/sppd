<?php
session_start();
 if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// var_dump($module);
// Input user
if ($module=='anggota' AND $act=='input'){
  
    if (empty($_POST['password'])) {
      $pass = "";
    }else {
      $pass=md5($_POST['password']);  
    } 
    
  $query = "INSERT INTO anggota (username,
                                 password,
                                 nama,
                                 blokir) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama_lengkap]',
                                '$_POST[blokir]')";
  // var_dump($query);                              
  $mysqli->query($query);                              
  header('location:../../media.php?module='.$module);
}

// Update user
elseif ($module=='anggota' AND $act=='update'){
  if (empty($_POST['password'])) {
    $query="UPDATE anggota SET nama   = '$_POST[nama_lengkap]',
                                  username          = '$_POST[username]',
                                  blokir         = '$_POST[blokir]'  
                           WHERE  id     = '$_POST[id]'";
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST['password']);
    $query ="UPDATE anggota SET password        = '$pass',
                                 nama    = '$_POST[nama_lengkap]',
                                 username           = '$_POST[username]',  
                                 blokir          = '$_POST[blokir]'  
                            WHERE id      = '$_POST[id]'";
  }
// var_dump($query);
  $mysqli->query($query);
  header('location:../../media.php?module='.$module);
}
}
?>
