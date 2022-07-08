<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
$koneksidb = mysqli_connect("localhost", "root", "", "perpustakaandb"); 
# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Membaca Variabel Form
  $kdMahasiswa  = $_POST['kdMahasiswa'];
	$txtNim				= $_POST['txtNim'];
	$txtNama			= $_POST['txtNama'];
	$cmbKelamin			= $_POST['cmbKelamin'];
	$cmbAgama			= $_POST['cmbAgama'];
	$txtTempatLahir		= $_POST['txtTempatLahir'];
	$txtTanggal			= InggrisTgl($_POST['txtTanggal']);
	$txtAlamat			= $_POST['txtAlamat'];
	$txtNoTelepon		= $_POST['txtNoTelepon'];
	$cmbAngkatan		= $_POST['cmbAngkatan'];
	$cmbStatus			= $_POST['cmbStatus'];
	
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Mahasiswa</b> tidak boleh kosong !";		
	}
	else {
		# Validasi NIM Mahasiswa, jika sudah ada akan ditolak
		//$cekSql	= "SELECT * FROM mahasiswa WHERE nim='$txtNim'";
        $cekSql	= "select * from mahasiswa where nim='$txtNim'";
		$cekQry	= mysqli_query($koneksidb,$cekSql) or die ("Error Query".mysqli_error($koneksidb)); 
		if(mysqli_num_rows($cekQry)>=1){
			$pesanError[] = "Maaf, NIM <b> $txtNim </b> sudah terpakai, ganti dengan yang lain";
		}
	}
	if (trim($cmbAgama)=="Kosong") {
		$pesanError[] = "Data <b>Agama</b> tidak boleh kosong !";		
	}	
	if (trim($txtTempatLahir)=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";		
	}
	if (trim($txtTanggal)=="") {
			$pesanError[] = "Data <b>Tgl. Lahir</b> tidak boleh kosong !";			
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";		
	}
	if (trim($txtNoTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
	}
	if(trim($cmbAngkatan)=="Kosong") {
		$pesanError[] = "Data <b>Tahun Angkatan</b> belum dipilih !";		
	}
	if (trim($cmbStatus)=="Kosong") {
		$pesanError[] = "Data <b>Status Aktif</b> tidak boleh kosong !";		
	}	
	
	# Menampilkan pesan Error dari validasi
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		//$kodeBaru	= "";//buatKode("mahasiswa", "M");


		# SKRIP UNTUK MENYIMPAN FOTO/GAMBAR
		if (! empty($_FILES['namaFile']['tmp_name'])) {
			// Membaca nama file foto/gambar
			$file_foto = $_FILES['namaFile']['name'];
			$file_foto = stripslashes($file_foto);
			$file_foto = str_replace("'","",$file_foto);
			
			// Simpan gambar
			$file_foto = $kodeBaru.".".$file_foto;
			copy($_FILES['namaFile']['tmp_name'],"foto/".$file_foto);
		}
		else {
			// Jika tidak ada foto/gambar
			$file_foto = "";
		}
		
		# Skrip untuk menyimpan data ke database
		$mySql	= "insert into mahasiswa (kd_mahasiswa, nim, nm_mahasiswa, kelamin, agama, tempat_lahir, 
									  tanggal_lahir, alamat, no_telepon, foto, th_angkatan,  status_aktif, status_pinjam) 
					VALUES('$kdMahasiswa', '$txtNim', '$txtNama', '$cmbKelamin', '$cmbAgama', '$txtTempatLahir', 
							'$txtTanggal', '$txtAlamat', '$txtNoTelepon', '$file_foto', '$cmbAngkatan',  '$cmbStatus', 'Bebas')";
		$myQry	= mysqli_query($koneksidb,$mySql) or die ("Gagal Query".mysqli_error($koneksidb)); 
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Mahasiswa-Data'>";
		}
		exit;
	}	
}

# VARIABEL DATA UNTUK DIBACA FORM
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah

// Data untuk form, datanya dari dalam Form itu sendiri
$dataKode		= buatKode("mahasiswa", "M");
$dataNim		= isset($_POST['txtNim']) ? $_POST['txtNim'] : '';
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAgama		= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : '';
$dataAlamat		= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataAngkatan	= isset($_POST['cmbAngkatan']) ? $_POST['cmbAngkatan'] : date('Y');
$dataStatus		= isset($_POST['cmbStatus']) ? $_POST['cmbStatus'] : '';

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data" >
  <table width="100%" class="table-list" border="0" cellpadding="4" cellspacing="1">
    <tr>
      <th colspan="3" scope="col">TAMBAH DATA MAHASISWA </th>
    </tr>
    <tr>
      <td width="231"><strong>Kode</strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="967"><input name="kdMahasiswa" value="<?php echo $dataKode; ?>" size="10" maxlength="10"/></td>
    </tr>
    <tr>
      <td><strong>NIM Mhs </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNim" value="<?php echo $dataNim; ?>" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Nama Mhs </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Kelamin</strong></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbKelamin">
          <?php
		  $pilihan	= array("L" => "Laki-laki (L)", "P" => "Perempuan (P)");
          foreach ($pilihan as $nilai => $judul) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek> $judul</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbAgama">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Islam", "Kristen", "Katolik", "Hindu", "Budha");
          foreach ($pilihan as $nilai) {
            if ($dataAgama==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Tempat, Tgl. Lahir </b></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLahir" type="text" value="<?php echo $dataTempatLahir; ?>" size="50" maxlength="100" />
      , 
      <input type="text" name="txtTanggal" class="tcal" value="<?php echo $dataTanggal; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" type="text" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoTelepon" value="<?php echo $dataNoTelepon; ?>" size="40" maxlength="20" /></td>
    </tr>
    <tr>
      <td><strong>Foto Mahasiswa </strong></td>
      <td><strong>:</strong></td>
      <td><input name="namaFile" type="file" size="60" /></td>
    </tr>
    <tr>
      <td><strong>Tahun Angkatan </strong></td>
      <td><b>:</b></td>
      <td><select name="cmbAngkatan">
          <option value="Kosong">....</option>
          <?php 
		for ($thn = date('Y') - 4; $thn <= date('Y'); $thn++) {
			if($thn==$dataAngkatan) { $cek=" selected";} else { $cek="";}
			echo "<option value='$thn' $cek>$thn</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td><b>Status (Aktif/ Alumni)</b></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbStatus">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Aktif", "Alumni");
          foreach ($pilihan as $nilai) {
            if ($dataStatus==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
