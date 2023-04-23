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
$type = htmlspecialchars($_GET['type']);

$get_pemasukan_old = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pemasukan WHERE id_pemasukan = '$id_pemasukan'"));
$jumlah = $get_pemasukan_old['jumlah'];

if ($type == 'stok') {
	$id_produk = $get_pemasukan_old['id_produk'];
	$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok = stok - '$jumlah' WHERE id_produk = '$id_produk'");
} else {
	$id_jenis_saldo = $get_pemasukan_old['id_jenis_saldo'];
	$update_jenis_saldo = mysqli_query($koneksi, "UPDATE jenis_saldo SET jumlah_saldo = jumlah_saldo - '$jumlah' WHERE id_jenis_saldo = '$id_jenis_saldo'");
}


$hapus_pemasukan = mysqli_query($koneksi, "DELETE FROM pemasukan WHERE id_pemasukan = '$id_pemasukan'");

if ($hapus_pemasukan) {
	setAlert("Berhasil!", "Pemasukan berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "pemasukan/index.php?".$type);
	exit;
} else {
	setAlert("Gagal!", "Pemasukan gagal dihapus!", "error");
	header("Location:" . BASE_URL . "pemasukan/index.php?".$type);
	exit;
}

?>