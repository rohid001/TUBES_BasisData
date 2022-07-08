<?php
// Periksa session Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# BACA DATA DARI FORM
	$txtNama	= $_POST['txtNama'];
	$kodeKategori = $_POST['kodeKategori'];
	
	# VALIDASI KOTAK FORM
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong !";		
	}

	# MENAMPILKAN PESAN ERROR
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
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
		//$kodeBaru	= buatKode("kategori", "K");
		$kodeBaru = "K";
		//$mySql	= "INSERT INTO kategori (kd_kategori, nm_kategori) VALUES('$kodeBaru', '$txtNama')";
        $mySql = "insert into kategori (kd_kategori, nm_kategori) values('$kodeKategori','$txtNama')";
		$myQry	= mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Add'>";
		} 
		exit;	
	}
}

# MEMBUAT VARIABEL KOTAK FORM 
$dataKode	= buatKode("kategori", "K");
//$DataKode = "";
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>TAMBAH DATA KATEGORI </strong></td>
    </tr>
    <tr>
      <td width="133">Kode</td>
      <td width="3">:</td>
      <td width="492"><input name="kodeKategori" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" /></td>
    </tr>
    <tr>
      <td>Nama Kategori </td>
      <td>:</td>
      <td><input name="txtNama" type="text" id="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="btnSimpan" type="submit" id="btnSimpan" value="Simpan" /></td>
    </tr>
  </table>
</form>
