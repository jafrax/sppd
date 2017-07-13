<?php
include "koneksi.php";

/**
 * @author AyankQ
 * @copyright 2012
 */

if ($_SESSION['level']=='anggota'){
echo "<ul> 
        <li><a href=?module=home>Home</a></li>";

         echo '<li><a href=?module=jadwal>jadwal</a></li>';
         if ($_SESSION['blokir']=='N'){
         echo '<li><a href=?module=anggota>anggota</a></li>';
     		}
      }
echo "</ul>";

?>
