<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$hapus_transaksi = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

if ($hapus_transaksi) {
	setAlert("Berhasil!", "Transaksi berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "transaksi/index.php");
	exit;
} else {
	setAlert("Gagal!", "Transaksi gagal dihapus!", "error");
	header("Location:" . BASE_URL . "transaksi/index.php");
	exit;
}

?>