<?php
// Periksa session Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";

// Jika data Kode ditemukan dari URL (alamat browser)
if(isset($_GET['Kode'])){
    $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");
	$Kode	= $_GET['Kode'];
	// Hapus data sesuai Kode yang terbaca
	//$mySql = "DELETE FROM kategori WHERE kd_kategori='$Kode'";
    $mySql = "delete from kategori where kd_kategori = '$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_error($koneksidb));
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>