<?php
// Periksa session Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";
?>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><h1>DATA KATEGORI</h1></td>
  </tr>
  <tr>
    <td><a href="?open=Kategori-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="4%" bgcolor="#CCCCCC"><strong>No</strong></td>
        <td width="9%" bgcolor="#CCCCCC"><strong>Kode</strong></td>
        <td width="69%" bgcolor="#CCCCCC"><strong>Nama Kategori </strong></td>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
		
		<?php
		// Skrip menampilkan data Kategori
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
		//$mySql 	= "SELECT * FROM kategori ORDER BY kd_kategori ASC";
        $mySql = "select * from kategori order by kd_kategori ASC";
		$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_error($koneksidb));
		$nomor  = 0; 
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_kategori'];
		?>

      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['kd_kategori']; ?> </td>
        <td> <?php echo $myData['nm_kategori']; ?> </td>
        <td width="9%"><a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" 
			 			onclick="return confirm('YAKIN INGIN MENGHAPUS DATA KATEGORI INI ... ?')">Delete</a></td>
        <td width="9%"><a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
      </tr>
	  <?php } ?>
    </table></td>
  </tr>
</table>
