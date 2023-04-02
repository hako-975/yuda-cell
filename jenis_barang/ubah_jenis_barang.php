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
$data_jenis_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jenis_barang WHERE id_jenis_barang = '$id_jenis_barang'"));

if (isset($_POST['btnUbahJenisBarang'])) {
	$jenis_barang = htmlspecialchars($_POST['jenis_barang']);

	$ubah_jenis_barang = mysqli_query($koneksi, "UPDATE jenis_barang SET jenis_barang = '$jenis_barang' WHERE id_jenis_barang = '$id_jenis_barang'");

	if ($ubah_jenis_barang) {
		setAlert("Berhasil!", "Jenis Barang berhasil diubah!", "success");
		header("Location:" . BASE_URL . "jenis_barang/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Jenis Barang gagal diubah!", "error");
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
	<title>Ubah Jenis Barang - <?= $data_jenis_barang['jenis_barang']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Jenis Barang - <?= $data_jenis_barang['jenis_barang']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>jenis_barang/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="jenis_barang">Jenis Barang</label>
									<input class="form-control" type="text" name="jenis_barang" id="jenis_barang" value="<?= $data_jenis_barang['jenis_barang']; ?>" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahJenisBarang" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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