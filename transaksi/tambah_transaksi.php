<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$tanggal_transaksi = date('Y-m-d H:i:s');

$id_user = htmlspecialchars($_SESSION['id_user']);

$tambah_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi VALUES('', '$tanggal_transaksi', '', '', '', '$id_user')");
$id_transaksi = mysqli_insert_id($koneksi);
if ($tambah_transaksi) {
	setAlert("Berhasil!", "Transaksi berhasil ditambahkan!", "success");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=".$id_transaksi);
	exit;
} else {
	setAlert("Gagal!", "Transaksi gagal ditambahkan!", "error");
	header("Location:" . BASE_URL . "transaksi/index.php");
	exit;
}

?>