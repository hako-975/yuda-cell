<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}


$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$id_detail_transaksi = htmlspecialchars($_GET['id_detail_transaksi']);

$data_detail_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'"));
$id_barang = $data_detail_transaksi['id_barang'];
$kuantitas = $data_detail_transaksi['kuantitas'];
$subtotal = $data_detail_transaksi['subtotal'];

$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = total_harga - '$subtotal' WHERE id_transaksi = '$id_transaksi'");

$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang + '$kuantitas' WHERE id_barang = '$id_barang'");

$hapus_detail_transaksi = mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'");

if ($hapus_detail_transaksi) {
	setAlert("Berhasil!", "Transaksi Barang berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
	exit;
} else {
	setAlert("Gagal!", "Transaksi Barang gagal dihapus!", "error");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
	exit;
}

?>