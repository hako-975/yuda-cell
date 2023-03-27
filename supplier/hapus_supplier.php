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


$id_supplier = htmlspecialchars($_GET['id_supplier']);

$hapus_supplier = mysqli_query($koneksi, "DELETE FROM supplier WHERE id_supplier = '$id_supplier'");

if ($hapus_supplier) {
	setAlert("Berhasil!", "Supplier berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "supplier/index.php");
	exit;
} else {
	setAlert("Gagal!", "Supplier gagal dihapus!", "error");
	header("Location:" . BASE_URL . "supplier/index.php");
	exit;
}

?>