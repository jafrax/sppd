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

$aksi="modul/mod_tamu/aksi_tamu.php";
if(isset($_GET['act'])) 
    { 
        $act = $_GET['act']; 
    }
 // var_dump($act);
switch($act){
  // Tampil data
  
  default:
    echo "<h2>Buku Tamu</h2>";


    $dtnow= date('Y-m-d'); 
    $frm = date('Y-m-d', strtotime('-1 month') ); // 21-02-2017

	echo" <div class='box'><div class='left'><input type=button value='Input ' onclick=\"window.location.href='?module=tamu&act=tambah';\"></div>
		     <div class='right'><form method=get action='$_SERVER[PHP_SELF]'>
          <input type=hidden name=module value=tamu>
          
          Filter Tanggal  : <input type=text name='from'  id=from placeholder=$frm>   
          <input type=text name='to'  id=to placeholder=$dtnow> 
          <input type=submit value=Cari>
          
         </form></div></div>";
    if (empty($_GET['from'])&& empty($_GET['to'])){
    echo "<table class='list' id= 'tamu'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tanggal</td>
          <td class='left'>Nama Tamu</td>
          <td class='left'>Instansi Tamu</td>
          <td class='left'>Penerima</td>
          <td class='left'>Devisi</td>
          <td class='left'>Jabatan</td>
          <td class='left'>Tujuan</td>
          <td class='left'>Tindak lanjut</td>
          <td class='left'>Keterangan</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
    // echo $_SESSION['level'];

    if ($_SESSION['level']=='anggota'){

      $tampil = $mysqli->query("SELECT * FROM tamu ORDER BY tanggal DESC LIMIT $posisi,$batas");
    }
    else{
      $tampil= $mysqli->query("SELECT * FROM tamu ORDER BY tanggal DESC LIMIT $posisi,$batas");
    }

    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){

      // $tgl_posting=tgl_indo($r['tanggal']);
      echo "<tr><td class='center' width='25'>$no</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[nama_tamu]</td>
                <td class='left'>$r[instansi_tamu]</td>
                <td class='left'>$r[nama]</td>
                <td class='left'>$r[bagian]</td>
                <td class='left'>$r[jabatan]</td>
                <td class='left'>$r[tujuan]</td>
                <td class='left'>$r[tindak_lanjut]</td>
                <td class='left'>$r[keterangan]</td>
		            <td class='center'>
                <a href=?module=tamu&act=edit&id=$r[no]><img src='images/edit.png' border='0' title='edit' /></a> 
		            <a href=\"$aksi?module=tamu&act=hapus&id=$r[no]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>
                </td>
		        </tr>";
      $no++;
    }
    echo "</table>";

    if ($_SESSION['level']=='anggota'){
      $jmldata = mysqli_num_rows( $mysqli->query("SELECT * FROM tamu"));
    }
    else{
      $jmldata = mysqli_num_rows( $mysqli->query("SELECT * FROM tamu "));
    }  
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break; 
    }else{   



    echo "<table class='list'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tanggal</td>
          <td class='left'>Nama Tamu</td>
          <td class='left'>Instansi Tamu</td>
          <td class='left'>Penerima</td>
          <td class='left'>Devisi</td>
          <td class='left'>Jabatan</td>
          <td class='left'>Tujuan</td>
          <td class='left'>Tindak Lanjut</td>
          <td class='left'>Keterangan</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 1000;
    $posisi = $p->cariPosisi($batas);
    
    $tglfrom = $_GET['from'];
    $tglto =  $_GET['to'];
   
    $tampil =  $mysqli->query("SELECT * FROM tamu WHERE tanggal between  '$tglfrom' AND '$tglto' ORDER BY tanggal DESC LIMIT $posisi,$batas");
  
    $no = $posisi+1;
    while($r=mysqli_fetch_array($tampil)){
      // $tgl_posting=tgl_indo($r['tanggal']);
      echo "<tr><td class='left'>$no</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[nama_tamu] hari</td>
                <td class='left'>$r[instansi_tamu]</td>
                <td class='left'>$r[nama]</td>
                <td class='left'>$r[bagian]</td>
                <td class='left'>$r[jabatan]</td>
                <td class='left'>$r[tujuan]</td>
                <td class='left'>$r[tindak_lanjut]</td>
                <td class='left'>$r[keterangan]</td>
                <td class='center' width='115'>";

        if ($_SESSION['blokir']=='N'){
        echo "  
                <a href=?module=jadwal&act=edit&id=$r[no]><img src='images/edit.png' border='0' title='edit' /></a> 
                <a href=\"$aksi?module=jadwal&act=hapus&id=$r[no]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>";
        }
        echo "</td>
            </tr>";
      $no++;
    }
    echo "</table>";

    
      $jmldata = mysqli_num_rows( $mysqli->query("SELECT * FROM tamu  WHERE  tanggal between  '$tglfrom' AND '$tglto' "));
    
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break;    
    }

