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

$id_barang = htmlspecialchars($_GET['id_barang']);

$hapus_barang = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = '$id_barang'");
if ($hapus_barang) {
	setAlert("Berhasil!", "Barang berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "barang/index.php");
	exit;
} else {
	setAlert("Gagal!", "Barang gagal dihapus!", "error");
	header("Location:" . BASE_URL . "barang/index.php");
	exit;
}

?>