<?php
session_start();
error_reporting(0);
include "timeout.php";

// if($_SESSION['login']==1){
// 	if(!cek_login()){
// 		$_SESSION[login] = 0;
// 	}
// }
if($_SESSION['login']==0){
  header('location:logout.php');
}
else{
if (empty($_SESSION['user']) AND empty($_SESSION['pass']) AND $_SESSION['login']==0){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<html>
<head>
<title>Admini</title>
  <script src="../tinymcpuk/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
  <script src="../tinymcpuk/jscripts/tiny_mce/tiny_lokomedia.js" type="text/javascript"></script>

<link href="style.css" rel="stylesheet" type="text/css" />

<!-- detepicker -->
<script src="lib/jquery.min.js"></script>
<script src="lib/zebra_datepicker.js"></script>
<link rel="stylesheet" href="lib/css/default.css" />

<script>
    $(document).ready(function(){
        $('#tanggal').Zebra_DatePicker({
            format: 'Y-m-d',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });
</script>
<!-- detepicker-->

</head>
<body>
<div id="header">  	

	<div id="menu">
		<div class="left">
		<?php 
        include "menu.php"; ?>
		</div>
		<div class="right">
		 <ul class="topmenu">
        <li><a href=logout.php>Logout</a></li>
     </ul>
		</div>
	</div>
</div>
<div id="wrap">
  <div id="content">
		<?php include "content.php"; ?>
  </div>
  
		<div id="footer">
			Copyright &copy; 2016
		</div>
</div>
</body>
</html>
<?php
}
}
?>
