<?php
session_start();
 if (empty($_SESSION['user']) AND empty($_SESSION['pass'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

$aksi="modul/mod_users/aksi_users.php";
switch($_GET[act]){
  // Tampil User
  default:
    if ($_SESSION[blokir]=='N' ){
      $tampil = mysql_query("SELECT * FROM anggota ORDER BY nama asc");
      echo "<h2>User</h2>
          <input type=button value='Tambah User' onclick=\"window.location.href='?module=anggota&act=tambahuser';\">";
    }
    else{
      $tampil=mysql_query("SELECT * FROM anggota ");
      echo "<h2>User</h2>";
    }
    
    echo "<table class='list'><thead>
          <tr>
          <td class='left'>no</td>
          <td class='left'>nama</td>
          <td class='left'>username</td>
          <td class='left'>blokir</td>
          <td class='center'>aksi</td>
          </tr></thead> "; 
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td class='left' width='25'>$no</td>
             <td class='left'>$r[nama]</td>
             <td class='left'>$r[username]</td>
             <td class='left'>$r[blokir]</td>
             <td class='center' width='50'><a href=?module=anggota&act=edituser&id=$r[id]><img src='images/edit.png' border='0' title='edit' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  case "tambahuser":
    if ($_SESSION[blokir]=='N'){
    echo "<h2>Tambah Anggota</h2>
          <form method=POST action='$aksi?module=anggota&act=input'>
          <table class='list'>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30></td></tr>  
          <tr><td>Username</td>     <td> : <input type=text name='username'></td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'></td></tr>
         <tr><td>Blokir</td>   <td> : <input type=text name='blokir' size=20 value='Y'></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    }
    else{
      echo "Anda tidak berhak mengakses halaman ini.";
    }
     break;
    
  case "edituser":
    $edit=mysql_query("SELECT * FROM anggota WHERE id='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    if ($_SESSION[blokir]=='N'){
    echo "<h2>Edit Anggota</h2>
          <form method=POST action=$aksi?module=anggota&act=update>
          <input type=hidden name=id value='$r[id]'>
          <table class='list'>
          
          <tr><td class='left'>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30  value='$r[nama]'></td></tr>
          <tr><td class='left'>Username</td>     <td> : <input type=text name='username' value='$r[username]' > **)</td></tr>
          <tr><td class='left'>Password</td>     <td> : <input type=text name='password'> *) </td></tr>
         ";

    if ($r[blokir]=='N'){
      echo "<tr><td class='left'>Blokir</td>     <td> : <input type=radio name='blokir' value='Y'> Y   
                                           <input type=radio name='blokir' value='N' checked> N </td></tr>";
    }
    else{
      echo "<tr><td class='left'>Blokir</td>     <td> : <input type=radio name='blokir' value='Y' checked> Y  
                                          <input type=radio name='blokir' value='N'> N </td></tr>";
    }
    
    echo "<tr><td class='left' colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br />
                            **) Username tidak bisa diubah.</td></tr>
          <tr><td class='left' colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
    }
    else{
    echo "<h2>Edit User</h2>
          <form method=POST action=$aksi?module=user&act=update>
          <input type=hidden name=id value='$r[id_session]'>
          <input type=hidden name=blokir value='$r[blokir]'>
          <table>
          <tr><td class='left'>Username</td>     <td> : <input type=text name='username' value='$r[username]' disabled> **)</td></tr>
          <tr><td class='left'>Password</td>     <td> : <input type=text name='password'> *) </td></tr>
          <tr><td class='left'>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30  value='$r[nama_lengkap]'></td></tr>
          <tr><td class='left'>E-mail</td>       <td> : <input type=text name='email' size=30 value='$r[email]'></td></tr>
          <tr><td class='left'>No.Telp/HP</td>   <td> : <input type=text name='no_telp' size=30 value='$r[no_telp]'></td></tr>";    
    echo "<tr><td class='left' colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br />
                            **) Username tidak bisa diubah.</td></tr>
          <tr><td class='left' colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     
    }
    break;  
}
}
?>
