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

$id_jenis_barang = htmlspecialchars($_GET['id_jenis_barang']);

$hapus_jenis_barang = mysqli_query($koneksi, "DELETE FROM jenis_barang WHERE id_jenis_barang = '$id_jenis_barang'");

if ($hapus_jenis_barang) {
	setAlert("Berhasil!", "Jenis Barang berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "jenis_barang/index.php");
	exit;
} else {
	setAlert("Gagal!", "Jenis Barang gagal dihapus!", "error");
	header("Location:" . BASE_URL . "jenis_barang/index.php");
	exit;
}

?>