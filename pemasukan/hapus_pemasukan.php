<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}


if ($_SESSION['hak_akses'] != 'administrator') {
	setAlert("Perhatian!", "Tidak dapat melakukan perubahan selain Administrator!", "error");
	echo "
		<script>
			window.history.back();
		</script>
	";
	exit;
}

$id_pemasukan = htmlspecialchars($_GET['id_pemasukan']);

$get_jumlah_pemasukan_old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pemasukan WHERE id_pemasukan = '$id_pemasukan'"));
$jumlah_pemasukan = $get_jumlah_pemasukan_old['jumlah_pemasukan'];
$id_barang = $get_jumlah_pemasukan_old['id_barang'];

$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang - '$jumlah_pemasukan' WHERE id_barang = '$id_barang'");

$hapus_pemasukan = mysqli_query($koneksi, "DELETE FROM pemasukan WHERE id_pemasukan = '$id_pemasukan'");

if ($hapus_pemasukan) {
	setAlert("Berhasil!", "Pemasukan Barang berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "pemasukan/index.php");
	exit;
} else {
	setAlert("Gagal!", "Pemasukan Barang gagal dihapus!", "error");
	header("Location:" . BASE_URL . "pemasukan/index.php");
	exit;
}

?>