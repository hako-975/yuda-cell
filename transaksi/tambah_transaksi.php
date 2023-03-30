<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
<<<<<<< HEAD
	header("Location: login.php");
=======
	header("Location: ".BASE_URL."login.php");
>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
	exit;
}

$tanggal_transaksi = date('Y-m-d H:i:s');

$id_user = htmlspecialchars($_SESSION['id_user']);

$tambah_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi VALUES('', '$tanggal_transaksi', '', '', '', '$id_user')");
$id_transaksi = mysqli_insert_id($koneksi);
if ($tambah_transaksi) {
<<<<<<< HEAD
	echo "
		<script>
			window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
		</script>
	";
} else {
=======
	setAlert("Berhasil!", "Transaksi berhasil ditambahkan!", "success");
	header("Location:" . BASE_URL . "transaksi/detail_transaksi.php?id_transaksi=".$id_transaksi);
	exit;
} else {
	setAlert("Gagal!", "Transaksi gagal ditambahkan!", "error");
>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
	echo "
		<script>
			window.history.back();
		</script>
	";
<<<<<<< HEAD
=======
	exit;
>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
}

?>