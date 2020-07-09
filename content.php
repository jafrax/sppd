<?php
// include "../config/koneksi.php";
// include "../config/library.php";
// include "../config/fungsi_indotgl.php";
// include "../config/fungsi_combobox.php";
include "class_paging.php";

// Bagian Home
if ($_GET['module']=='home'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[nama]</b>, selamat datang di halaman Administratornggota CMS BKP.<br> 
          Silahkan klik menu pilihan yang berada di bagian header untuk mengelola website. </p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p> ";
}

// Bagian jadwal Website
elseif ($_GET['module']=='jadwal'){
  // if ($_SESSION['level']=='anggota'){
    include "modul/mod_jadwal/jadwal.php";
  // }
}


elseif ($_GET['module']=='anggota'){
  // if ($_SESSION['level']=='anggota'){
    include "modul/mod_users/users.php";
  // }
}

// Bagian tamu Website
elseif ($_GET['module']=='tamu'){
  // if ($_SESSION['level']=='anggota'){
    include "modul/mod_tamu/tamu.php";
  // }
}


// Bagian tamu Website
elseif ($_GET['module']=='surat'){
  // if ($_SESSION['level']=='anggota'){
    include "modul/mod_surat/surat.php";
  // }
}


// Bagian tamu Website
elseif ($_GET['module']=='kelsurat'){
  // if ($_SESSION['level']=='anggota'){
    include "modul/mod_kelsurat/kelsurat.php";
  // }
}

// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
  // include "modul/mod_jadwal/jadwal.php";
}
?>
