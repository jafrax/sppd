<?php
include "koneksi.php";

/**
 * @author AyankQ
 * @copyright 2012
 */

if ($_SESSION['level']=='anggota'){
echo "<ul> 
        <li><a href=?module=home>Home</a></li>";

         echo '<li><a href=?module=jadwal>Jadwal Dinas</a></li>';
         if ($_SESSION['blokir']=='N'){
         echo '<li><a href=?module=anggota>Anggota Dinas</a></li>';
         echo '<li><a href=?module=kelsurat>Kel Surat</a></li>';
		 echo '<li><a href=?module=surat>Surat Masuk & Keluar</a></li>';
     	 echo '<li><a href=?module=tamu>Daftar Tamu</a></li>';
     		}



      }
echo "</ul>";

?>
