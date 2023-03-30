<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}


$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_transaksi = user.id_user WHERE id_transaksi = '$id_transaksi'"));

if (isset($_POST['btnUbahTransaksi'])) {
	$tanggal_transaksi = htmlspecialchars($_POST['tanggal_transaksi']);

	$ubah_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET tanggal_transaksi = '$tanggal_transaksi' WHERE id_transaksi = '$id_transaksi'");

	if ($ubah_transaksi) {
		setAlert("Berhasil!", "Transaksi berhasil diubah!", "success");
		header("Location:" . BASE_URL . "transaksi/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Transaksi gagal diubah!", "error");
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
	<title>Ubah Transaksi - <?= $data_transaksi['id_transaksi']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Transaksi</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>transaksi/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
							<form method="post">
								<div class="form-group">
									<label for="tanggal_transaksi">Tanggal Transaksi</label>
									<input class="form-control" type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi" value="<?= $data_transaksi['tanggal_transaksi']; ?>" required>
								</div>
								<div class="form-group">
									<label for="total_harga">Total Harga</label>
									<input class="form-control" style="cursor: not-allowed;" type="number" disabled name="total_harga" id="total_harga" value="<?= $data_transaksi['total_harga']; ?>" required>
								</div>
								<div class="form-group">
									<label for="bayar">Bayar</label>
									<input class="form-control" style="cursor: not-allowed;" type="number" disabled name="bayar" id="bayar" value="<?= $data_transaksi['bayar']; ?>" required>
								</div>
								<div class="form-group">
									<label for="kembalian">Kembalian</label>
									<input class="form-control" style="cursor: not-allowed;" type="number" disabled name="kembalian" id="kembalian" value="<?= $data_transaksi['kembalian']; ?>" required>
								</div>
								<div class="form-group">
									<label for="id_user">User</label>
									<input class="form-control" style="cursor: not-allowed;" type="text" disabled name="id_user" id="id_user" value="<?= $data_transaksi['username']; ?>" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahTransaksi" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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