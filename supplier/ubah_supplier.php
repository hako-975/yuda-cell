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
$data_supplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier = '$id_supplier'"));

if (isset($_POST['btnUbahSupplier'])) {
	$nama_supplier = htmlspecialchars(ucwords($_POST['nama_supplier']));
	$alamat_supplier = htmlspecialchars($_POST['alamat_supplier']);
	$no_telp_supplier = htmlspecialchars($_POST['no_telp_supplier']);

	$ubah_supplier = mysqli_query($koneksi, "UPDATE supplier SET nama_supplier = '$nama_supplier', alamat_supplier = '$alamat_supplier', no_telp_supplier = '$no_telp_supplier' WHERE id_supplier = '$id_supplier'");

	if ($ubah_supplier) {
		setAlert("Berhasil!", "Supplier berhasil diubah!", "success");
		header("Location:" . BASE_URL . "supplier/index.php");
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Jenis Barang</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>jenis_barang/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="nama_supplier">Nama Supplier</label>
									<input class="form-control" type="text" name="nama_supplier" id="nama_supplier" value="<?= $data_supplier['nama_supplier']; ?>" required>
								</div>
								<div class="form-group">
									<label for="alamat_supplier">Alamat Supplier</label>
									<textarea class="form-control" name="alamat_supplier" id="alamat_supplier" required><?= $data_supplier['alamat_supplier']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="no_telp_supplier">No. Telp Supplier</label>
									<input class="form-control" type="number" name="no_telp_supplier" id="no_telp_supplier" value="<?= $data_supplier['no_telp_supplier']; ?>" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahSupplier" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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