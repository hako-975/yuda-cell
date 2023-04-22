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

$jenis_saldo = mysqli_query($koneksi, "SELECT * FROM jenis_saldo ORDER BY jenis_saldo ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnTambahPemasukanJenisSaldo'])) {
	$id_jenis_saldo = htmlspecialchars($_POST['id_jenis_saldo']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = htmlspecialchars($_POST['tanggal_pemasukan']);
	$jumlah = htmlspecialchars($_POST['jumlah']);

	if ($id_jenis_saldo == 0) {
		setAlert("Gagal!", "Pilih Jenis Saldo terlebih dahulu!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	if ($id_supplier == 0) {
		setAlert("Gagal!", "Pilih Supplier terlebih dahulu!", "error");
		echo "
			<script>
				window.history.back();
			</script>
		";
		exit;
	}

	$tambah_pemasukan_jenis_saldo = mysqli_query($koneksi, "INSERT INTO pemasukan VALUES('', null, '$id_jenis_saldo', '$id_supplier', '$tanggal_pemasukan', '$jumlah')");
	
	// $update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang + '$jumlah' WHERE id_jenis_saldo = '$id_jenis_saldo'");
	
	if ($tambah_pemasukan_jenis_saldo) {
		setAlert("Berhasil!", "Pemasukan Jenis Saldo berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "pemasukan/index.php?jenis_saldo");
		exit;
	} else {
		setAlert("Gagal!", "Pemasukan Jenis Saldo gagal ditambahkan!", "error");
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
    <title>Tambah Pemasukan Jenis Saldo - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Pemasukan Jenis Saldo</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>pemasukan/index.php?stok" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="id_jenis_saldo">Nama Jenis Saldo</label>
									<select name="id_jenis_saldo" id="id_jenis_saldo" class="custom-select">
										<option value="0">--- Pilih Nama Jenis Saldo ---</option>
										<?php foreach ($jenis_saldo as $djs): ?>
											<option value="<?= $djs['id_jenis_saldo']; ?>"><?= $djs['jenis_saldo']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="id_supplier">Nama Supplier</label>
									<select name="id_supplier" id="id_supplier" class="custom-select">
										<option value="0">--- Pilih Nama Supplier ---</option>
										<?php foreach ($supplier as $ds): ?>
											<option value="<?= $ds['id_supplier']; ?>"><?= $ds['nama_supplier']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="jumlah">Jumlah Pemasukan Saldo</label>
									<input class="form-control" type="number" name="jumlah" id="jumlah" required>
								</div>
								<div class="form-group">
									<label for="tanggal_pemasukan">Tanggal Pemasukan Saldo</label>
									<input type="datetime-local" id="tanggal_pemasukan" class="form-control" name="tanggal_pemasukan" required value="<?= date('Y-m-d H:i'); ?>">
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahPemasukanJenisSaldo" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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