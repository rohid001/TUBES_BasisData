<?php
include_once "../library/inc.seslogin.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb");

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];
	
	// ========================================================
	// Membaca Kode Siswa
	$mySql = "SELECT * FROM peminjaman WHERE no_peminjaman='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error SQl baca data".mysqli_error($koneksidb));
	$myData= mysqli_fetch_array($myQry);
		$kodeMhs	= $myData['kd_mahasiswa'];
		$kodeBuku	= $myData['kd_inventaris'];
	
	// Update status Pinjam Siswa (Bebas artinya Tidak Sedang Pinjam)
	$editSql = "update mahasiswa SET status_pinjam ='Bebas' WHERE kd_mahasiswa='$kodeMhs'";
	mysqli_query($koneksidb, $editSql) or die ("Gagal Query edit Siswa ".mysqli_error($koneksidb));
	// ========================================================
	
	// Update status buku (Tersedia artinya Tidak Dipinjam)
	$edit2Sql = "update buku_inventaris SET status ='Tersedia' WHERE kd_inventaris='$kodeBuku'";
	mysqli_query($koneksidb, $edit2Sql) or die ("Gagal Query  ".mysqli_error($koneksidb));
	
	// Hapus Transaksi Peminjaman
	$hapusSql = "delete FROM  peminjaman WHERE no_peminjaman='$Kode'";
	mysqli_query($koneksidb, $hapusSql) or die ("Gagal Query ".mysqli_error($koneksidb));

	
	// Refresh halaman
	echo "<meta http-equiv='refresh' content='0; url=?open=Peminjaman-Tampil'>";
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>