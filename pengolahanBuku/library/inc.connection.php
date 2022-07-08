<?
$myHost = "localhost";
$myUser = "root";
$myPass = "";
$myDbs = "perpustakaandb";

$koneksidb = mysqli_connect($myHost, $myUser, $myPass);

/*if(!$koneksidb){
    echo"Koneski MySQL gagal, periksa Host/User. Password-nya!";
}*/
mysqli_select_db($koneksidb,$myDbs) or die ("koneksi gagal dilakukan : ".mysqli_error($koneksidb));
?>