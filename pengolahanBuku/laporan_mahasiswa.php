<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

?>
<h2> LAPORAN DATA MAHASISWA </h2>
<br />

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="36" bgcolor="#CCCCCC"><strong>NIM</strong></td>
    <td width="162" bgcolor="#CCCCCC"><strong>Nama Mhs </strong></td>
    <td width="62" bgcolor="#CCCCCC"><strong>Kelamin</strong></td>
    <td width="311" bgcolor="#CCCCCC"><strong>Alamat</strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>No. Telepon </strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong> Status </strong></td>
  </tr>
	<?php
  $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
	// Skrip menampilkan data dari database
	$mySql 	= "select * FROM mahasiswa  ORDER BY kd_mahasiswa";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query salah 1 : ".mysqli_error($koneksidb));
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_mahasiswa'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nim']; ?></td>
    <td><?php echo $myData['nm_mahasiswa']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['status_aktif']; ?></td>
  </tr>
  <?php } ?>
</table>
<!--<a href="cetak/mahasiswa.php" target="_blank">Cetak</a>-->
