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

$aksi="modul/mod_kelsurat/aksi_kelsurat.php";
if(isset($_GET['act'])) 
    { 
        $act = $_GET['act']; 
    }
 // var_dump($act);
switch($act){
  // Tampil User
  default:
    if ($_SESSION['blokir']=="N" ){
      $tampil = $mysqli->query("SELECT kode,kelompok FROM kelsurat ");
      echo "<h2>Kelompok Surat</h2>
          <input type=button value='Input' onclick=\"window.location.href='?module=kelsurat&act=tambahkelsurat';\">";
    }
    else{
      $tampil=$mysqli->query("SELECT kode,kelsurat FROM kelsurat ");
      echo "<h2>Kelompok Surat</h2>";
    }
    
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>no</td>
          <td class='left'>kode</td>
          <td class='left'>Kelompok</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td class='left' width='25'>$no</td>
             <td class='left'>$r[kode]</td>
             <td class='left'>$r[kelompok]</td>
             <td class='center' >
             <a href=?module=kelsurat&act=editkelsurat&id=$r[kode]><img src='images/edit.png' border='0' title='edit' /></a>
             <a href=\"$aksi?module=kelsurat&act=hapus&id=$r[kode]\" onClick=\"return confirm('Apakah Anda benar-benar mau menghapusnya?')\"><img src='images/del.png' border='0' title='hapus' /></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  




  case "tambahkelsurat":
  // var_dump("input");
    if ($_SESSION['blokir']=='N'){
    echo "<h2>Tambah Kelompok</h2>
          <form method=POST action='$aksi?module=kelsurat&act=input'>
          <table class='list'>
          <tr><td>Kode</td> <td> : <input type=text name='kode' size=30></td></tr>  
          <tr><td>Kelompok</td> <td> : <input type=text name='kelompok' size=30></td></tr>  
          <tr><td colspan=2><input type=submit value=Simpan>
          <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
    }
     break;



    
  case "editkelsurat":

  var_dump("edit");

    $edit=$mysqli->query("SELECT * FROM kelsurat WHERE kode='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
    // var_dump($r);
    if ($_SESSION['blokir']=='N'){
   
    echo "<h2>Edit kelsurat</h2>
          <form method=POST action=$aksi?module=kelsurat&act=update>
          <input type=text name=kode value='$r[kode]'>
          
          <table>
          <tr><td class='left'>Kode</td>     <td> : <input type=text  value='$r[kode]' disabled> **)</td></tr>
          <tr><td class='left'>Kelompok</td>     <td> : <input type=text name='kelompok'  value='$r[kelompok]'> </td></tr>";    
    
    echo "<tr><td class='left' colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
    }
    break;  




}
}
?>
