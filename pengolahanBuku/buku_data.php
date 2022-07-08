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
	$filterSQL 	= " AND buku.kd_penerbit ='$kodePenerbit'";
}

# ================================================================

# PENCARIAN DATA  
if(isset($_POST['btnCari'])) {
	$txtKataKunci	= trim($_POST['txtKataKunci']);

	$cariSQL 	= " AND ( buku.judul_buku LIKE '%".$txtKataKunci."%' OR buku.kd_buku ='$txtKataKunci' OR buku.isbn ='$txtKataKunci')";
	
	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$cariSQL	.= " OR buku.judul_buku LIKE '%$kata%'";
		} 
	}
}
else {
	//Query #1 (all)
	$cariSQL 		= "";
	$txtKataKunci	= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
//$pageSql 	= "SELECT * FROM buku WHERE kd_buku !=''  $filterSQL $cariSQL";
$pageSql = "select * from buku where kd_buku !='' $filterSQL $cariSQL";
$pageQry 	= mysqli_query($koneksidb, $pageSql) or die("Error paging:".mysqli_error($koneksidb));
$jmlData	= mysqli_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<h2> MANAJEMEN DATA BUKU </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="900" border="0"  class="table-list">
    <tr>
      <td bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="137"><strong> Penerbit </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="739">
	  <select name="cmbPenerbit">
        <option value="Semua">....</option>
		<?php
		// Skrip membaca data Penerbit
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
		//$bacaSql = "SELECT * FROM penerbit ORDER BY nm_penerbit";
        $bacaSql = "select * from penerbit order by nm_penerbit";
		$bacaQry = mysqli_query($koneksidb, $bacaSql) or die ("Gagal Query".mysqli_error($koneksidb));
		while ($bacaData = mysqli_fetch_array($bacaQry)) {
			if ($bacaData['kd_penerbit'] == $kodePenerbit) {
				$cek = " selected";
			} else { $cek=""; }
			
			$Kode = $bacaData['kd_penerbit'];
			// Menghitung jumlah Koleksi buku per Penerbit
			//$baca2Sql = "SELECT COUNT(*) As koleksi FROM buku WHERE kd_penerbit = '$Kode'";
            $baca2Sql = "select count(*) as koleksi from buku where kd_penerbit = '$Kode'";
			$baca2Qry = mysqli_query($koneksidb, $baca2Sql) or die ("Gagal Query".mysqli_error($koneksidb));
			$baca2Data= mysqli_fetch_array($baca2Qry);
		
		echo "<option value='$bacaData[kd_penerbit]' $cek>$bacaData[nm_penerbit] ( $baca2Data[koleksi] )</option>";
		}
		?>
      </select>
      <input name="btnTampilkan" type="submit" value=" Tampilkan  "/></td>
    </tr>
    <tr>
      <td><strong>Cari Judul  / ISBN</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKataKunci" type="text" value="<?php echo $txtKataKunci; ?>" size="40" maxlength="100" />
          <input name="btnCari" type="submit"  value=" Cari Buku " /></td>
    </tr>
  </table>
</form>

<table width="900" border="0" cellspacing="1" cellpadding="3" class="table-border">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><a href="?open=Buku-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0" /></a> </td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list"  width="900" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <th width="3%" bgcolor="#CCCCCC"><strong>No</strong></th>
        <th width="4%" bgcolor="#CCCCCC">&nbsp;</th>
        <th width="5%" bgcolor="#CCCCCC"><strong>Kode</strong></th>
        <th width="42%" bgcolor="#CCCCCC"><b>Judul Buku</b></th>
        <th width="19%" bgcolor="#CCCCCC"><strong>Penulis</strong></th>
        <th width="9%" bgcolor="#CCCCCC"><strong>Jumlah</strong></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
		// Skrip menampilkan data Buku dari database
        $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
		/*$mySql = "SELECT buku.*, penerbit.nm_penerbit FROM buku 
					LEFT JOIN penerbit ON buku.kd_penerbit = penerbit.kd_penerbit
					WHERE kd_buku !=''  $filterSQL $cariSQL
					ORDER BY buku.kd_buku ASC LIMIT $halaman, $baris";*/
        $mySql = "select buku.*, penerbit.nm_penerbit from buku left join penerbit
                    on buku.kd_penerbit = penerbit.kd_penerbit where kd_buku != ''
                    $filterSQL $cariSQL order by buku.kd_buku asc limit $halaman, $baris";
		$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_error($koneksidb));
		$nomor = $halaman; 
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_buku'];
			
			// Menghitung Koleksi Inventaris Buku
			//$my2Sql	= "SELECT COUNT(*) As jum_koleksi FROM buku_inventaris WHERE kd_buku = '$Kode'";
            $my2Sql = "select count(*) as jum_koleksi from buku_inventaris where kd_buku = '$Kode'";
			$my2Qry = mysqli_query($koneksidb, $my2Sql)  or die ("Query salah : ".mysqli_error($koneksidb));
			$my2Data= mysqli_fetch_array($my2Qry);
			
			// menampilkan gambar utama
			if ($myData['file_gambar']=="") {
				$fileGambar = "noimage.jpg";
			}
			else {
				$fileGambar	= $myData['file_gambar'];
			}
	
			// gradasi warna
			if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><img src="cover/<?php echo $fileGambar; ?>" width="28" height="39" border="0" /></td>
        <td><?php echo $myData['kd_buku']; ?></td>
        <td><?php echo $myData['judul_buku']; ?></td>
        <td><?php echo $myData['penulis']; ?></td>
        <td><?php echo $my2Data['jum_koleksi']; ?></td>
        <td width="6%" align="center"><a href="?open=Buku-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm(' YAKIN AKAN MENGHAPUS DATA BUKU INI ... ?')">Delete</a></td>
        <td width="6%" align="center"><a href="?open=Buku-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
        <td width="6%" align="center" bgcolor="<?php echo $warna; ?>"><a href="cetak/buku_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Buku-Data&hal=$list[$h]&kodePenerbit=$kodePenerbit'>$h</a> ";
	}
	?></td>
  </tr>
</table>
