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

$id_user = htmlspecialchars($_GET['id_user']);

// check if admin cannot delete
$check_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
$username = $check_admin['username'];

if ($check_admin['hak_akses'] == 'administrator') {
	setAlert("Perhatian!", "Administrator tidak boleh dihapus!", "error");
	echo "
		<script>
			window.history.back();
		</script>
	";
	exit;
}

$hapus_user = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

if ($hapus_user) {
	setAlert("Berhasil!", "User ".$username." berhasil dihapus!", "success");
	header("Location:" . BASE_URL . "user/index.php");
	exit;
} else {
	setAlert("Gagal!", "User ".$username." gagal dihapus!", "error");
	header("Location:" . BASE_URL . "user/index.php");
	exit;
}

?>