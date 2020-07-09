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
if ($module=='jadwal' AND $act=='hapus'){
 
   $mysqli->query("DELETE FROM jadwal WHERE id ='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input jadwal
elseif ($module=='jadwal' AND $act=='input'){
  $tanggal = $_POST['tanggal'];
  $lama = $_POST['lama'];
  $anggota = $_POST['anggota'];
  $kegiatan = $_POST['kegiatan'];
  $tujuan = $_POST['tujuan'];

  if($lama > 10){
     echo "<script>window.alert(' lama tugas melebihi tidak lebih 10 hari !!');
                  window.location=('../../media.php?module=jadwal')</script>";
  }else{

        $cek = mysqli_num_rows( $mysqli->query("SELECT * from jadwal 
          WHERE tanggal = '$tanggal' and anggota_id = '$anggota'"));


        if ($cek == 0){

          //jika masih tugas
            $sqlcek= "SELECT tanggal,  tanggal + INTERVAL (lama -1) DAY as pulang from jadwal WHERE anggota_id= '$anggota' and lama > 1 ";
            $hasil =  $mysqli->query($sqlcek);
            $num = mysqli_num_rows($hasil);
            if($num >=1){
             while($r=mysqli_fetch_array($hasil)){
                    //echo "brangkat ".$r['tanggal']." pulang ".$r['pulang'];

                     if (($tanggal > $r['tanggal']) && ($tanggal < $r['pulang']))
                      {
                         echo "<script>window.alert(' anggota masih dalam tugas !!');
                        window.location=('../../media.php?module=jadwal')</script>";
                      }
                      else
                      {
                       
                              $etgl =  explode("-",$tanggal);
                              $thn = strtolower($etgl[0]);
                              $bln = strtolower($etgl[1]);
                              $hr = strtolower($etgl[2]);

                              // echo "thn :".$thn;
                              // echo "bln :".$bln;
                              // echo "hr :".$hr;

                               if ($bln == "01"){$rbln = "I";} elseif ($bln == "02") {$rbln = "I";} elseif ($bln == "03") {$rbln = "III";}
                                elseif ($bln == "04") {$rbln = "IV";} elseif ($bln == "05") {$rbln = "V";} elseif ($bln == "06") {$rbln = "VI";}
                                elseif ($bln == "07") {$rbln = "VII";} elseif ($bln == "08") {$rbln = "VIII";}elseif ($bln == "09") {$rbln = "IX";}
                                elseif ($bln == "10") {$rbln = "X";} elseif ($bln == "11") {$rbln = "XI";} elseif ($bln == "12") {$rbln = "XII";}   
                                
                                $no = mysqli_fetch_array($mysqli->query("SELECT IFNULL((MAX(RIGHT(LEFT(sppd,7),3))+ 1),'1') as no FROM jadwal where tanggal= '$tanggal'"));
                                $NoTransaksi = sprintf('%03s', $no['no']);

                                

                                
                                $sppd = "094/".$NoTransaksi."/".$hr."/".$rbln."/".$thn;

                                 // echo $sppd;

                               if (!empty($tanggal) and !empty($sppd) and !empty($anggota) and !empty($kegiatan) and !empty($tujuan) )
                              {

                                $sql = "INSERT INTO jadwal 
                                                                (tanggal,
                                                                 lama, 
                                                                 anggota_id, 
                                                                 sppd, 
                                                                 kegiatan, 
                                                                 tujuan ) 
                                                        values ('$tanggal',
                                                                '$lama', 
                                                                '$anggota',
                                                                '$sppd', 
                                                                '$kegiatan',
                                                                '$tujuan') ";
                               // echo $sql;
                             $mysqli->query($sql);             
                            header('location:../../media.php?module='.$module);
                                }
                      }

                   
            }
          }else{

                              $etgl =  explode("-",$tanggal);
                              $thn = strtolower($etgl[0]);
                              $bln = strtolower($etgl[1]);
                              $hr = strtolower($etgl[2]);

                              // echo "thn :".$thn;
                              // echo "bln :".$bln;
                              // echo "hr :".$hr;

                                if ($bln == "01"){$rbln = "I";} elseif ($bln == "02") {$rbln = "I";} elseif ($bln == "03") {$rbln = "III";}
                                elseif ($bln == "04") {$rbln = "IV";} elseif ($bln == "05") {$rbln = "V";} elseif ($bln == "06") {$rbln = "VI";}
                                elseif ($bln == "07") {$rbln = "VII";} elseif ($bln == "08") {$rbln = "VIII";}elseif ($bln == "09") {$rbln = "IX";}
                                elseif ($bln == "10") {$rbln = "X";} elseif ($bln == "11") {$rbln = "XI";} elseif ($bln == "12") {$rbln = "XII";}  
                                
                                $no = mysqli_fetch_array($mysqli->query("SELECT IFNULL((MAX(RIGHT(LEFT(sppd,7),3))+ 1),'1') as no FROM jadwal where tanggal= '$tanggal'"));
                                $NoTransaksi = sprintf('%03s', $no['no']);

                                
                                $sppd = "094/".$NoTransaksi."/".$hr."/".$rbln."/".$thn;

                                // echo $sppd;

                               if (!empty($tanggal) and !empty($sppd) and !empty($anggota) and !empty($kegiatan) and !empty($tujuan) )
                              {

                                $sql = "INSERT INTO jadwal 
                                                                (tanggal,
                                                                 lama, 
                                                                 anggota_id, 
                                                                 sppd, 
                                                                 kegiatan, 
                                                                 tujuan ) 
                                                        values ('$tanggal',
                                                                '$lama', 
                                                                '$anggota',
                                                                '$sppd', 
                                                                '$kegiatan',
                                                                '$tujuan') ";
                               // echo $sql;
                               $mysqli->query($sql);             
                              header('location:../../media.php?module='.$module);
                                }

          }
            
        }else{
          echo "<script>window.alert(' anggota sudah ada !!');
              window.location=('../../media.php?module=jadwal')</script>";
        }

  }
    
}


// tambah anggota
elseif ($module=='jadwal' AND $act=='add'){

  if ($_POST['anggota'] == 0 ){
     echo "<script>window.alert('Pilih anggota dahulu !!');
        window.location=('../../media.php?module=jadwal')</script>";
  }else{


    //ambil jumlah waktu yang ada
      $waktu = mysqli_fetch_array( $mysqli->query("SELECT lama from jadwal where id= '$_POST[id]' "));
            
    //jika masih tugas
      $sqlcek= "SELECT tanggal,  tanggal + INTERVAL (lama -1) DAY as pulang from jadwal 
      WHERE anggota_id= '$_POST[anggota]' and lama > 1 ";
      $hasil =  $mysqli->query($sqlcek);
      $num = mysqli_num_rows($hasil);
      if($num >=1){
       while($r=mysqli_fetch_array($hasil)){
              //echo "brangkat ".$r['tanggal']." pulang ".$r['pulang'];

               if (($_POST['tanggal'] > $r['tanggal']) && ($_POST['tanggal'] < $r['pulang']))
                {
                   echo "<script>window.alert(' anggota masih dalam tugas !!');
                  window.location=('../../media.php?module=jadwal')</script>";
                }
                else
                {


                    $query = " INSERT INTO jadwal  (tanggal,lama ,anggota_id, sppd, kegiatan ,tujuan )
                    values ('$_POST[tanggal]',$waktu[lama],'$_POST[anggota]','$_POST[sppd]','$_POST[kegiatan]','$_POST[tujuan]' ) ";

                    // echo $query;                             
                     $mysqli->query($query);
                    header('location:../../media.php?module='.$module);
                }
      }
      }else{
        $query = " INSERT INTO jadwal  (tanggal, lama ,anggota_id, sppd, kegiatan ,tujuan )
                    values ('$_POST[tanggal]',$waktu[lama],'$_POST[anggota]','$_POST[sppd]','$_POST[kegiatan]','$_POST[tujuan]' ) ";

                    // echo $query;                             
                     $mysqli->query($query);
                    header('location:../../media.php?module='.$module);
      }
    
  }
 
}


// Update komoditas
elseif ($module=='jadwal' AND $act=='update'){

  $query = "UPDATE jadwal SET tanggal               = '$_POST[tanggal]',
                                   anggota_id          = '$_POST[anggota]', 
                                   sppd                = '$_POST[sppd]',
                                   kegiatan            = '$_POST[kegiatan]',
                                   tujuan              = '$_POST[tujuan]',
                                   lama                = '$_POST[lama]'
                             WHERE id                  = '$_POST[id]' ";

  //echo $query;  
   $mysqli->query($query);                           
  header('location:../../media.php?module='.$module);
  
 
}

}
?>
