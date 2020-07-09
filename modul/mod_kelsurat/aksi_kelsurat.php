<?php
session_start();
 if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../koneksi.php";

$module=$_GET["module"];
$act=$_GET["act"];

// var_dump($module);

// Hapus 
if ($module=='kelsurat' AND $act=='hapus'){
 
   $mysqli->query("DELETE FROM kelsurat WHERE kode ='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input user
if ($module=='kelsurat' AND $act=='input'){
   $query = "INSERT INTO kelsurat (kode,
                                 kelompok) 
	                       VALUES('$_POST[kode]',
                                '$_POST[kelompok]')";
  // var_dump($query);                              
  $mysqli->query($query);                              
  header('location:../../media.php?module='.$module);
}

// Update user
elseif ($module=='kelsurat' AND $act=='update'){

  if (!empty($_POST['kode'])) {
    $query="UPDATE kelsurat SET kelompok   = '$_POST[kelompok]'
                           WHERE  kode     = '$_POST[kode]'";
  
  // var_dump($query);
  $mysqli->query($query);
  header('location:../../media.php?module='.$module);
}}

}
?>
