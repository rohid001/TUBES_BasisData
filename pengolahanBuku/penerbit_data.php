<?php
// Validasi Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";
?>
<table width="700" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><h1> DATA PENERBIT</h1></td>
  </tr>
  <tr>
    <td align="right"><a href="?open=Penerbit-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="8%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="72%" bgcolor="#CCCCCC"><strong>Nama Penerbit </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
		
		<?php
		// Skrip menampilkan data Penerbit
		//$mySql 	= "SELECT * FROM penerbit ORDER BY kd_penerbit ASC";
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
        $mySql = "select * from penerbit order by kd_penerbit asc";
		$myQry 	= mysqli_query($koneksidb,$mySql)  or die ("Query  salah : ".mysqli_error($koneksidb));
		$nomor  = 0; 
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_penerbit'];
		?>
		
	  <tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['kd_penerbit']; ?> </td>
		<td> <?php echo $myData['nm_penerbit']; ?> </td>
		<td width="8%" align="center"><a href="?open=Penerbit-Delete&Kode=<?php echo $Kode; ?>" 
			target="_self" onclick="return confirm('YAKIN INGIN MENGHAPUS DATA PENERBIT INI ... ?')">Delete</a></td>
			
		<td width="8%" align="center"><a href="?open=Penerbit-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
	  </tr>
	 <?php } ?>
    </table></td>
  </tr>
</table>
