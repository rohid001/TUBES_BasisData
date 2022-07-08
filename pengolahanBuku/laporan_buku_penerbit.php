<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
// Baca variabel URL browser
$kodePenerbit = isset($_GET['kodePenerbit']) ? $_GET['kodePenerbit'] : 'Semua'; 
// Baca variabel dari Form setelah di Post
$kodePenerbit = isset($_POST['cmbPenerbit']) ? $_POST['cmbPenerbit'] : $kodePenerbit;

// Membuat filter SQL
if ($kodePenerbit=="Semua") {
	//Query #1 (semua data)
	$filterSQL 	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " WHERE buku.kd_penerbit ='$kodePenerbit'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/buku_penerbit.php?kodePenerbit=$kodePenerbit', width=330)";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "select * FROM buku $filterSQL";
$pageQry 	= mysqli_query($koneksidb, $pageSql) or die("Error paging:".mysqli_error($koneksidb));
$jmlData	= mysqli_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> LAPORAN DATA BUKU PER PENERBIT </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="800" border="0"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="138"><strong> Penerbit </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="638">
	  <select name="cmbPenerbit">
        <option value="Semua">....</option>
        <?php
	  $bacaSql = "select * FROM penerbit ORDER BY nm_penerbit";
	  $bacaQry = mysqli_query($koneksidb, $bacaSql) or die ("Gagal Query".mysqli_error($koneksidb));
	  while ($bacaData = mysqli_fetch_array($bacaQry)) {
		if ($bacaData['kd_penerbit'] == $kodePenerbit) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_penerbit]' $cek>$bacaData[nm_penerbit]</option>";
	  }
	  ?>
      </select>
      <input name="btnTampilkan" type="submit" value=" Tampilkan  "/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <!--<td><input name="btnCetak" type="submit" value=" Cetak " /></td>-->
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="51" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="365" bgcolor="#CCCCCC"><strong>Judul Buku</strong></td>
    <td width="147" bgcolor="#CCCCCC"><strong>Penulis</strong></td>
    <td width="48" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="61" bgcolor="#CCCCCC"><strong>Halaman</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Th Terbit</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "select * FROM buku $filterSQL ORDER BY kd_buku ASC LIMIT $halaman, $baris";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_error($koneksidb));
	$nomor  = $halaman; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo $myData['kd_buku']; ?> </td>
    <td> <?php echo $myData['judul_buku']; ?> </td>
    <td> <?php echo $myData['penulis']; ?> </td>
    <td> <?php echo $myData['jumlah']; ?> </td>
    <td><?php echo format_angka($myData['jumlah_halaman']); ?></td>
    <td><?php echo $myData['tahun_terbit']; ?></td>
  </tr>
  <?php } ?>
  <tr class="selKecil">
    <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="4" align="right">
	<strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Buku-Penerbit&hal=$list[$h]&kodePenerbit=$kodePenerbit'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<!--<a href="cetak/buku_penerbit.php?kodePenerbit=<?php echo $kodePenerbit; ?>" target="_blank">Cetak</a>-->
