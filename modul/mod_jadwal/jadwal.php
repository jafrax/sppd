
<?php    
session_start();
 if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_jadwal/aksi_jadwal.php";
switch($_GET[act]){
  // Tampil data
  
  default:
    echo "<h2>Jadwal Dinas</h2>"; $dtnow= date('Y-m-d');
	echo" <div class='box'><div class='left'><input type=button value='Input ' onclick=\"window.location.href='?module=jadwal&act=tambah';\"></div>
		     <div class='right'><form method=get action='$_SERVER[PHP_SELF]'>
          <input type=hidden name=module value=jadwal>
          Filter Tanggal  : <input type=text name='tanggal'  id=tanggal placeholder=$dtnow> <input type=submit value=Cari>
          
         </form></div></div>";
    if (empty($_GET['tanggal'])){
    echo "<table class='list'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tanggal</td>
          <td class='left'>Waktu</td>
          <td class='left'>No SPPD</td>
          <td class='left'>Nama Kegiatan</td>
          <td class='left'>Tujuan Kegiatan</td>
          <td class='left'>Nama Anggota</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);
    // echo $_SESSION['level'];

    if ($_SESSION['level']=='anggota'){

      $tampil = mysql_query("SELECT jadwal.id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama ,jadwal.lama
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id ORDER BY jadwal.tanggal DESC LIMIT $posisi,$batas");
    }
    else{
      $tampil= mysql_query("SELECT jadwal.id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama ,jadwal.lama
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id  ORDER BY jadwal.tanggal DESC LIMIT $posisi,$batas");
    }

    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){

      // $tgl_posting=tgl_indo($r['tanggal']);
      echo "<tr><td class='center' width='25'>$no</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[lama] hari</td>
                <td class='left'>$r[sppd]</td>
                <td class='left'>$r[kegiatan]</td>
                <td class='left'>$r[tujuan]</td>
                 <td class='left'>$r[nama]</td>
		            <td class='center' width='115'>
                <a href=?module=jadwal&act=add&id=$r[id]><img src='images/user.png' border='0' title='tambah' /></a> ";
      if ($_SESSION['blokir']=='N'){
      echo "
                <a href=?module=jadwal&act=edit&id=$r[id]><img src='images/edit.png' border='0' title='edit' /></a> 
		            <a href=\"$aksi?module=jadwal&act=hapus&id=$r[id]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>";
      }
      echo "
                </td>
		        </tr>";
      $no++;
    }
    echo "</table>";

    if ($_SESSION['level']=='anggota'){
      $jmldata = mysql_num_rows(mysql_query("SELECT * FROM jadwal"));
    }
    else{
      $jmldata = mysql_num_rows(mysql_query("SELECT * FROM jadwal "));
    }  
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break; 
    }else{   

    echo "<table class='list'><thead>  
          <tr><td class='center'>no</td>
          <td class='left'>Tanggal</td>
          <td class='left'>Waktu</td>
          <td class='left'>No SPPD</td>
          <td class='left'>Nama Kegiatan</td>
          <td class='left'>Tujuan Kegiatan</td>
          <td class='left'>Nama Anggota</td>
          <td class='center'>aksi</td>
          </tr></thead>";

    $p      = new Paging;
    $batas  = 1000;
    $posisi = $p->cariPosisi($batas);

    if ($_SESSION['level']=='anggota'){
      $tampil = mysql_query("SELECT jadwal.id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama ,jadwal.lama
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id 
         WHERE tanggal LIKE '%$_GET[tanggal]%' ORDER BY jadwal.tanggal,jadwal.sppd DESC LIMIT $posisi,$batas");
    }
    else{
      $tampil=mysql_query("SELECT jadwal.id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama ,jadwal.lama
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id 
        WHERE username='$_SESSION[user]' AND tanggal LIKE '%$_GET[tanggal]%'       
        ORDER BY jadwal.tanggal,jadwal.sppd DESC LIMIT $posisi,$batas");
    }
  
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      // $tgl_posting=tgl_indo($r['tanggal']);
      echo "<tr><td class='left'>$no</td>
                <td class='left'>$r[tanggal]</td>
                <td class='left'>$r[lama] hari</td>
                <td class='left'>$r[sppd]</td>
                <td class='left'>$r[kegiatan]</td>
                <td class='left'>$r[tujuan]</td>
                 <td class='left'>$r[nama]</td>
                <td class='center' width='115'>
                <a href=?module=jadwal&act=add&id=$r[id]><img src='images/user.png' border='0' title='tambah' /></a>";

        if ($_SESSION['blokir']=='N'){
        echo "  
                <a href=?module=jadwal&act=edit&id=$r[id]><img src='images/edit.png' border='0' title='edit' /></a> 
                <a href=\"$aksi?module=jadwal&act=hapus&id=$r[id]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>";
        }
        echo "</td>
            </tr>";
      $no++;
    }
    echo "</table>";

    if ($_SESSION['level']=='anggota'){
      $jmldata = mysql_num_rows(mysql_query("SELECT * FROM jadwal WHERE tanggal LIKE '%$_GET[tanggal]%'"));
    }
    else{
      $jmldata = mysql_num_rows(mysql_query("SELECT * FROM jadwal WHERE  tanggal LIKE '%$_GET[tanggal]%'"));
    }  
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);

    echo "<div class=\"pagination\"> $linkHalaman</div>";
 
    break;    
    }

//=============== input ==============================================================================================================
  
  case "tambah":
    echo "<h2>Input</h2>
          <form method=POST action='$aksi?module=jadwal&act=input' id='usrform' enctype='multipart/form-data'>
          <table class='list'><tbody> ";

    $tanggal = date('Y-m-d');
    
    echo "<tr><td>Tanggal</td>
          <td><input type=text  name='tanggal' id=tanggal value= $tanggal > 
          </td></tr>";
         
    echo "<tr><td>Waktu</td>
          <td><input type=text  name='lama' value=1 > 
          </td></tr>

          <tr><td>Nama</td>  
          <td><select name='anggota'>
            <option value=0 selected>- Pilih anggota -</option>";
            $tampil=mysql_query("SELECT * FROM anggota ORDER BY nama asc ");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[id]>$r[nama]</option>";
            }
    echo "</select></td></tr>";

    echo "<tr><td>Kegiatan </td>
          <td><textarea name='kegiatan' form='usrform'> </textarea>
          </td></tr>";

    echo "<tr><td>Tujuan </td>
          <td><textarea name='tujuan' form='usrform'> </textarea>
          </td></tr>";
    
    echo "</td></tr> 
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </tbody></table></form>";
     break;


