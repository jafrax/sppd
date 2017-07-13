<?php
include "koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
$login=mysql_query("SELECT * FROM anggota WHERE username='$username' AND password='$pass' ");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";

  // $_SESSION['KCFINDER']=array();
  // $_SESSION['KCFINDER']['disabled'] = false;
  // $_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
  // $_SESSION['KCFINDER']['uploadDir'] = "";

  $_SESSION[user]     = $r[username];
  $_SESSION[nama]     = $r[nama];
  $_SESSION[blokir]     = $r[blokir];
  $_SESSION[level]    = "anggota";
  
  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();
	
	session_regenerate_id();

	$sid_baru = session_id();

  mysql_query("UPDATE anggota SET id_session='$sid_baru' WHERE username='$username'");
  header('location:media.php?module=home');
}
else{
  include "error-login.php";
}
}
?>
