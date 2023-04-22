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

$id_produk = htmlspecialchars($_GET['id_produk']);
$type = htmlspecialchars($_GET['type']);

$hapus_produk = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk'");

if ($hapus_produk) {
	setAlert("Berhasil!", "Produk berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "produk/index.php?".$type);
	exit;
} else {
	setAlert("Gagal!", "Produk gagal dihapus!", "error");
	header("Location:" . BASE_URL . "produk/index.php?".$type);
	exit;
}

?>