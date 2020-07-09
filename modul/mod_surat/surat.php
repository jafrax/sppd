<?php  
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }   
$act = "";
// session_start();
 if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_surat/aksi_surat.php";
if(isset($_GET['act'])) 
    { 
        $act = $_GET['act']; 
    }
 // var_dump($act);
switch($act){
  // Tampil data
  default:
    echo "<h2>DAFTAR SURAT</h2>"; $dtnow= date('Y-m-d');
	echo" <div class='box'><div class='left'>
  <input type=button value='Input Surat Masuk ' onclick=\"window.location.href='?module=surat&act=tambahmasuk';\">
  <br/>
  <input type=button value='Input Surat Keluar' onclick=\"window.location.href='?module=surat&act=tambahkeluar';\">
  </div>
		     <div class='right'><form method=get action='$_SERVER[PHP_SELF]'>
          <input type=hidden name=module value=surat>
          <input type=hidden name=cari value=1>
          Tipe : <select name='tipe_surat'>
            <option value=0 selected>Semua Surat</option>
            <option value=1 >Surat Masuk</option>
            <option value=2 >Surat Keluar</option>
            </select>

          Kelompok : <select name='kel_surat'>
            <option value=0 selected>- Pilih Kelompok -</option>";
            $tampil= $mysqli->query("SELECT * FROM kelsurat ORDER BY kode asc ");
            while($r=mysqli_fetch_array($tampil)){
              echo "<option value=$r[kode]>$r[kelompok]</option>";
            }
    echo "</select>
          <br/>
         
          Filter Tanggal  : <input type=text name='from'  id=from placeholder=$dtnow>   
          <input type=text name='to'  id=to placeholder=$dtnow> <input type=submit value=Cari>
          
         </form></div></div>";
    if (empty($_GET['cari'])){
    echo "<table class='list' id='surat'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tipe Surat</td>
          <td class='left'>Kel Surat</td>
          <td class='left'>Tanggal</td>
          <td class='left'>No Surat</td>
          <td class='left'>Isi Surat</td>
          <td class='left'>Tujuan Surat</td>
          <td class='left'>Penerima Surat</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
    // echo $_SESSION['level'];

      $tampil = $mysqli->query("SELECT  id,tipe_surat,kel_surat,tanggal,no_surat,isi_surat,tujuan_surat,penerima_surat  
        FROM surat ORDER BY tanggal DESC LIMIT $posisi,$batas");

    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){
 
      $tipe = $r['tipe_surat']; if($tipe == 1){$tipe_surat = "Surat Masuk";}elseif ($tipe == 2) {$tipe_surat = "Surat Keluar";}
      $kel = $r['kel_surat'];
      if(!empty($kel)){
      $data    = mysqli_fetch_array($mysqli->query("SELECT * FROM kelsurat WHERE kode = '$kel' "));
      
        $kel_surat = $data['kelompok'];
      }else{
        $kel_surat = "";
      }
      echo "<tr><td class='center' width='25'>$no</td>
                <td class='left'>$tipe_surat</td>
                <td class='left'>$kel_surat</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[no_surat]</td>
                <td class='left'>$r[isi_surat]</td>
                <td class='left'>$r[tujuan_surat]</td>
                 <td class='left'>$r[penerima_surat]</td>
		            <td class='center' width='115'>
                
                <a href=?module=surat&act=edit&id=$r[id]><img src='images/edit.png' border='0' title='edit' /></a> 
		            <a href=\"$aksi?module=surat&act=hapus&id=$r[id]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>

                </td>
		        </tr>";
      $no++;
    }
    echo "</table>";

    $jmldata = mysqli_num_rows( $mysqli->query("SELECT * FROM surat"));

    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break; 
    }else{  

      $tipe_surat= $_GET['tipe_surat'];
      $kel_surat= $_GET['kel_surat'];
      $from= $_GET['from'];
      $to= $_GET['to'];

    echo "<table class='list'  id='surat'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tipe Surat</td>
          <td class='left'>Kel Surat</td>
          <td class='left'>Tanggal</td>
          <td class='left'>No Surat</td>
          <td class='left'>Isi Surat</td>
          <td class='left'>Tujuan Surat</td>
          <td class='left'>Penerima Surat</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 1000;
    $posisi = $p->cariPosisi($batas);

    $querysql =" SELECT id,tipe_surat,kel_surat,tanggal,no_surat,isi_surat,tujuan_surat,penerima_surat
        FROM surat WHERE tipe_surat > 0 ";

    if(!empty($tipe_surat)){
      $querysql.= "AND tipe_surat = '$tipe_surat'";
    } 
    if(!empty($kel_surat)) { 
      $querysql.= " AND kel_surat = '$kel_surat'"; 
    } 
    if(!empty($from) && !empty($to)) { 
      $querysql.= " AND tanggal between '$from' AND '$to' "; 
    }
   $querysql.= "ORDER BY tanggal DESC";

    // var_dump($querysql);

    $tampil= $mysqli->query($querysql);

    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){
      // $tgl_posting=tgl_indo($r['tanggal']);

      $tipe = $r['tipe_surat']; if($tipe == 1){$tipe_surat = "Surat Masuk";}elseif ($tipe == 2) {$tipe_surat = "Surat Keluar";}
      $kel = $r['kel_surat'];
      if(!empty($kel)){
      $data    = mysqli_fetch_array($mysqli->query("SELECT * FROM kelsurat WHERE kode = '$kel' "));
      
        $kel_surat = $data['kelompok'];
      }else{
        $kel_surat = "";
      }
 
      echo "<tr><td class='center' width='25'>$no</td>
                <td class='left'>$tipe_surat</td>
                <td class='left'>$kel_surat</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[no_surat]</td>
                <td class='left'>$r[isi_surat]</td>
                <td class='left'>$r[tujuan_surat]</td>
                <td class='left'>$r[penerima_surat]</td>
                <td class='center' width='115'>
             
                <a href=?module=surat&act=edit&id=$r[id]><img src='images/edit.png' border='0' title='edit' /></a> 
                <a href=\"$aksi?module=surat&act=hapus&id=$r[id]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>
                
                </td>
            </tr>";
      $no++;
    }
    echo "</table>";

   
      $jmldata = mysqli_num_rows( $mysqli->query($querysql));
     
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break;    
    }

