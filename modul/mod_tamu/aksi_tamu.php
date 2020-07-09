<?php
session_start();
if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../koneksi.php";
// include "../../../config/library.php";
// include "../../../config/fungsi_thumb.php";
// include "../../../config/fungsi_seo.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus komoditas
if ($module=='tamu' AND $act=='hapus'){
 
   $mysqli->query("DELETE FROM tamu WHERE no ='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input jadwal
elseif ($module=='tamu' AND $act=='input'){


  $tanggal = $_POST['tanggal'];
  $nama_tamu = $_POST['nama_tamu'];
  $instansi_tamu = $_POST['instansi_tamu'];
  $nama = $_POST['nama'];
  $bagian = $_POST['bagian'];
  $jabatan = $_POST['jabatan'];
  $tujuan = $_POST['tujuan'];
  $tindak_lanjut = $_POST['tindak_lanjut'];
  $keterangan = $_POST['keterangan'];


  $sql = "INSERT INTO tamu (tanggal,nama_tamu,instansi_tamu,nama,bagian,jabatan,tujuan,tindak_lanjut,keterangan)
          values ('$tanggal','$nama_tamu','$instansi_tamu','$nama','$bagian','$jabatan','$tujuan','$tindak_lanjut','$keterangan') ";
  
  // var_dump($sql);                          
   $mysqli->query($sql);             

            
  echo "<script>window.alert(' Data berhasil disimpan !!');
        window.location=('../../media.php?module=tamu')</script>";
       
}




// Update komoditas
elseif ($module=='tamu' AND $act=='update'){

  $no = $_POST['id'];
  $tanggal = $_POST['tanggal'];
  $nama_tamu = $_POST['nama_tamu'];
  $instansi_tamu = $_POST['instansi_tamu'];
  $nama = $_POST['nama'];
  $bagian = $_POST['bagian'];
  $jabatan = $_POST['jabatan'];
  $tujuan = $_POST['tujuan'];
  $tindak_lanjut = $_POST['tindak_lanjut'];
  $keterangan = $_POST['keterangan'];

  $query = "UPDATE tamu SET        tanggal        = '$tanggal',
                                   nama_tamu      = '$nama_tamu', 
                                   instansi_tamu  = '$instansi_tamu',
                                   nama           = '$nama',
                                   bagian         = '$bagian',
                                   jabatan        = '$jabatan',
                                   tujuan         = '$tujuan',
                                   tindak_lanjut  = '$tindak_lanjut',
                                   keterangan     = '$keterangan'
                             WHERE no             = '$no' ";

  // echo $query;  
   $mysqli->query($query);                           
  header('location:../../media.php?module='.$module);
  
 
}

}
?>
