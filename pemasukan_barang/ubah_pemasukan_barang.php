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

$id_pemasukan_barang = htmlspecialchars($_GET['id_pemasukan_barang']);
$data_pemasukan_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pemasukan_barang INNER JOIN barang ON pemasukan_barang.id_barang = barang.id_barang INNER JOIN supplier ON pemasukan_barang.id_supplier = supplier.id_supplier WHERE id_pemasukan_barang = '$id_pemasukan_barang'"));

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnUbahPemasukanBarang'])) {
	$id_barang = htmlspecialchars($_POST['id_barang']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = htmlspecialchars($_POST['tanggal_pemasukan']);
	$jumlah_pemasukan = htmlspecialchars($_POST['jumlah_pemasukan']);
	$jumlah_pemasukan_old = $data_pemasukan_barang['jumlah_pemasukan'];

	$ubah_pemasukan_barang = mysqli_query($koneksi, "UPDATE pemasukan_barang SET id_barang = '$id_barang', id_supplier = '$id_supplier', tanggal_pemasukan = '$tanggal_pemasukan', jumlah_pemasukan = '$jumlah_pemasukan' WHERE id_pemasukan_barang = '$id_pemasukan_barang'");
	$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = (stok_barang - $jumlah_pemasukan_old) + '$jumlah_pemasukan' WHERE id_barang = '$id_barang'");

	if ($ubah_pemasukan_barang) {
		setAlert("Berhasil!", "Pemasukan Barang berhasil diubah!", "success");
		header("Location:" . BASE_URL . "pemasukan_barang/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Pemasukan Barang gagal diubah!", "error");
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
	<title>Ubah Pemasukan Barang - <?= $data_pemasukan_barang['nama_barang']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Pemasukan Barang - <?= $data_pemasukan_barang['nama_barang']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>pemasukan_barang/index.php" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="id_barang">Nama Barang</label>
									<select name="id_barang" id="id_barang" class="custom-select">
										<option value="<?= $data_pemasukan_barang['id_barang']; ?>"><?= $data_pemasukan_barang['nama_barang']; ?></option>
										<?php foreach ($barang as $db): ?>
											<?php if ($db['id_barang'] != $data_pemasukan_barang['id_barang']): ?>
												<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="id_supplier">Nama Supplier</label>
									<select name="id_supplier" id="id_supplier" class="custom-select">
										<option value="<?= $data_pemasukan_barang['id_supplier']; ?>"><?= $data_pemasukan_barang['nama_supplier']; ?></option>
										<?php foreach ($supplier as $dp): ?>
											<?php if ($dp['id_supplier'] != $data_pemasukan_barang['id_supplier']): ?>
												<option value="<?= $dp['id_supplier']; ?>"><?= $dp['nama_supplier']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="jumlah_pemasukan">Jumlah Pemasukan Barang</label>
									<input class="form-control" type="number" name="jumlah_pemasukan" id="jumlah_pemasukan" required value="<?= $data_pemasukan_barang['jumlah_pemasukan']; ?>">
								</div>
								<div class="form-group">
									<label for="tanggal_pemasukan">Tanggal Pemasukan Barang</label>
									<input class="form-control" type="datetime-local" name="tanggal_pemasukan" id="tanggal_pemasukan" required value="<?= $data_pemasukan_barang['tanggal_pemasukan']; ?>">
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahPemasukanBarang" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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