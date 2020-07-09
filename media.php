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
<title>SPPD</title>
  <script src="../tinymcpuk/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
  <script src="../tinymcpuk/jscripts/tiny_mce/tiny_lokomedia.js" type="text/javascript"></script>

<link href="style.css" rel="stylesheet" type="text/css" />

<!-- detepicker -->
<script src="lib/jquery.min.js"></script>
<script src="lib/zebra_datepicker.js"></script>
<link rel="stylesheet" href="lib/css/default.css" />

 <!-- data table -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"> -->

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
<script>
    $(document).ready(function(){
        $('#from').Zebra_DatePicker({
            format: 'Y-m-d',
            months : ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            days : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu'],
            days_abbr : ['Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu']
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#to').Zebra_DatePicker({
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

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>



        <script type="text/javascript" class="init">
            $(document).ready(function() {
                $('#tamu').DataTable({
                   "ordering": false,
                   "info":     false,
                    "paging":   false,
                    bFilter: false,
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Laporan Buku Tamu',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
             
                            // Loop over the cells in column `C`
                            $('row c[r^="C"]', sheet).each( function () {
                                // Get the value
                                if ( $('is t', this).text() == 'New York' ) {
                                    $(this).attr( 's', '20' );
                                }
                            });
                        }
                    }]
                });
            });

    </script>



        <script type="text/javascript" class="init">
            $(document).ready(function() {
                $('#surat').DataTable({
                   "ordering": false,
                   "info":     false,
                    "paging":   false,
                    bFilter: false,
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        title: 'Laporan Surat Keluar / Surat Masuk',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
             
                            // Loop over the cells in column `C`
                            $('row c[r^="C"]', sheet).each( function () {
                                // Get the value
                                if ( $('is t', this).text() == 'New York' ) {
                                    $(this).attr( 's', '20' );
                                }
                            });
                        }
                    }]

                });
            });

    </script>
               

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
			Copyright &copy; 2016 - 2020
		</div>
</div>
</body>
</html>
<?php
}
}
?>
