<?php
include "koneksi.php";
// escape variables for security
$username = mysqli_real_escape_string($mysqli, $_POST['username']);
$pass = mysqli_real_escape_string($mysqli, $_POST['password']);

 // $mahasiswa=$mysqli->query("SELECT * FROM anggota WHERE username='sppd' and id=1 ");
 //            while($m=mysqli_fetch_array($mahasiswa)){
 //              var_dump($m['nama']); echo "<br>";
 //            }

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
$login=$mysqli->query("SELECT * FROM anggota WHERE username='$username' and password=md5('$pass')  ");
// $ketemu=mysqli_num_rows($login);
// $r=mysqli_fetch_array($login)
// var_dump($r);
$rowcount=mysqli_num_rows($login);
$row = $login->fetch_array(MYSQLI_ASSOC);
// printf ("%s (%s)\n", $row["nama"], $row["username"]);

// Apabila username dan password ditemukan
if ($rowcount > 0){
  session_start();
  include "timeout.php";

  // $_SESSION['KCFINDER']=array();
  // $_SESSION['KCFINDER']['disabled'] = false;
  // $_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
  // $_SESSION['KCFINDER']['uploadDir'] = "";

  $_SESSION['user']       = $row["username"];
  $_SESSION['nama']       = $row["nama"];
  $_SESSION['blokir']     = $row["blokir"];
  $_SESSION['level']      = "anggota";
  
  // session timeout
  $_SESSION['login'] = 1;
  timer();

	$sid_lama = session_id();
	
	session_regenerate_id();

	$sid_baru = session_id();

$mysqli->query("UPDATE anggota SET id_session='$sid_baru' WHERE username='$username'");

  // mysql_query("UPDATE anggota SET id_session='$sid_baru' WHERE username='$username'");
  header('location:media.php?module=home');
}
else{
  include "error-login.php";
}
}
?>
