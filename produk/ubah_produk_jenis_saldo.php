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

$id_produk = htmlspecialchars($_GET['id_produk']);
$data_produk_saldo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk INNER JOIN jenis_saldo ON produk.id_jenis_saldo = jenis_saldo.id_jenis_saldo WHERE produk.id_produk = '$id_produk'"));

$jenis_saldo = mysqli_query($koneksi, "SELECT * FROM jenis_saldo ORDER BY jenis_saldo ASC");

if (isset($_POST['btnUbahProdukJenisSaldo'])) {
	$nama_produk = htmlspecialchars(ucwords($_POST['nama_produk']));
	$harga_beli = htmlspecialchars($_POST['harga_beli']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$id_jenis_saldo = htmlspecialchars($_POST['id_jenis_saldo']);

	$ubah_produk_jenis_saldo = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$nama_produk', harga_beli = '$harga_beli', harga_jual = '$harga_jual', id_jenis_saldo = '$id_jenis_saldo' WHERE id_produk = '$id_produk'");

	if ($ubah_produk_jenis_saldo) {
		setAlert("Berhasil!", "Produk berhasil diubah!", "success");
		header("Location:" . BASE_URL . "produk/index.php?jenis_saldo");
		exit;
	} else {
		setAlert("Gagal!", "Produk gagal diubah!", "error");
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
	<title>Ubah Produk - <?= $data_produk_saldo['nama_produk']; ?></title>
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
                                    <h5 class="my-auto font-weight-bold text-primary">Ubah Produk - <?= $data_produk_saldo['nama_produk']; ?></h5>
                                </div>
                                <div class="col head-right">
                                    <a href="<?= BASE_URL; ?>produk/index.php?jenis_saldo" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<form method="post">
								<div class="form-group">
									<label for="nama_produk">Nama Produk</label>
									<input class="form-control" type="text" name="nama_produk" id="nama_produk" value="<?= $data_produk_saldo['nama_produk']; ?>" required>
								</div>
								<div class="form-group">
									<label for="harga_beli">Harga Beli</label>
									<input class="form-control" type="number" name="harga_beli" id="harga_beli" value="<?= $data_produk_saldo['harga_beli']; ?>" required>
								</div>
								<div class="form-group">
									<label for="harga_jual">Harga Jual</label>
									<input class="form-control" type="number" name="harga_jual" id="harga_jual" value="<?= $data_produk_saldo['harga_jual']; ?>" required>
								</div>
								<div class="form-group">
									<label for="id_jenis_saldo">Jenis Saldo</label>
									<select name="id_jenis_saldo" id="id_jenis_saldo" class="custom-select">
										<option value="<?= $data_produk_saldo['id_jenis_saldo']; ?>"><?= $data_produk_saldo['jenis_saldo']; ?> (sisa saldo Rp. <?= str_replace(",", ".", number_format($data_produk_saldo['jumlah_saldo'])); ?>)</option>
										<?php foreach ($jenis_saldo as $dpsa): ?>
											<?php if ($data_produk_saldo['id_jenis_saldo'] != $dpsa['id_jenis_saldo']): ?>
												<option value="<?= $dpsa['id_jenis_saldo']; ?>"><?= $dpsa['jenis_saldo']; ?> (sisa saldo Rp. <?= str_replace(",", ".", number_format($dpsa['jumlah_saldo'])); ?>)</option>
											<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group text-right">
									<button type="submit" name="btnUbahProdukJenisSaldo" class="btn btn-primary"><i class="fas fa-fw fa-paper-plane"></i> Kirim</button>
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