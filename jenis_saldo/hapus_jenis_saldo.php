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

$id_jenis_saldo = htmlspecialchars($_GET['id_jenis_saldo']);

// check the saldo is used or not
$cek_produk_jenis_saldo = mysqli_query($koneksi, "SELECT * FROM pemasukan WHERE id_jenis_saldo = '$id_jenis_saldo'");

if (mysqli_num_rows($cek_produk_jenis_saldo) > 0) {
	setAlert("Gagal!", "Jenis Saldo gagal dihapus! Karena ada produk menggunakan Jenis Saldo", "error");
	header("Location:" . BASE_URL . "jenis_saldo/index.php");
	exit;
}

$hapus_saldo = mysqli_query($koneksi, "DELETE FROM jenis_saldo WHERE id_jenis_saldo = '$id_jenis_saldo'");

if ($hapus_saldo) {
	setAlert("Berhasil!", "Jenis Saldo berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "jenis_saldo/index.php");
	exit;
} else {
	setAlert("Gagal!", "Jenis Saldo gagal dihapus!", "error");
	header("Location:" . BASE_URL . "jenis_saldo/index.php");
	exit;
}

?>