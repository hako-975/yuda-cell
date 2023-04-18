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

if (isset($_POST['btnTambahJenisSaldo'])) {
    $jenis_saldo = htmlspecialchars($_POST['jenis_saldo']);
	$jumlah_saldo = htmlspecialchars($_POST['jumlah_saldo']);

	$tambah_jenis_saldo = mysqli_query($koneksi, "INSERT INTO jenis_saldo VALUES('', '$jenis_saldo', '$jumlah_saldo')");

	if ($tambah_jenis_saldo) {
		setAlert("Berhasil!", "Jenis Saldo ".$jenis_saldo." berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "jenis_saldo/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Jenis Saldo gagal ditambahkan!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Jenis Saldo - Yuda Cell</title>
    <?php include_once '../include/head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include_once '../include/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include_once '../include/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                	<div class="card shadow mb-4">
                		<div class="card-header py-3">
                            <div class="row">
                                <div class="col head-left">
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Jenis Saldo</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>jenis_saldo/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="jenis_saldo">Jenis Saldo</label>
									<input class="form-control" type="text" name="jenis_saldo" id="jenis_saldo" required>
								</div>
                                <div class="form-group">
                                    <label for="jumlah_saldo">Jumlah Saldo</label>
                                    <input class="form-control" type="number" name="jumlah_saldo" id="jumlah_saldo" required>
                                </div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahJenisSaldo" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
								</div>
							</form>
                        </div>
                    </div>
            	</div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once '../include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include_once '../include/script.php' ?>

</body>

</html>