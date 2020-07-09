<?php
// panggil fungsi validasi xss dan injection
// require_once('fungsi_validasi.php');
// error_reporting(0);
error_reporting(E_ALL);


// definisikan koneksi ke database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sppd";

$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
 
if(mysqli_connect_errno()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}else{
// 	echo 'Koneksi berhasil ^_^';
}


?>
