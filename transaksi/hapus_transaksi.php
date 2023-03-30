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

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$hapus_transaksi = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

if ($hapus_transaksi) {
<<<<<<< HEAD
	echo "
		<script>
			alert('Transaksi berhasil dihapus!');
			window.location.href='transaksi.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Transaksi gagal dihapus!');
			window.location.href='transaksi.php';
		</script>
	";
=======
	setAlert("Berhasil!", "Transaksi berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "transaksi/index.php");
	exit;
} else {
	setAlert("Gagal!", "Transaksi gagal dihapus!", "error");
	header("Location:" . BASE_URL . "transaksi/index.php");
	exit;
>>>>>>> 7282410724e69b75a027036b2b0f3a084e11b25a
}

?>