//=============== input ==============================================================================================================
  // no  tanggal   nama_tamu   alamat_tamu   nama  bagian  jabatan   tujuan   
  case "tambah":
    echo "<h2>Input</h2>
          <form method=POST action='$aksi?module=tamu&act=input' id='usrform' enctype='multipart/form-data'>
          <table class='list'><tbody> ";

    $tanggal = date('Y-m-d');
    
    echo "<tr><td>Tanggal</td>
          <td><input type=text  name='tanggal' id=tanggal value= $tanggal > 
          </td></tr>";
         
    echo "<tr><td>Nama Tamu</td>
          <td><input type=text  name='nama_tamu'  > 
          </td></tr>";

    echo "<tr><td>Instansi Tamu </td>
          <td><input type=text  name='instansi_tamu' form='usrform'>
          </td></tr>";

    echo "<tr><td>Penerima </td>
          <td><input type=text  name='nama' form='usrform'>
          </td></tr>";

    echo "<tr><td>Devisi </td>
          <td><input type=text  name='bagian' form='usrform'>
          </td></tr>";

    echo "<tr><td>Jabatan </td>
          <td><input type=text  name='jabatan' form='usrform'>
          </td></tr>";

    echo "<tr><td>Tujuan </td>
          <td><textarea name='tujuan' form='usrform' style='resize:none;width:300px;height:100px;' > </textarea>
          </td></tr>";

     echo" <tr><td>Tindak Lanjut</td>  
          <td><select name='tindak_lanjut'>
          <option value=Selesai>Selesai</option>
          <option value=Belum Selesai>Belum Selesai</option>
      
          </select></td></tr>";


    echo "<tr><td>Keterangan </td>
          <td><textarea name='keterangan' form='usrform' style='resize:none;width:300px;height:100px;' > </textarea>
          </td></tr>";
    
    echo "</td></tr> 
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </tbody></table></form>";
     break;



    
//====================== EDIT =======================================================================    
  case "edit":
      $edit =  $mysqli->query(" SELECT * FROM tamu WHERE no ='$_GET[id]'");
  
    $r    = mysqli_fetch_array($edit);

    echo "<h2>Edit</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=tamu&act=update>
          <input type=hidden name=id value=$r[no]>
          <table class='list'><tbody>";

    echo "<tr><td width=70>tanggal</td><td> : <input type=text name='tanggal' id=tanggal size=60 value='$r[tanggal]'></td></tr>";
    echo "<tr><td width=70>Nam Tamu</td><td> : <input type=text name='nama_tamu' size=60 value='$r[nama_tamu]'></td></tr>";
    echo "<tr><td width=70>Instansi Tamu</td><td> : <input type=text name='instansi_tamu' size=60 value='$r[instansi_tamu]'></td></tr>";
    echo "<tr><td width=70>Penerima</td><td> : <input type=text name='nama' size=60 value='$r[nama]'></td></tr>";
    echo "<tr><td width=70>Bagian</td><td> : <input type=text name='bagian' size=60 value='$r[bagian]'></td></tr>";
    echo "<tr><td width=70>Jabatan</td><td> : <input type=text name='jabatan' size=60 value='$r[jabatan]'></td></tr>";
    echo "<tr><td width=70>Tujuan</td><td> : <input type=text name='tujuan' size=60 value='$r[tujuan]'></td></tr>";
   
    echo" <tr><td>Tindak Lanjut</td> 
          <td> : <select name='tindak_lanjut'>";
    // echo" <option select value='$r[tindak_lanjut]'>$r[tindak_lanjut]</option";
    echo" <option value='Selesai'>Selesai</option>";
    echo" <option value='Belum Selesai'>Belum Selesai</option>
          </select></td></tr>";
    
    echo "<tr><td width=70>Keterangan</td><td> : <input type=text name='keterangan' size=60 value='$r[keterangan]'></td></tr>";

    echo  "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </tbody></table></form>";
    break;  

}
}
?>
