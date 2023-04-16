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

if (isset($_POST['btnTambahProdukStok'])) {
	$nama_produk = htmlspecialchars(ucwords($_POST['nama_produk']));
	$harga_beli = htmlspecialchars($_POST['harga_beli']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$stok = htmlspecialchars($_POST['stok']);

	$tambah_produk_stok = mysqli_query($koneksi, "INSERT INTO produk VALUES('', '$nama_produk', '$harga_beli', '$harga_jual', '$stok', null)");

	if ($tambah_produk_stok) {
		setAlert("Berhasil!", "Produk ".$nama_produk." berhasil ditambahkan!", "success");
		header("Location:" . BASE_URL . "produk/index.php?stok");
		exit;
	} else {
		setAlert("Gagal!", "Produk gagal ditambahkan!", "error");
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
    <title>Tambah Produk Stok - Yuda Cell</title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Tambah Produk Stok</h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>produk/index.php?stok" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="nama_produk">Nama Produk</label>
									<input class="form-control" type="text" name="nama_produk" id="nama_produk" required>
								</div>
								<div class="form-group">
									<label for="harga_beli">Harga Beli</label>
									<input class="form-control" type="number" name="harga_beli" id="harga_beli" required>
								</div>
								<div class="form-group">
									<label for="harga_jual">Harga Jual</label>
									<input class="form-control" type="number" name="harga_jual" id="harga_jual" required>
								</div>
								<div class="form-group">
									<label for="stok">Stok</label>
									<input class="form-control" type="number" name="stok" id="stok" required>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnTambahProdukStok" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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