<?php
// Validasi Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Data Form
	$txtNama	= $_POST['txtNama'];
	$kdPenerbit = $_POST['kdPenerbit'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Penerbit</b> tidak boleh kosong !";		
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
		# SIMPAN DATA KE DATABASE 
		//$kodeBaru = buatKode("penerbit", "P");
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
		$mySql	= "insert INTO penerbit (kd_penerbit, nm_penerbit) VALUES('$kdPenerbit', '$txtNama')";
        //$mySql = "inser into penerbit (kd_penerbit, nm_penerbit) values('$kodeBaru',$txtNama)";
		$myQry	= mysqli_query($koneksidb,$mySql) or die ("Gagal query".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Penerbit-Add'>";
		}
		exit;	
	}
}

# Variabel untuk kotak Form isian
$dataKode	= buatKode("penerbit", "P");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">TAMBAH DATA PENERBIT </th>
    </tr>
    <tr>
      <td width="134">Kode</td>
      <td width="3">:</td>
      <td width="491"><input name="kdPenerbit" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td>Nama Penerbit </td>
      <td>:</td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN " /></td>
    </tr>
  </table>
</form>
