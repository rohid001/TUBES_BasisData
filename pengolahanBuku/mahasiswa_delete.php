<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
// Membaca data dari URL
$Kode	= $_GET['Kode'];
if(isset($Kode)){
	// Membaca data foto mahasiswa
	$mySql	 = "select * from mahasiswa WHERE kd_mahasiswa='$Kode'";
	$myQry	 = mysqli_query($koneksidb, $mySql)  or die ("Query baca data salah: ".mysqli_error($koneksidb));
	$myData	 = mysqli_fetch_array($myQry);
	
	// Menghapus file foto
	if(! $myData['foto']=="") {
		if(file_exists("foto/".$myData['foto'])) {
			unlink("foto/".$myData['foto']);	
		}
	}
			
	// Skrip menghapus data dari tabel database
	$hapusSql = "delete from mahasiswa WHERE kd_mahasiswa='$Kode'";
	mysqli_query($koneksidb, $hapusSql) or die ("Error query".mysqli_error($koneksidb));
	
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=?open=Mahasiswa-Data'>";
}
else {
	echo "Data yang dihapus tidak ada";
}
?>
