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

$id_pemasukan = htmlspecialchars($_GET['id_pemasukan']);
$data_pemasukan_jenis_saldo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pemasukan INNER JOIN jenis_saldo ON pemasukan.id_jenis_saldo = jenis_saldo.id_jenis_saldo INNER JOIN supplier ON pemasukan.id_supplier = supplier.id_supplier WHERE id_pemasukan = '$id_pemasukan'"));

$jenis_saldo = mysqli_query($koneksi, "SELECT * FROM jenis_saldo ORDER BY jenis_saldo ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnUbahPemasukanJenisSaldo'])) {
	$id_jenis_saldo = htmlspecialchars($_POST['id_jenis_saldo']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = htmlspecialchars($_POST['tanggal_pemasukan']);
	$jumlah = htmlspecialchars($_POST['jumlah']);
	// $jumlah_old = $data_pemasukan_jenis_saldo['jumlah'];

	$ubah_pemasukan_jenis_saldo = mysqli_query($koneksi, "UPDATE pemasukan SET id_jenis_saldo = '$id_jenis_saldo', id_supplier = '$id_supplier', tanggal_pemasukan = '$tanggal_pemasukan', jumlah = '$jumlah' WHERE id_pemasukan = '$id_pemasukan'");
	// $update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = (stok_barang - $jumlah_old) + '$jumlah' WHERE id_pemasukan = '$id_pemasukan'");

	if ($ubah_pemasukan_jenis_saldo) {
		setAlert("Berhasil!", "Pemasukan Jenis Saldo berhasil diubah!", "success");
		header("Location:" . BASE_URL . "pemasukan/index.php?jenis_saldo");
		exit;
	} else {
		setAlert("Gagal!", "Pemasukan Jenis Saldo gagal diubah!", "error");
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
	<title>Ubah Pemasukan Jenis Saldo - <?= $data_pemasukan_jenis_saldo['jenis_saldo']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Pemasukan Jenis Saldo - <?= $data_pemasukan_jenis_saldo['jenis_saldo']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>pemasukan/index.php?jenis_saldo" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="id_jenis_saldo">Nama Jenis Saldo</label>
									<select name="id_jenis_saldo" id="id_jenis_saldo" class="custom-select">
										<option value="<?= $data_pemasukan_jenis_saldo['id_jenis_saldo']; ?>"><?= $data_pemasukan_jenis_saldo['jenis_saldo']; ?></option>
										<?php foreach ($jenis_saldo as $djs): ?>
											<?php if ($djs['id_jenis_saldo'] != $data_pemasukan_jenis_saldo['id_jenis_saldo']): ?>
												<option value="<?= $djs['id_jenis_saldo']; ?>"><?= $djs['jenis_saldo']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="id_supplier">Nama Supplier</label>
									<select name="id_supplier" id="id_supplier" class="custom-select">
										<option value="<?= $data_pemasukan_jenis_saldo['id_supplier']; ?>"><?= $data_pemasukan_jenis_saldo['nama_supplier']; ?></option>
										<?php foreach ($supplier as $ds): ?>
											<?php if ($ds['id_supplier'] != $data_pemasukan_jenis_saldo['id_supplier']): ?>
												<option value="<?= $ds['id_supplier']; ?>"><?= $ds['nama_supplier']; ?></option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="jumlah">Jumlah Pemasukan Jenis Saldo</label>
									<input class="form-control" type="number" name="jumlah" id="jumlah" required value="<?= $data_pemasukan_jenis_saldo['jumlah']; ?>">
								</div>
								<div class="form-group">
									<label for="tanggal_pemasukan">Tanggal Pemasukan Jenis Saldo</label>
									<input class="form-control" type="datetime-local" name="tanggal_pemasukan" id="tanggal_pemasukan" required value="<?= $data_pemasukan_jenis_saldo['tanggal_pemasukan']; ?>">
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahPemasukanJenisSaldo" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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