<?php
// Validasi Login
include_once "library/inc.seslogin.php";
// Koneksi database
include_once "library/inc.connection.php";

// Jika data Kode ditemukan dari URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	// Hapus data sesuai Kode yang terbaca
    $koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
	$mySql = "delete FROM penerbit WHERE kd_penerbit='$Kode'";
    //$mySql = "delete from penerbit where kd_penerbit = $Kode";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Eror hapus data".mysqli_error($koneksidb));
	if($myQry){
		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Penerbit-Data'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>