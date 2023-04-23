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

$produk = mysqli_query($koneksi, "SELECT id_produk, nama_produk, harga_beli, harga_jual, stok FROM produk WHERE stok <= 0 || stok >= 0 ORDER BY nama_produk ASC");

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnTambahPemasukanStok'])) {
	$id_produk = htmlspecialchars($_POST['id_produk']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = htmlspecialchars($_POST['tanggal_pemasukan']);
	$jumlah = htmlspecialchars($_POST['jumlah']);

	if ($id_produk == 0) {
		setAlert("Gagal!", "Pilih Produk terlebih dahulu!", "error");
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

	$tambah_pemasukan_stok = mysqli_query($koneksi, "INSERT INTO pemasukan VALUES('', '$id_produk', null, '$id_supplier', '$tanggal_pemasukan', '$jumlah')");
	
	
	if ($tambah_pemasukan_stok) {
		$update_stok = mysqli_query($koneksi, "UPDATE produk SET stok = stok + '$jumlah' WHERE id_produk = '$id_produk'");

		setAlert("Berhasil!", "Pemasukan Stok berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "pemasukan/index.php?stok");
		exit;
	} else {
		setAlert("Gagal!", "Pemasukan Stok gagal ditambahkan!", "error");
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
    <title>Tambah Pemasukan Stok - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Pemasukan Stok</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>pemasukan/index.php?stok" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="id_produk">Nama Produk</label>
									<select name="id_produk" id="id_produk" class="custom-select">
										<option value="0">--- Pilih Nama Produk ---</option>
										<?php foreach ($produk as $dp): ?>
											<option value="<?= $dp['id_produk']; ?>"><?= $dp['nama_produk']; ?></option>
										<?php endforeach ?>
									</select>
									<a href="<?= BASE_URL; ?>produk/tambah_produk_stok.php">Tidak Ada Produk? Tambahkan Produk</a>
								</div>
								<div class="form-group">
									<label for="id_supplier">Nama Supplier</label>
									<select name="id_supplier" id="id_supplier" class="custom-select">
										<option value="0">--- Pilih Nama Supplier ---</option>
										<?php foreach ($supplier as $ds): ?>
											<option value="<?= $ds['id_supplier']; ?>"><?= $ds['nama_supplier']; ?></option>
										<?php endforeach ?>
									</select>
									<a href="<?= BASE_URL; ?>supplier/tambah_supplier.php">Tidak Ada Supplier? Tambahkan Supplier</a>
								</div>
								<div class="form-group">
									<label for="jumlah">Jumlah Pemasukan Stok</label>
									<input class="form-control" type="number" name="jumlah" id="jumlah" required>
								</div>
								<div class="form-group">
									<label for="tanggal_pemasukan">Tanggal Pemasukan Stok</label>
									<input type="datetime-local" id="tanggal_pemasukan" class="form-control" name="tanggal_pemasukan" required value="<?= date('Y-m-d H:i'); ?>">
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahPemasukanStok" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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