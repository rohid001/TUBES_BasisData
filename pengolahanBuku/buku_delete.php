<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 

// Membaca data dari URL
//$Kode	= $_GET['Kode'];
if(isset( $_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	// Skrip Menghapus Foto/Gambar Siswa
	//$mySql = "SELECT * FROM buku WHERE kd_buku='$Kode'";
    $mySql = "select * from buku where kd_buku = '$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_error($koneksidb));
	$myData= mysqli_fetch_array($myQry);
	
	$fileGambar	= $myData['file_gambar'];
	if(! $fileGambar =="") {
		if(file_exists("cover/$fileGambar")) {
			// Jika file gambarnya ada, akan dihapus
			unlink("cover/$fileGambar"); 
		}
	}
	// Skrip menghapus data dari tabel database
	//$mySql = "DELETE FROM buku WHERE kd_buku='$Kode'";
    $mySql = "delete from buku where kd_buku='$Kode'";
	mysqli_query($koneksidb,$mySql) or die ("Error query delete 1".mysqli_error($koneksidb));
	
	// Skrip menghapus data dari tabel database
	//$mySql = "DELETE FROM buku_inventaris WHERE kd_buku='$Kode'";
    $mySql = "delete from buku_inventaris where kd_buku='$Kode'";
	mysqli_query($koneksidb,$mySql) or die ("Error query delete 2".mysqli_error($koneksidb));
	
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Buku-Data'>";
}
else {
	echo "Data yang dihapus tidak ada";
}
?>
