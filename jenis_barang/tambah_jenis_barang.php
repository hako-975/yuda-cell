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

if (isset($_POST['btnTambahJenisBarang'])) {
	$jenis_barang = htmlspecialchars(ucwords($_POST['jenis_barang']));

	$tambah_jenis_barang = mysqli_query($koneksi, "INSERT INTO jenis_barang VALUES('', '$jenis_barang')");

	if ($tambah_jenis_barang) {
		setAlert("Berhasil!", "Jenis Barang ".$jenis_barang." berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "jenis_barang/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Jenis Barang gagal ditambahkan!", "error");
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
    <title>Tambah Jenis Barang - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Jenis Barang</h5>
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
									<input class="form-control" type="text" name="jenis_barang" id="jenis_barang" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahJenisBarang" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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