//=============== input ==============================================================================================================
  
  case "tambahmasuk":
    echo "<h2>Input Surat Masuk</h2>
          <form method=POST action='$aksi?module=surat&act=inputmasuk' id='usrform' enctype='multipart/form-data'>
          <table class='list'><tbody>
          <input type=hidden  name='tipe_surat' value=1 >
          <input type=hidden  name='kel_surat' value='' > ";

    $tanggal = date('Y-m-d');
    
    echo "<tr><td>Tanggal</td>
          <td><input type=text  name='tanggal' id=tanggal value= $tanggal > 
          </td></tr>";
    echo "<tr><td>No Surat </td>
          <td><input type=text  name='no_surat' > 
          </td></tr>";

    echo "<tr><td>Isi Surat </td>
          <td><input type=text  name='isi_surat' >
          </td></tr>";

    echo "<tr><td>Tujuan </td>
          <td><input type=text  name='tujuan_surat' >
          </td></tr>";
       
    echo "<tr><td>Penerima </td>
          <td><input type=text  name='penerima_surat' >
          </td></tr>";

      echo "</td></tr> 
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </tbody></table></form>";
     break;


 
  case "tambahkeluar":
    echo "<h2>Input Surat Keluar</h2>
          <form method=POST action='$aksi?module=surat&act=inputkeluar' id='usrform' enctype='multipart/form-data'>
          <table class='list'><tbody> 
          <input type=hidden  name='tipe_surat' value=2 > ";


    echo" <tr><td>Kel Surat</td>  
          <td><select name='kel_surat'>";
            $tampil= $mysqli->query("SELECT * FROM kelsurat  ");
            while($r=mysqli_fetch_array($tampil)){
              echo "<option value=$r[kode]>$r[kelompok]</option>";
            }
    echo "</select></td></tr>";

    $tanggal = date('Y-m-d');
    
    echo "<tr><td>Tanggal</td>
          <td><input type=text  name='tanggal' id=tanggal value= $tanggal > 
          </td></tr>";
         
    echo "<tr><td>Isi Surat</td>
          <td><input type=text  name='isi_surat'  > 
          </td></tr>";



    echo "<tr><td>tujuan </td>
          <td><input type=text  name='tujuan_surat'  > 
          </td></tr>";

    echo "<tr><td>Penerima </td>
          <td><input type=text  name='penerima_surat'  > 
          </td></tr>";
    
    echo "</td></tr> 
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </tbody></table></form>";
     break;



//====================== EDIT =======================================================================    
  case "edit":
   
    $edit =  $mysqli->query(" SELECT * FROM surat WHERE id ='$_GET[id]'");
   
    $r    = mysqli_fetch_array($edit);

    echo "<h2>Edit</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=surat&act=update>
          <input type=hidden name=id value=$r[id]>
          <table class='list'><tbody>";
    echo "<tr><td width=70>tanggal</td><td> : <input type=text name='tanggal' id=tanggal size=60 value='$r[tanggal]'></td></tr>";
    echo "<tr><td width=70>No Surat</td><td> : <input type=text name='no_surat' size=60 value='$r[no_surat]'></td></tr>";
    echo "<tr><td width=70>Isi Surat</td><td> : <input type=text name='isi_surat' size=60 value='$r[isi_surat]'></td></tr>";
    echo "<tr><td width=70>Tujuan </td><td> : <input type=text name='tujuan_surat' size=60 value='$r[tujuan_surat]'></td></tr>";
    echo "<tr><td width=70>Penerima</td><td> : <input type=text name='penerima_surat' size=60 value='$r[penerima_surat]'></td></tr>";

    echo  "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </tbody></table></form>";
    break;  

}
}
?>