//======================================== tambah anggota ===========================================
      case "add":
    if ($_SESSION['level']=='anggota'){
      $edit = mysql_query(" SELECT jadwal.id, jadwal.anggota_id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama 
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id   
        WHERE jadwal.id ='$_GET[id]'");
    }
    
    $r    = mysql_fetch_array($edit);

    echo "<h2>Tambah</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=jadwal&act=add>
          <input type=hidden name=id value=$r[id]>
          <input type=hidden name='tanggal' size=60 value='$r[tanggal]'>
          <input type=hidden name='sppd' size=60 value='$r[sppd]'>
          <input type=hidden name='kegiatan' size=60 value='$r[kegiatan]'>
          <input type=hidden name='tujuan' size=60 value='$r[tujuan]'>
          <table class='list'><tbody>

          <tr><td class='left'>Anggota</td> <td class='left'>  
           <select name='anggota'>
           <option value=0 selected > Pilih Anggota </option>";
            $tampil=mysql_query("SELECT * FROM anggota WHERE id <> $r[anggota_id]
            AND id NOT IN (SELECT anggota_id FROM jadwal WHERE tanggal= '$r[tanggal]') ORDER BY nama asc ");
            while($s=mysql_fetch_array($tampil)){
              echo "<option value=$s[id]>$s[nama]</option>";
            }
    echo "</select></td></tr>";

    echo  "<tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </tbody></table></form>";
    break;  
    
//====================== EDIT =======================================================================    
  case "edit":
    if ($_SESSION['level']=='anggota'){
      $edit = mysql_query(" SELECT jadwal.id,jadwal.lama, jadwal.anggota_id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama 
        FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id   
        WHERE jadwal.id ='$_GET[id]'");
    }
    // else{
    //   $edit = mysql_query(" SELECT jadwal.id, jadwal.tanggal, jadwal.sppd, jadwal.kegiatan, jadwal.tujuan, anggota.nama 
    //     FROM jadwal inner join anggota ON anggota.id=jadwal.anggota_id  
    //     WHERE jadwal.id ='$_GET[id]' ");
    // }

    $r    = mysql_fetch_array($edit);

    echo "<h2>Edit</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=jadwal&act=update>
          <input type=hidden name=id value=$r[id]>
          <table class='list'><tbody>

          <tr><td>Anggota</td>  <td>  
           <select name='anggota'>
            <option value=$r[anggota_id] selected> $r[nama]</option>";
            $tampil=mysql_query("SELECT * FROM anggota  ORDER BY id asc");
            while($s=mysql_fetch_array($tampil)){
              echo "<option value=$r[id]>$s[nama]</option>";
            }
    echo "</select></td></tr>";

     echo "<tr><td width=70>Waktu</td><td> : <input type=text name='lama'  size=60 value='$r[lama]'></td></tr>";

    echo "<tr><td width=70>tanggal</td><td> : <input type=text name='tanggal' id=tanggal size=60 value='$r[tanggal]'></td></tr>";
    echo "<tr><td width=70>SPPD</td><td> : <input type=text name='sppd' size=60 value='$r[sppd]'></td></tr>";
    echo "<tr><td width=70>Kegiatan</td><td> : <input type=text name='kegiatan' size=60 value='$r[kegiatan]'></td></tr>";
    echo "<tr><td width=70>Tujuan</td><td> : <input type=text name='tujuan' size=60 value='$r[tujuan]'></td></tr>";
  
    echo  "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
         </tbody></table></form>";
    break;  

}
}
?>
