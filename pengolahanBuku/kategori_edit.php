<?php
// Periksa session Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";

# SKRIP TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# BACA DATA DARI FORM
	$txtNama	= $_POST['txtNama'];
	
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
		$txtKode= $_POST['txtKode'];
		//$mySql	= "UPDATE kategori SET nm_kategori='$txtNama' WHERE kd_kategori ='$txtKode'";
        $mySql = "update kategori set nm_kategori ='$txtNama' where kd_kategori = '$txtKode'";
		$myQry	= mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
		}
		exit;	
	}
}

# MEMBUAT VARIABEL KOTAK FORM 
# TAMPILKAN DATA UNTUK DIEDIT
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
$Kode	 = $_GET['Kode']; 
//$mySql	 = "SELECT * FROM kategori WHERE kd_kategori='$Kode'";
$mySql = "select * from kategori where kd_kategori='$Kode'";
$myQry	 = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_error($koneksidb));
$myData	 = mysqli_fetch_array($myQry); 

	// Membuat data untuk dibaca pada kotak form
	$dataKode	= $myData['kd_kategori'];
	$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_kategori'];
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table class="table-list" width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>UBAH  DATA KATEGORI </strong></td>
    </tr>
    <tr>
      <td width="133">Kode</td>
      <td width="3">:</td>
      <td width="492"><input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="4" />
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>" /></td>
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
