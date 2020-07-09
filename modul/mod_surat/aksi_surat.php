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
if ($module=='surat' AND $act=='hapus'){
 
   $mysqli->query("DELETE FROM surat WHERE id ='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input jadwal
// id  tipe_surat  kel_surat   tanggal   no_surat  isi_surat   tujuan_surat  penerima_surat 
elseif ($module=='surat' AND $act=='inputmasuk'){
  $tipe_surat = $_POST['tipe_surat'];
  $kel_surat = $_POST['kel_surat'];
  $tanggal = $_POST['tanggal'];
  $no_surat = $_POST['no_surat'];
  $isi_surat = $_POST['isi_surat'];
  $tujuan_surat = $_POST['tujuan_surat'];
  $penerima_surat = $_POST['penerima_surat'];


  $sql = "INSERT INTO surat (tipe_surat, kel_surat, tanggal, no_surat, isi_surat,  tujuan_surat, penerima_surat )
          values ('$tipe_surat','$kel_surat','$tanggal','$no_surat','$isi_surat','$tujuan_surat','$penerima_surat') ";
  // echo $sql;
  $mysqli->query($sql);             
 
          echo "<script>window.alert('Data sudah disimpan !!');
              window.location=('../../media.php?module=surat')</script>";
    
}


elseif ($module=='surat' AND $act=='inputkeluar'){
  $tipe_surat = $_POST['tipe_surat'];
  $kel_surat = $_POST['kel_surat'];
  $tanggal = $_POST['tanggal'];
  // $no_surat = $_POST['no_surat'];
  $isi_surat = $_POST['isi_surat'];
  $tujuan_surat = $_POST['tujuan_surat'];
  $penerima_surat = $_POST['penerima_surat'];

                     
      $etgl =  explode("-",$tanggal);
      $thn = strtolower($etgl[0]);
      $bln = strtolower($etgl[1]);
      $hr = strtolower($etgl[2]);

      if ($bln == "01"){$rbln = "I";} elseif ($bln == "02") {$rbln = "I";} elseif ($bln == "03") {$rbln = "III";}
      elseif ($bln == "04") {$rbln = "IV";} elseif ($bln == "05") {$rbln = "V";} elseif ($bln == "06") {$rbln = "VI";}
      elseif ($bln == "07") {$rbln = "VII";} elseif ($bln == "08") {$rbln = "VIII";}elseif ($bln == "09") {$rbln = "IX";}
      elseif ($bln == "10") {$rbln = "X";} elseif ($bln == "11") {$rbln = "XI";} elseif ($bln == "12") {$rbln = "XII";}   
                         
      $no = mysqli_fetch_array($mysqli->query("SELECT IFNULL((MAX(RIGHT(LEFT(no_surat,7),3))+ 1),'1') as nomor FROM surat where tanggal= '$tanggal'"));
      $NoTransaksi = sprintf('%03s', $no['nomor']);
                           
      $no_surat_new = $kel_surat."/".$NoTransaksi."/".$hr."/".$rbln."/".$thn;

      $sql = "INSERT INTO surat (tipe_surat,kel_surat,tanggal,no_surat,isi_surat,tujuan_surat,penerima_surat )  
              values ('$tipe_surat','$kel_surat','$tanggal','$no_surat_new','$isi_surat','$tujuan_surat','$penerima_surat') ";

      // var_dump($sql);
      $mysqli->query($sql);    
          echo "<script>window.alert('Data sudah disimpan !!');
              window.location=('../../media.php?module=surat')</script>";

    
}


// Update komoditas
elseif ($module=='surat' AND $act=='update'){

  $id = $_POST['id'];
  // $tipe_surat = $_POST['tipe_surat'];
  // $kel_surat = $_POST['kel_surat'];
  $tanggal = $_POST['tanggal'];
  $no_surat = $_POST['no_surat'];
  $isi_surat = $_POST['isi_surat'];
  $tujuan_surat = $_POST['tujuan_surat'];
  $penerima_surat = $_POST['penerima_surat'];

        $query = "UPDATE surat SET tanggal               = '$tanggal',
                                   no_surat        = '$no_surat', 
                                   isi_surat       = '$isi_surat',
                                   tujuan_surat    = '$tujuan_surat',
                                   penerima_surat  = '$penerima_surat'
                             WHERE id              = '$id' ";

  
  echo $query;  
   $mysqli->query($query);                           
  header('location:../../media.php?module='.$module);
  
 
}

}
?>
