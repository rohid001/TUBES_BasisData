<?php
// Periksa session Login dan Koneksi
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
?>
<h2> LAPORAN DATA PENERBIT</h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="513" bgcolor="#CCCCCC"><strong>Nama Penerbit </strong></td>
  </tr>
  
<?php
// Skrip menampilkan data Penerbit
$mySql 	= "SELECT * FROM penerbit ORDER BY kd_penerbit ASC";
$myQry 	= mysqli_query($koneksidb,$mySql)  or die ("Query  salah : ".mysqli_error($koneksidb));
$nomor  = 0; 
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
?>

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_penerbit']; ?> </td>
	<td> <?php echo $myData['nm_penerbit']; ?> </td>
  </tr>
  
<?php } ?>

</table>
<br />
<!--<a href="cetak/penerbit.php" target="_blank">Cetak</a>-->