<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}


$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$id_detail_transaksi = htmlspecialchars($_GET['id_detail_transaksi']);

$data_detail_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'"));
$id_produk = $data_detail_transaksi['id_produk'];
$jumlah = $data_detail_transaksi['jumlah'];
$subtotal = $data_detail_transaksi['subtotal'];

$data_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk LEFT OUTER JOIN jenis_saldo ON produk.id_jenis_saldo = jenis_saldo.id_jenis_saldo WHERE produk.id_produk = '$id_produk'"));
$id_jenis_saldo = $data_produk['id_jenis_saldo'];
$harga_jual = $data_produk['harga_jual'];

$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = total_harga - '$subtotal' WHERE id_transaksi = '$id_transaksi'");

$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok = stok + '$jumlah' WHERE id_produk = '$id_produk'");

$update_jenis_saldo = mysqli_query($koneksi, "UPDATE jenis_saldo SET jumlah_saldo = jumlah_saldo + '$harga_jual' WHERE id_jenis_saldo = '$id_jenis_saldo'");

$hapus_detail_transaksi = mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'");

if ($hapus_detail_transaksi) {
	setAlert("Berhasil!", "Transaksi Produk berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
	exit;
} else {
	setAlert("Gagal!", "Transaksi Produk gagal dihapus!", "error");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=$id_transaksi");
	exit;
}

?>