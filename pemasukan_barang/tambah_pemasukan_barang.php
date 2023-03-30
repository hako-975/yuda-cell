<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
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

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnTambahPemasukanBarang'])) {
	$id_barang = htmlspecialchars($_POST['id_barang']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = date("Y-m-d H:i:s");
	$jumlah_pemasukan = htmlspecialchars($_POST['jumlah_pemasukan']);

	if ($id_barang == 0) {
		setAlert("Gagal!", "Pilih Barang terlebih dahulu!", "error");
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

	$tambah_pemasukan_barang = mysqli_query($koneksi, "INSERT INTO pemasukan_barang VALUES('', '$id_barang', '$id_supplier', '$tanggal_pemasukan', '$jumlah_pemasukan')");
	$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang + '$jumlah_pemasukan' WHERE id_barang = '$id_barang'");
	if ($tambah_pemasukan_barang) {
		setAlert("Berhasil!", "Pemasukan Barang ".$nama_barang." berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "pemasukan_barang/index.php");
		exit;
	} else {
		setAlert("Gagal!", "Pemasukan Barang gagal ditambahkan!", "error");
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
    <title>Tambah Pemasukan Barang - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Pemasukan Barang</h5>
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
										<option value="0">--- Pilih Nama Barang ---</option>
										<?php foreach ($barang as $db): ?>
											<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="id_supplier">Nama Supplier</label>
									<select name="id_supplier" id="id_supplier" class="custom-select">
										<option value="0">--- Pilih Nama Supplier ---</option>
										<?php foreach ($supplier as $dp): ?>
											<option value="<?= $dp['id_supplier']; ?>"><?= $dp['nama_supplier']; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="jumlah_pemasukan">Jumlah Pemasukan Barang</label>
									<input class="form-control" type="number" name="jumlah_pemasukan" id="jumlah_pemasukan" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahPemasukanBarang" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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