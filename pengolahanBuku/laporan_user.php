<?php
// Periksa session Login dan Koneksi
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
?>
<h2> LAPORAN DATA USER</h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="20" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="40" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="336" bgcolor="#CCCCCC"><strong>Nama User </strong></td>
    <td width="175" bgcolor="#CCCCCC"><strong>User Login </strong></td>
  </tr>
  
<?php
// Skrip menampilkan data User
$mySql 	= "select * FROM user ORDER BY kd_user ASC";
$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_error($koneksidb));
$nomor  = 0; 
while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
?>

  <tr>
	<td> <?php echo $nomor; ?> </td>
	<td> <?php echo $myData['kd_user']; ?> </td>
	<td> <?php echo $myData['nm_user']; ?> </td>
	<td> <?php echo $myData['username']; ?> </td>
  </tr>
  
<?php } ?>
</table>
<br />
<!--<a href="cetak/user.php" target="_blank">Cetak</a>-->