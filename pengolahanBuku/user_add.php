<?php
// Validasi Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){		
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama	= $_POST['txtNama'];
	$txtUsername= $_POST['txtUsername'];
	$txtPassword= $_POST['txtPassword'];
	$KodeUser = $_POST['kdUser'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		//$kodeBaru	= buatKode("user", "U");
		$mySql = "insert into user (kd_user,nm_user, username, password)
					values('$KodeUser','$txtNama','$txtUsername','$txtPassword')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
		exit;
	}
}

# MEMBUAT VARIABEL KOTAK FORM 
$dataKode		= buatKode("user", "U");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>TAMBAH DATA USER </strong></td>
    </tr>
    <tr>
      <td width="132">Kode</td>
      <td width="3">:</td>
      <td width="493"><input name="kdUser" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="6"/></td>
    </tr>
    <tr>
      <td>Nama User </td>
      <td>:</td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td>Username</td>
      <td>:</td>
      <td><input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input name="txtPassword" type="password"  size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" Simpan " /></td>
    </tr>
  </table>
</form>
